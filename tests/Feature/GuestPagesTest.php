<?php

namespace Tests\Feature;

use Tests\TestCase;

class GuestPagesTest extends TestCase
{
    public function test_home_page_is_ok()
    {
        $this->get('/')->assertOk();
    }

    public function test_login_page_is_ok()
    {
        $this->get('/login')->assertOk();
    }

    public function test_guest_cannot_open_member_membership_page()
    {
        $this->get('/clanarina')->assertRedirect();
    }

    public function test_guest_cannot_open_admin_panel()
    {
        $this->get('/admin')->assertRedirect();
    }

    public function test_guest_cannot_open_trainer_panel()
    {
        $this->get('/aptreneri')->assertRedirect();
    }
}
