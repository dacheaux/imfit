<?php

namespace Tests;

use App\Account;
use App\GlobalConf;
use App\Plan;
use App\Qrcode;
use App\Term;
use App\User;
use App\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\Support\FakeQrCode;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->seedRoles();
        $this->seedSettings();
        $this->mockQrCode();

        Mail::fake();
        Notification::fake();
    }

    protected function seedRoles()
    {
        Role::findOrCreate('admin', 'web');
        Role::findOrCreate('vežbač', 'web');
        Role::findOrCreate('trener', 'web');
    }

    protected function seedSettings()
    {
        Cache::forget('settings');

        $settings = GlobalConf::query()->first();

        if (! $settings) {
            $settings = GlobalConf::factory()->create();
        }

        config()->set('settings', $settings);
    }

    protected function mockQrCode()
    {
        $this->app->instance('qrcode', new FakeQrCode);
    }

    protected function withAjax()
    {
        return $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
        ]);
    }

    protected function giveAccountAndQr(User $user, $qrType = 0)
    {
        Account::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        Qrcode::create([
            'user_id' => $user->id,
            'token' => 'token-'.$user->id,
            'qrcode_image' => 'qrcode'.$user->id.'.png',
            'type' => $qrType,
        ]);

        return $user;
    }

    protected function createAdmin(array $attributes = [])
    {
        $user = User::factory()->create($attributes);
        $user->assignRole('admin');
        $this->giveAccountAndQr($user, 1);

        return $user;
    }

    protected function createMember(array $attributes = [])
    {
        $user = User::factory()->create(array_merge(['type' => 0], $attributes));
        $user->assignRole('vežbač');
        $this->giveAccountAndQr($user, 0);

        return $user;
    }

    protected function createTrainer(array $attributes = [])
    {
        $user = User::factory()->create($attributes);
        $user->assignRole('trener');
        $this->giveAccountAndQr($user, 1);

        return $user;
    }

    protected function actingAsAdmin(array $attributes = [])
    {
        $user = $this->createAdmin($attributes);
        $this->actingAs($user);

        return $user;
    }

    protected function actingAsMember(array $attributes = [])
    {
        $user = $this->createMember($attributes);
        $this->actingAs($user);

        return $user;
    }

    protected function actingAsTrainer(array $attributes = [])
    {
        $user = $this->createTrainer($attributes);
        $this->actingAs($user);

        return $user;
    }

    protected function createBookableGym()
    {
        $trainer = $this->createTrainer();
        $member = $this->createMember();
        $workout = Workout::factory()->create([
            'name' => 'Pilates',
            'workout_time' => 60,
        ]);
        $plan = Plan::factory()->create([
            'workout_id' => $workout->id,
            'name' => 'Pilates 8',
            'workouts_number' => 8,
            'plan_duration' => 30,
            'price' => '4000',
            'seen' => 0,
        ]);
        $term = Term::factory()->create([
            'workout_id' => $workout->id,
            'trener_id' => $trainer->id,
            'slots' => 5,
        ]);

        return compact('trainer', 'member', 'workout', 'plan', 'term');
    }

    protected function jsonBody($response)
    {
        return json_decode($response->getContent(), true);
    }
}
