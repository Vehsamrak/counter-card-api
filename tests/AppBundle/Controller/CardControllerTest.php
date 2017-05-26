<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Fixture\UserFixture;
use Symfony\Component\HttpFoundation\Request;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class CardControllerTest extends RestTestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    /** @test */
    public function GET_card_401()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_POST, '/api/card');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /** @test */
    public function POST_card_400()
    {
        $parameters = [];

        $this->sendPostRequest('/api/card', $parameters);

        $this->assertEquals(400, $this->getResponseCode());
        $this->assertEquals(['error' => 'Mandatory parameter missed.'], $this->getResponseContents());
    }

    /** @test */
    public function GET_cardLast_401()
    {
        $this->setAuthToken('');
        $this->sendGetRequest('/api/card/last');

        $this->assertEquals(401, $this->getResponseCode());
    }

    /** @test */
    public function GET_cardLast_200AndDateOfLastCreatedCardReturned()
    {
        $this->sendGetRequest('/api/card/last');

        $this->assertEquals(200, $this->getResponseCode());
    }
}
