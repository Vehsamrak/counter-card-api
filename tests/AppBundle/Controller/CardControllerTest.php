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

    const FIRST_USER_ID = '1';
    const FIRST_USER_NAME = 'Adam Smith';
    const FIRST_USER_EMAIL = 'test@test.ru';
    const FIRST_USER_FLAT_NUMBER = 1;
    const FIRST_USER_REGISTRATION_DATE = '2017-06-03 18:00';
    const CARD_ID = '1';

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
                'id'               => self::CARD_ID,
                'createdAt'        => '2017-06-03 18:48',
                'waterCold'        => 2.2,
                'waterHot'         => 1.1,
                'electricityDay'   => 3.3,
                'electricityNight' => 4.4,
                'creator'          => [
                    'id'               => self::FIRST_USER_ID,
                    'name'             => self::FIRST_USER_NAME,
                    'email'            => self::FIRST_USER_EMAIL,
                    'flatNumber'       => self::FIRST_USER_FLAT_NUMBER,
                    'registrationDate' => self::FIRST_USER_REGISTRATION_DATE,
                ],
            ],
            $this->getResponseContents()
        );
    }
}
