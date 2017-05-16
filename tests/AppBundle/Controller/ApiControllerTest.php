<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vehsamrak
 */
class ApiControllerTest extends WebTestCase
{

    /** @test */
    public function GET_indexPage_404CodeReturned()
    {
        $client = static::createClient();
        $parameters = ['test' => 1];

        $client->request(Request::METHOD_POST, '/api/card', $parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"error":"Mandatory parameter missed."}', $client->getResponse()->getContent());
    }

    /** @test */
    public function GET_lastCardTime_200CodeAndDateOfLastCreatedCardReturned()
    {
        $client = static::createClient();
        $parameters = [];

        $client->request(Request::METHOD_GET, '/api/card/last', $parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
