<?php

namespace AppBundle\Controller;

use AppBundle\Fixture\UserFixture;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class UserControllerTest extends RestTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->loadFixtures(
            [
                UserFixture::class,
            ]
        );
    }

    /** @test */
    public function GET_user_200AndCurrentUserData()
    {
        $this->sendGetRequest('/api/user');

        $this->assertHttpCode(200);
        $this->assertEquals(
            [
                'id'                => '1',
                'name'              => 'Tester',
                'email'             => 'test@test.ru',
                'flat_number'       => 1,
                'registration_date' => '2017-06-03 18:00',
            ],
            $this->getResponseContents()
        );
    }
}
