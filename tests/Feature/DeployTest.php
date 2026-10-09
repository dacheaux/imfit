<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
        $this->assertSame('migrate', $called[1]);
        $this->assertContains('config:cache', $called);
        $this->assertContains('view:cache', $called);
        $this->assertNotContains('route:cache', $called);
    }

    public function test_deploy_url_reports_failed_command()
    {
        config()->set('app.deploy_token', 'secret-token');

        Artisan::shouldReceive('call')->andReturnUsing(fn ($command) => $command === 'migrate' ? 1 : 0);
        Artisan::shouldReceive('output')->andReturn('');

        $this->get('/_deploy/secret-token')
            ->assertStatus(500)
            ->assertSee('FAILED (exit code 1)')
            ->assertSee('Deploy finished with errors.');
    }

    public function test_deploy_url_refuses_to_load_schema_dump_over_existing_data()
    {
        config()->set('app.deploy_token', 'secret-token');
        DB::table('migrations')->delete();

        Artisan::shouldReceive('call')->never();

        $this->get('/_deploy/secret-token')->assertStatus(409);
    }
}
