<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tests\RestTestCase;

/**
 * @author Vehsamrak
 */
class CardControllerTest extends RestTestCase
{

    /** @test */
    public function GET_indexPage_401CodeReturned()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_POST, '/api/card');

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    /** @test */
    public function GET_indexPage_404CodeReturned()
    {
        $client = static::createAuthenticatedClient();
        $parameters = ['test' => 1];

        $client->request(Request::METHOD_POST, '/api/card', $parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"error":"Mandatory parameter missed."}', $client->getResponse()->getContent());
    }

    /** @test */
    public function GET_lastCardTime_200CodeAndDateOfLastCreatedCardReturned()
    {
        $client = static::createAuthenticatedClient();
        $parameters = [];

        $client->request(Request::METHOD_GET, '/api/card/last', $parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
