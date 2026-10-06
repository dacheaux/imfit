<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthAndRolesTest extends TestCase
{
    public function test_member_can_log_in()
    {
        $member = $this->createMember([
            'email' => 'member@example.com',
        ]);

        $this->post('/login', [
            'email' => 'member@example.com',
            'password' => 'password',
        ])->assertRedirect('/');

        $this->assertAuthenticatedAs($member);
    }

    public function test_wrong_password_is_rejected()
    {
        $this->createMember([
            'email' => 'member@example.com',
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'member@example.com',
            'password' => 'wrong-password',
        ])->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_user_can_log_out()
    {
        $this->actingAsMember();

        $this->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_member_cannot_open_admin_or_trainer_panel()
    {
        $this->actingAsMember();

        $this->from('/')->get('/admin')->assertRedirect('/');
        $this->assertGuest();

        $this->actingAsMember();

        $this->from('/')->get('/aptreneri')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_trainer_cannot_open_admin_or_member_booking()
    {
        $this->actingAsTrainer();

        $this->from('/')->get('/admin')->assertRedirect('/');
        $this->assertGuest();

        $this->actingAsTrainer();

        $this->from('/')->get('/zakazi-trening')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_admin_cannot_open_member_booking()
    {
        $this->actingAsAdmin();

        $this->from('/')->get('/zakazi-trening')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_admin_can_open_admin_dashboard()
    {
        $this->actingAsAdmin();

        $this->get('/admin')->assertOk();
    }

    public function test_trainer_can_open_trainer_dashboard()
    {
        $this->actingAsTrainer();

        $this->get('/aptreneri')->assertOk();
    }
}
