<?php

namespace Tests\Feature;

use Tests\TestCase;

class HostingerProductionSessionTest extends TestCase
{
    public function test_secure_session_cookie_defaults_to_https_app_url(): void
    {
        config(['app.url' => 'https://example.com/ojt-monitoring-system']);

        $this->assertTrue(config('session.secure'));
    }
}
