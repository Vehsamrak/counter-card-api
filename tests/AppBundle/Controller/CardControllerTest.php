<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Card;
use AppBundle\Fixture\CardFixture;
use AppBundle\Fixture\UserFixture;
use Ramsey\Uuid\Uuid;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class CardControllerTest extends RestTestCase
{

    const FIRST_USER_ID = 'first-user';
    const FIRST_USER_NAME = 'Adam Smith';
    const FIRST_USER_EMAIL = 'test@test.ru';
    const FIRST_USER_FLAT_NUMBER = 1;
    const FIRST_USER_REGISTRATION_DATE = 1496502000;
    const CARD_ID = '1';
    const VALID_WATER_HOT = 1.1;
    const VALID_WATER_COLD = 2.2;
    const VALID_ELECTRICITY_DAY = 3.3;
    const VALID_ELECTRICITY_NIGHT = 4.4;
    const INVALID_PARAMETER = 'string';

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
    public function POST_card_401(): void
    {
        $this->setAuthToken('');
        $this->sendPostRequest('/api/card');

        $this->assertHttpCode(401);
    }

    /**
     * @test
     * @dataProvider getInvalidCardParameters
     */
    public function POST_card_400(array $parameters): void
    {
        $this->sendPostRequest('/api/card', $parameters);

        $this->assertHttpCode(400);
        $this->assertEquals(['error' => 'Mandatory parameter missed.'], $this->getResponseContents());
    }

    /**
     * @test
     * @dataProvider getValidCardParameters
     */
    public function POST_cardWhenLastCardWasCreatedInPreviousMonth_201(array $parameters): void
    {
        $this->givenCardCreatedDaysAgoByUser(30, self::FIRST_USER_ID);

        $this->sendPostRequest('/api/card', $parameters);

        $this->assertHttpCode(201);
    }

    /**
     * @test
     * @dataProvider getValidCardParameters
     */
    public function POST_cardWhenLastCardWasCreatedInCurrentMonth_403(array $parameters): void
    {
        $this->givenCardCreatedInCurrentMonthByUser(self::FIRST_USER_ID);

        $this->sendPostRequest('/api/card', $parameters);

        $this->assertHttpCode(403);
    }

    /** @test */
    public function GET_cardLast_401(): void
    {
        $this->setAuthToken('');
        $this->sendGetRequest('/api/card/last');

        $this->assertHttpCode(401);
    }

    /** @test */
    public function GET_cardLast_200AndDateOfLastCreatedCardReturned(): void
    {
        $this->sendGetRequest('/api/card/last');

        $this->assertHttpCode(200);
        $this->assertEquals(
            [
                'id'               => self::CARD_ID,
                'createdAt'        => 1464968880,
                'waterCold'        => self::VALID_WATER_COLD,
                'waterHot'         => self::VALID_WATER_HOT,
                'electricityDay'   => self::VALID_ELECTRICITY_DAY,
                'electricityNight' => self::VALID_ELECTRICITY_NIGHT,
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

    public function getValidCardParameters(): array
    {
        return [
            [
                [
                    'waterHot'         => self::VALID_WATER_HOT,
                    'waterCold'        => self::VALID_WATER_COLD,
                    'electricityDay'   => self::VALID_ELECTRICITY_DAY,
                    'electricityNight' => self::VALID_ELECTRICITY_NIGHT,
                ],
            ],
        ];
    }

    public function getInvalidCardParameters(): array
    {
        return [
            [[]],
            [
                [
                    'waterHot'         => self::INVALID_PARAMETER,
                    'waterCold'        => self::VALID_WATER_COLD,
                    'electricityDay'   => self::VALID_ELECTRICITY_DAY,
                    'electricityNight' => self::VALID_ELECTRICITY_NIGHT,
                ],
            ],
            [
                [
                    'waterHot'         => self::VALID_WATER_HOT,
                    'waterCold'        => self::INVALID_PARAMETER,
                    'electricityDay'   => self::VALID_ELECTRICITY_DAY,
                    'electricityNight' => self::VALID_ELECTRICITY_NIGHT,
                ],
            ],
            [
                [
                    'waterHot'         => self::VALID_WATER_HOT,
                    'waterCold'        => self::VALID_WATER_COLD,
                    'electricityDay'   => self::INVALID_PARAMETER,
                    'electricityNight' => self::VALID_ELECTRICITY_NIGHT,
                ],
            ],
            [
                [
                    'waterHot'         => self::VALID_WATER_HOT,
                    'waterCold'        => self::VALID_WATER_COLD,
                    'electricityDay'   => self::VALID_ELECTRICITY_DAY,
                    'electricityNight' => self::INVALID_PARAMETER,
                ],
            ],
        ];
    }

    private function givenCardCreatedDaysAgoByUser(int $daysAgo, string $userId)
    {
        $ago20Days = (new \DateTime(sprintf('-%s days', $daysAgo)))->format(DATE_ISO8601);

        $userRepository = $this->getContainer()->get('counter_card.user_repository');
        $cardRepository = $this->getContainer()->get('counter_card.card_repository');
        $user = $userRepository->find($userId);

        $card = new Card(
            $user, 1.1, 2.2, 3.3, 4.4,
            CardFixture::createIdGeneratorThatReturns(Uuid::uuid4()),
            CardFixture::createDateTimeFactoryThatReturns($ago20Days)
        );

        $cardRepository->persist($card);
        $cardRepository->flush($card);
    }

    private function givenCardCreatedInCurrentMonthByUser(string $userId)
    {
        $firstDayOfCurrentMonth = date('Y-m-01\TH:i:sO');

        $userRepository = $this->getContainer()->get('counter_card.user_repository');
        $cardRepository = $this->getContainer()->get('counter_card.card_repository');
        $user = $userRepository->find($userId);

        $card = new Card(
            $user, 1.1, 2.2, 3.3, 4.4,
            CardFixture::createIdGeneratorThatReturns(Uuid::uuid4()),
            CardFixture::createDateTimeFactoryThatReturns($firstDayOfCurrentMonth)
        );

        $cardRepository->persist($card);
        $cardRepository->flush($card);
    }
}
