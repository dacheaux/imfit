<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DeployTest extends TestCase
{
    public function test_deploy_url_is_disabled_without_token()
    {
        config()->set('app.deploy_token', null);

        $this->get('/_deploy/anything')->assertNotFound();
    }

    public function test_deploy_url_rejects_wrong_token()
    {
        config()->set('app.deploy_token', 'secret-token');

        $this->get('/_deploy/wrong-token')->assertNotFound();
    }

    public function test_deploy_url_runs_post_deploy_commands()
    {
        config()->set('app.deploy_token', 'secret-token');

        $called = [];
        Artisan::shouldReceive('call')->andReturnUsing(function ($command) use (&$called) {
            $called[] = $command;

            return 0;
        });
        Artisan::shouldReceive('output')->andReturn("ok\n");

        $this->get('/_deploy/secret-token')
            ->assertOk()
            ->assertSee('Deploy finished OK.');

        $this->assertSame('optimize:clear', $called[0]);
        $this->assertNotContains('migrate', $called);
        $this->assertContains('config:cache', $called);
        $this->assertContains('view:cache', $called);
        $this->assertNotContains('route:cache', $called);
    }

    public function test_deploy_url_reports_failed_command()
    {
        config()->set('app.deploy_token', 'secret-token');

        Artisan::shouldReceive('call')->andReturnUsing(fn ($command) => $command === 'config:cache' ? 1 : 0);
        Artisan::shouldReceive('output')->andReturn('');

        $this->get('/_deploy/secret-token')
            ->assertStatus(500)
            ->assertSee('FAILED (exit code 1)')
            ->assertSee('Deploy finished with errors.');
    }
}
