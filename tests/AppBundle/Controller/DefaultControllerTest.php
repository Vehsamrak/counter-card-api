<?php

namespace Tests\AppBundle\Controller;

use Tests\RestTestCase;

/** {@inheritDoc} */
class DefaultControllerTest extends RestTestCase
{

    /** @test */
    public function GET_index_200()
    {
        $this->sendGetRequest('/');

        $this->assertEquals(200, $this->getResponseCode());
    }
}
