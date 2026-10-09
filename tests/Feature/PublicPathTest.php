<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPathTest extends TestCase
{
    public function test_public_path_is_sibling_public_html_when_present()
    {
        $publicHtml = realpath(base_path('../public_html'));

        if ($publicHtml === false) {
            $this->markTestSkipped('public_html sibling folder is missing');
        }

        $this->assertSame($publicHtml, public_path());
    }
}
