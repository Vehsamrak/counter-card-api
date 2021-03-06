<?php

namespace AppBundle\Controller;

use AppBundle\Fixture\UserFixture;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class UserControllerTest extends RestTestCase
{
    const FIRST_USER_ID = 'first-user';
    const FIRST_USER_NAME = 'Adam Smith';
    const FIRST_USER_EMAIL = 'test@test.ru';
    const FIRST_USER_FLAT_NUMBER = 1;
    const FIRST_USER_REGISTRATION_DATE = 1496502000;

    /** {@inheritDoc} */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures(
            [
                UserFixture::class,
            ]
        );
    }

    /** @test */
    public function GET_user_200AndCurrentUserData(): void
    {
        $this->sendGetRequest('/api/user');

        $this->assertHttpCode(200);
        $this->assertEquals(
            [
                'id'               => self::FIRST_USER_ID,
                'name'             => self::FIRST_USER_NAME,
                'email'            => self::FIRST_USER_EMAIL,
                'flatNumber'       => self::FIRST_USER_FLAT_NUMBER,
                'registrationDate' => self::FIRST_USER_REGISTRATION_DATE,
                'isConfirmed'      => true,
            ],
            $this->getResponseContents()
        );
    }
}
