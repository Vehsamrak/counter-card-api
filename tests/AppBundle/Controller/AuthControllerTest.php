<?php

namespace AppBundle\Controller;

use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class AuthControllerTest extends RestTestCase
{

    protected function setUp()
    {
        $this->httpClient = $this->makeClient();
    }

    /** @test */
    public function POST_loginWithoutParameters_400(): void
    {
        $this->sendPostRequest('/api/login');

        $this->assertHttpCode(400);
    }

    /** @test */
    public function POST_loginWithInvalidLoginAndPassword_403(): void
    {
        $parameters = [
            'login'    => 'invalid-login',
            'password' => 'invalid-password',
        ];

        $this->sendPostRequest('/api/login', $parameters);

        $this->assertHttpCode(403);
    }
}
