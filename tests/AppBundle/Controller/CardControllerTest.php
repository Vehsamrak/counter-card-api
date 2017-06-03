<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Fixture\CardFixture;
use AppBundle\Fixture\UserFixture;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class CardControllerTest extends RestTestCase
{

    protected function setUp()
    {
        parent::setUp();
        $this->loadFixtures(
            [
                UserFixture::class,
                CardFixture::class,
            ]
        );
    }

    /** @test */
    public function POST_card_401()
    {
        $this->setAuthToken('');
        $this->sendPostRequest('/api/card');

        $this->assertHttpCode(401);
    }

    /** @test */
    public function POST_card_400()
    {
        $parameters = [];

        $this->sendPostRequest('/api/card', $parameters);

        $this->assertHttpCode(400);
        $this->assertEquals(['error' => 'Mandatory parameter missed.'], $this->getResponseContents());
    }

    /** @test */
    public function GET_cardLast_401()
    {
        $this->setAuthToken('');
        $this->sendGetRequest('/api/card/last');

        $this->assertHttpCode(401);
    }

    /** @test */
    public function GET_cardLast_200AndDateOfLastCreatedCardReturned()
    {
        $this->sendGetRequest('/api/card/last');

        $this->assertHttpCode(200);
        $this->assertEquals(
            [
                'id'                => '1',
                'created_at'        => '2017-06-03 18:48',
                'water_cold'        => 2.2,
                'water_hot'         => 1.1,
                'electricity_day'   => 3.3,
                'electricity_night' => 4.4,
                'creator'           => [
                    'id'                => '1',
                    'name'              => 'Tester',
                    'email'             => 'test@test.ru',
                    'flat_number'       => 1,
                    'registration_date' => '2017-06-03 18:00',
                ],
            ],
            $this->getResponseContents()
        );
    }
}
