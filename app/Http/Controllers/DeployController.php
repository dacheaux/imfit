<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Throwable;

class DeployController extends Controller
{
    /**
     * Run post-deploy tasks on hosting without a terminal.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function __invoke($token)
    {
        $expected = (string) config('app.deploy_token');

        if ($expected === '' || ! hash_equals($expected, (string) $token)) {
            abort(404);
        }

        // With no recorded migrations, migrate would load database/schema/mysql-schema.dump,
        // which drops and recreates every table.
        if (! app('migrator')->hasRunAnyMigrations()) {
            return response("Refusing to deploy: the migrations table is missing or empty.\n", 409)
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        $commands = [
            ['optimize:clear', []],
            ['migrate', ['--force' => true]],
        ];

        if (! file_exists(public_path('storage'))) {
            $commands[] = ['storage:link', []];
        }

        // route:cache is skipped because routes/web.php has a closure route.
        $commands[] = ['config:cache', []];
        $commands[] = ['view:cache', []];

        $output = '';
        $failed = false;

        foreach ($commands as [$command, $parameters]) {
            $output .= "> php artisan {$command}\n";

            try {
                $exitCode = Artisan::call($command, $parameters);
                $output .= Artisan::output();
            } catch (Throwable $e) {
                $exitCode = 1;
                $output .= get_class($e).': '.$e->getMessage()."\n";
            }

            if ($exitCode !== 0) {
                $failed = true;
                $output .= "FAILED (exit code {$exitCode})\n";
            }

            $output .= "\n";
        }

        $output .= $failed ? "Deploy finished with errors.\n" : "Deploy finished OK.\n";

        return response($output, $failed ? 500 : 200)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
