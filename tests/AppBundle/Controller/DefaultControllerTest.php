<?php

namespace Tests\AppBundle\Controller;

use Tests\RestTestCase;

/** {@inheritDoc} */
class DefaultControllerTest extends RestTestCase
{

    /** @test */
    public function GET_index_200()
    {
        $this->followRedirects();
        $this->sendGetRequest('/api');

        $this->assertHttpCode(200);
        $this->assertEquals('api documentation', $this->getResponseContents());
    }
}
