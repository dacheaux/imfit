<?php

namespace Tests\Feature;

use App\Notifications\ApprovedPlanNotification;
use App\Plan;
use App\Qrcode;
use App\Term;
use App\User;
use App\UserPlan;
use App\Workout;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminFlowTest extends TestCase
{
    public function test_admin_dashboard_is_ok()
    {
        $this->actingAsAdmin();

        $this->get('/admin')->assertOk();
    }

    public function test_admin_can_create_a_workout()
    {
        $this->actingAsAdmin();

        $this->post('/admin/workouts', [
            'name' => 'Joga',
            'workout_time' => 45,
        ])->assertRedirect(route('admin.workouts.index'));

        $this->assertDatabaseHas('workouts', [
            'name' => 'Joga',
            'workout_time' => 45,
        ]);
    }

    public function test_admin_can_create_a_plan()
    {
        $this->actingAsAdmin();
        $workout = Workout::factory()->create();

        $this->post('/admin/plans', [
            'workout_id' => $workout->id,
            'name' => 'Joga 8',
            'workouts_number' => 8,
            'plan_duration' => 30,
            'price' => 4000,
        ])->assertRedirect(route('admin.plans.index'));

        $this->assertDatabaseHas('plans', [
            'workout_id' => $workout->id,
            'name' => 'Joga 8',
            'workouts_number' => 8,
            'plan_duration' => 30,
            'price' => '4000',
        ]);
    }

    public function test_admin_can_create_a_class_slot()
    {
        $this->actingAsAdmin();
        $trainer = $this->createTrainer();
        $workout = Workout::factory()->create(['workout_time' => 60]);
        $start = Carbon::now()->addDays(2)->setTime(18, 0, 0);

        $this->post('/admin/terms', [
            'workout_id' => $workout->id,
            'trener_id' => $trainer->id,
            'slots' => 8,
            'note' => 'Evening class',
            'start_datetime' => $start->toDateTimeString(),
        ])->assertRedirect(route('admin.terms.index'));

        $term = Term::query()->first();
        $this->assertNotNull($term);
        $this->assertEquals($workout->id, $term->workout_id);
        $this->assertEquals($trainer->id, $term->trener_id);
        $this->assertEquals(8, $term->slots);
        $this->assertTrue($term->end_datetime->equalTo($start->copy()->addMinutes(60)));
    }

    public function test_admin_can_create_a_member()
    {
        $this->actingAsAdmin();
        $roleId = Role::findByName('vežbač', 'web')->id;

        $this->post('/admin/users', [
            'type' => 0,
            'name' => 'Ana',
            'lastname' => 'Petrovic',
            'email' => 'ana@example.com',
            'phone' => '011/000-111',
            'birth' => '1992-03-10',
            'roles' => $roleId,
        ])->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'ana@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('vežbač'));
        $this->assertDatabaseHas('qrcodes', ['user_id' => $user->id]);
        $this->assertDatabaseHas('accounts', [
            'user_id' => $user->id,
            'balance' => 0,
        ]);
    }

    public function test_admin_can_approve_and_mark_pack_paid()
    {
        $this->actingAsAdmin();
        $member = $this->createMember();
        $plan = Plan::factory()->create();
        $userPlan = UserPlan::factory()->pending()->create([
            'user_id' => $member->id,
            'plan_id' => $plan->id,
            'terms_number' => $plan->workouts_number,
        ]);

        $this->put('/admin/updatePlan/'.$userPlan->id, [
            'approved' => 'true',
        ])->assertOk()->assertJson(['statut' => 'ok']);

        $this->put('/admin/updatePlan/'.$userPlan->id, [
            'paid' => 'true',
        ])->assertOk()->assertJson(['statut' => 'ok']);

        $this->assertDatabaseHas('user_plans', [
            'id' => $userPlan->id,
            'approved' => 1,
            'paid' => 1,
        ]);

        Notification::assertSentTo($member, ApprovedPlanNotification::class);
    }

    public function test_admin_can_edit_user_without_qrcode()
    {
        $this->actingAsAdmin();
        $member = User::factory()->member()->create();

        $this->get('/admin/users/'.$member->id.'/edit')
            ->assertOk()
            ->assertSee('Kreiraj QR kod')
            ->assertSee('Korisnik nema QR kod.');
    }

    public function test_admin_can_generate_qrcode_for_user()
    {
        $this->actingAsAdmin();
        $member = User::factory()->member()->create();

        $this->post('/admin/users/'.$member->id.'/qrcode')
            ->assertRedirect(route('admin.users.edit', $member->id));

        $this->assertDatabaseHas('qrcodes', [
            'user_id' => $member->id,
            'qrcode_image' => 'qrcode'.$member->id.'.png',
            'type' => 0,
        ]);

        $this->get('/admin/users/'.$member->id.'/edit')
            ->assertOk()
            ->assertDontSee('Kreiraj QR kod');
    }

    public function test_generating_qrcode_twice_does_not_duplicate()
    {
        $this->actingAsAdmin();
        $member = User::factory()->member()->create();

        $this->post('/admin/users/'.$member->id.'/qrcode');
        $this->post('/admin/users/'.$member->id.'/qrcode')
            ->assertRedirect(route('admin.users.edit', $member->id));

        $this->assertEquals(1, Qrcode::where('user_id', $member->id)->count());
    }

    public function test_member_cannot_generate_user_qrcode()
    {
        $this->actingAsMember();
        $member = User::factory()->member()->create();

        $this->from('/')->post('/admin/users/'.$member->id.'/qrcode')->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('qrcodes', ['user_id' => $member->id]);
    }
}
