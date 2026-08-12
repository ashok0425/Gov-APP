<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendHostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app->detectEnvironment(fn () => 'production');
        config(['app.frontend_host' => 'appfront.ymhosting.com']);
    }

    public function test_root_on_an_admin_host_goes_to_the_panel(): void
    {
        $this->get('http://palika.ymhosting.com/')->assertRedirect('/login');
    }

    public function test_other_frontend_routes_stay_hidden_on_an_admin_host(): void
    {
        $this->get('http://palika.ymhosting.com/settings')->assertNotFound();
    }
}
