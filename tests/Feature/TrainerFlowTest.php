<?php

namespace Tests\Feature;

use App\UserPlan;
use App\UserTerm;
use Tests\TestCase;

class TrainerFlowTest extends TestCase
{
    public function test_trainer_dashboard_is_ok()
    {
        $this->actingAsTrainer();

        $this->get('/aptreneri')->assertOk();
    }

    public function test_trainer_can_see_calendar_and_booked_member()
    {
        $gym = $this->createBookableGym();
        $trainer = $gym['trainer'];
        $member = $gym['member'];
        $term = $gym['term'];

        $userPlan = UserPlan::factory()->active()->create([
            'user_id' => $member->id,
            'plan_id' => $gym['plan']->id,
            'terms_number' => 7,
        ]);

        UserTerm::factory()->create([
            'user_id' => $member->id,
            'term_id' => $term->id,
            'user_plan_id' => $userPlan->id,
            'user_delayed' => 0,
        ]);

        $this->actingAs($trainer);

        $this->get('/aptreneri/terms')->assertOk();

        $calendar = $this->withAjax()->get('/aptreneri/dataTerms');
        $calendar->assertOk();
        $this->assertStringContainsString($member->name, $calendar->getContent());
        $this->assertStringContainsString('Pilates', $calendar->getContent());

        $this->get('/aptreneri/terms/'.$term->id)
            ->assertOk()
            ->assertSee($member->name)
            ->assertSee($member->lastname);
    }

    public function test_trainer_can_open_entrances_log()
    {
        $this->actingAsTrainer();

        $this->get('/aptreneri/entrances')->assertOk();
    }

    public function test_trainer_cannot_book_a_class()
    {
        $gym = $this->createBookableGym();
        $this->actingAs($gym['trainer']);

        $this->from('/aptreneri/terms')
            ->withAjax()
            ->post('/bookingTerms', ['id' => $gym['term']->id])
            ->assertRedirect();

        $this->assertGuest();
        $this->assertDatabaseMissing('user_terms', [
            'term_id' => $gym['term']->id,
        ]);
    }
}
