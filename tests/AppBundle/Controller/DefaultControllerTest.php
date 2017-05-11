<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/** {@inheritDoc} */
class DefaultControllerTest extends WebTestCase
{

    /** @test */
    public function GET_indexPage_302CodeReturned()
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
