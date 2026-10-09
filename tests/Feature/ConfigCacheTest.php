<?php

namespace Tests\Feature;

use Tests\TestCase;

class ConfigCacheTest extends TestCase
{
    public function test_configuration_is_serializable()
    {
        try {
            $this->artisan('config:cache')->assertSuccessful();
        } finally {
            $this->artisan('config:clear');
        }
    }
}
