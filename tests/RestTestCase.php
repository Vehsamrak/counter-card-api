<?php

namespace Tests;

use AppBundle\Service\Security\TokenAuthenticator;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Vehsamrak
 */
class RestTestCase extends WebTestCase
{
    const TEST_TOKEN = 'test-token';

    protected static function createAuthenticatedClient(array $options = []): Client
    {
        return parent::createClient($options, [
            'HTTP_' . TokenAuthenticator::TOKEN_HEADER => self::TEST_TOKEN
        ]);
    }
}
