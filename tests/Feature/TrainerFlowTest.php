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

    public function test_privileged_trainer_can_open_users_index()
    {
        $this->actingAsTrainer(['id' => 13]);

        $this->get('/aptreneri/users')->assertOk();
    }

    public function test_other_trainers_cannot_open_users_index()
    {
        $this->actingAsTrainer();

        $this->get('/aptreneri/users')->assertNotFound();
    }

    public function test_privileged_trainer_cannot_edit_admin()
    {
        $this->actingAsTrainer(['id' => 13]);
        $admin = $this->createAdmin();

        $this->from('/aptreneri/users')
            ->get('/aptreneri/users/'.$admin->id.'/edit')
            ->assertRedirect('/aptreneri/users')
            ->assertSessionHasErrors('message');
    }

    public function test_privileged_trainer_cannot_delete_admin()
    {
        $this->actingAsTrainer(['id' => 13]);
        $admin = $this->createAdmin();

        $this->from('/aptreneri/users')
            ->delete('/aptreneri/users/'.$admin->id)
            ->assertRedirect('/aptreneri/users')
            ->assertSessionHasErrors('message');

        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_users_data_renders_qrcode_from_token()
    {
        $this->actingAsTrainer(['id' => 13]);
        $member = $this->createMember();

        $response = $this->withAjax()->get('/aptreneri/usersData');

        $response->assertOk();
        $body = $this->jsonBody($response);
        $this->assertNotEmpty($body['data']);
        $this->assertStringContainsString('data:image/png;base64', $body['data'][0]['qrcode']);
        $this->assertTrue(collect($body['data'])->contains(function ($row) use ($member) {
            return $row['email'] === $member->email;
        }));
    }
}
