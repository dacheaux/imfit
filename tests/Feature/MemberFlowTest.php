<?php

namespace Tests\Feature;

use App\Term;
use App\UserPlan;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MemberFlowTest extends TestCase
{
    public function test_member_orders_activates_books_and_cancels_a_class()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];
        $plan = $gym['plan'];
        $term = $gym['term'];
        $admin = $this->createAdmin();

        $this->actingAs($member);

        $this->get('/clanarina')->assertOk();

        $this->post('/poruci-paket', [
            'plan_id' => $plan->id,
        ])->assertRedirect();

        $userPlan = UserPlan::where('user_id', $member->id)->where('plan_id', $plan->id)->first();
        $this->assertNotNull($userPlan);
        $this->assertEquals(8, $userPlan->terms_number);
        $this->assertEquals(0, $userPlan->approved);
        $this->assertEquals(0, $userPlan->active);

        $this->actingAs($admin);
        $this->put('/admin/updatePlan/'.$userPlan->id, ['approved' => 'true'])->assertJson(['statut' => 'ok']);
        $this->put('/admin/updatePlan/'.$userPlan->id, ['paid' => 'true'])->assertJson(['statut' => 'ok']);

        $this->actingAs($member);
        $this->post('/aktiviraj-paket', ['id' => $userPlan->id])->assertRedirect();

        $userPlan->refresh();
        $this->assertEquals(1, $userPlan->active);
        $this->assertTrue($userPlan->expired_time->greaterThan(Carbon::now()->addDays(29)));

        $this->get('/zakazi-trening')->assertOk();

        $calendar = $this->withAjax()->get('/dataTerms');
        $calendar->assertOk();
        $this->assertStringContainsString('Pilates', $calendar->getContent());

        $book = $this->withAjax()->post('/bookingTerms', ['id' => $term->id]);
        $book->assertOk();
        $booked = $this->jsonBody($book);
        $this->assertTrue($booked['booked']);

        $this->assertDatabaseHas('user_terms', [
            'user_id' => $member->id,
            'term_id' => $term->id,
            'user_plan_id' => $userPlan->id,
            'user_delayed' => 0,
        ]);
        $this->assertEquals(4, $term->fresh()->slots);
        $this->assertEquals(7, $userPlan->fresh()->terms_number);

        $userTerm = $member->ownerTerms()->first();

        $this->get('/termini')->assertOk();

        $cancel = $this->withAjax()->post('/odlozi-termin', [
            'user_id' => $member->id,
            'user_terms_id' => $userTerm->id,
        ]);
        $cancel->assertOk();
        $this->assertTrue($this->jsonBody($cancel)['status']);

        $this->assertDatabaseHas('user_terms', [
            'id' => $userTerm->id,
            'user_delayed' => 1,
        ]);
        $this->assertEquals(5, $term->fresh()->slots);
        $this->assertEquals(8, $userPlan->fresh()->terms_number);
    }

    public function test_booking_inside_cutoff_is_rejected()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];
        $term = $gym['term'];

        $term->start_datetime = Carbon::now()->addHours(1);
        $term->end_datetime = Carbon::now()->addHours(2);
        $term->save();

        UserPlan::factory()->active()->create([
            'user_id' => $member->id,
            'plan_id' => $gym['plan']->id,
            'terms_number' => 8,
        ]);

        $this->actingAs($member);

        $book = $this->withAjax()->post('/bookingTerms', ['id' => $term->id]);
        $this->assertFalse($this->jsonBody($book)['booked']);
        $this->assertDatabaseMissing('user_terms', [
            'user_id' => $member->id,
            'term_id' => $term->id,
        ]);
    }

    public function test_member_cannot_book_the_same_slot_twice()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];
        $term = $gym['term'];

        UserPlan::factory()->active()->create([
            'user_id' => $member->id,
            'plan_id' => $gym['plan']->id,
            'terms_number' => 8,
        ]);

        $this->actingAs($member);
        $this->withAjax()->post('/bookingTerms', ['id' => $term->id]);

        $second = $this->jsonBody($this->withAjax()->post('/bookingTerms', ['id' => $term->id]));
        $this->assertTrue($second['has_booked']);
        $this->assertFalse($second['booked']);
        $this->assertEquals(1, $member->ownerTerms()->count());
    }

    public function test_cancel_inside_cutoff_is_rejected()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];
        $term = $gym['term'];

        $term->start_datetime = Carbon::now()->addHours(4);
        $term->end_datetime = Carbon::now()->addHours(5);
        $term->save();

        $userPlan = UserPlan::factory()->active()->create([
            'user_id' => $member->id,
            'plan_id' => $gym['plan']->id,
            'terms_number' => 8,
        ]);

        $this->actingAs($member);
        $this->withAjax()->post('/bookingTerms', ['id' => $term->id]);

        $userTerm = $member->ownerTerms()->first();
        $this->assertNotNull($userTerm);

        $cancel = $this->jsonBody($this->withAjax()->post('/odlozi-termin', [
            'user_id' => $member->id,
            'user_terms_id' => $userTerm->id,
        ]));

        $this->assertFalse($cancel['status']);
        $this->assertEquals(0, $userTerm->fresh()->user_delayed);
        $this->assertEquals(7, $userPlan->fresh()->terms_number);
    }

    public function test_unapproved_pack_cannot_be_activated()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];

        $userPlan = UserPlan::factory()->pending()->create([
            'user_id' => $member->id,
            'plan_id' => $gym['plan']->id,
            'terms_number' => 8,
        ]);

        $this->actingAs($member)
            ->from('/clanarina')
            ->post('/aktiviraj-paket', ['id' => $userPlan->id])
            ->assertRedirect('/clanarina');

        $this->assertEquals(0, $userPlan->fresh()->active);
    }

    public function test_member_cannot_book_without_an_active_plan()
    {
        $gym = $this->createBookableGym();
        $member = $gym['member'];
        $term = $gym['term'];

        $this->actingAs($member);

        $book = $this->jsonBody($this->withAjax()->post('/bookingTerms', ['id' => $term->id]));
        $this->assertFalse($book['booked']);
        $this->assertDatabaseMissing('user_terms', [
            'user_id' => $member->id,
            'term_id' => $term->id,
        ]);
    }
}
