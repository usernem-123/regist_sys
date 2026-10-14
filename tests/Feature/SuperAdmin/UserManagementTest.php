<?php

namespace Tests\Feature\SuperAdmin;

use Tests\TestCase;

class UserManagementTest extends TestCase
{
    public function test_home_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}