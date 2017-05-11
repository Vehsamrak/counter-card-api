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

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertEquals('{"error":"Mandatory parameter missed."}', $client->getResponse()->getContent());
    }
}
