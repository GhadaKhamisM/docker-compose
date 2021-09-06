<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Response;

class LoginTest extends TestCase
{
    /**
     * A basic feature test admin login.
     *
     * @return void
     */
    public function testAdminLogin()
    {
        $response = $this->post(route('auth.admin-login'), [
            'username' => config('admin.SUPPER_ADMIN_USERNAME'),
            'password' => config('admin.SUPPER_ADMIN_PASSWORD'),
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
