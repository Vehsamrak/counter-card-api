<?php

namespace Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Vehsamrak
 */
abstract class RestTestCase extends WebTestCase
{
    protected const TEST_TOKEN = 'test-token';

    /** @var Client */
    protected $httpClient;

    /** {@inheritDoc} */
    protected function setUp(): void
    {
        $this->httpClient = $this->makeClient(
            false,
            [
                'HTTP_AUTH_TOKEN' => self::TEST_TOKEN,
                'Content-Type'    => 'application/json',
            ]
        );
    }

    /** {@inheritDoc} */
    protected function tearDown(): void
    {
        $this->httpClient = null;
        parent::tearDown();
    }

    protected function followRedirects(): void
    {
        $this->httpClient->followRedirects();
    }

    protected function sendGetRequest(string $route): void
    {
        $this->httpClient->request(Request::METHOD_GET, $route);
    }

    protected function sendPostRequest(string $route, array $parameters = []): void
    {
        $this->httpClient->request(Request::METHOD_POST, $route, $parameters);
    }

    protected function sendPutRequest(string $route, array $parameters = []): void
    {
        $this->httpClient->request(Request::METHOD_PUT, $route, $parameters);
    }

    protected function sendDeleteRequest(string $route, array $parameters = []): void
    {
        $this->httpClient->request(Request::METHOD_DELETE, $route, $parameters);
    }

    /**
     * @return array|string
     * @throws \HttpResponseException
     */
    protected function getResponseContents()
    {
        $response = $this->getResponse();
        $responseContents = $response->getContent();

        $jsonEncodedResponseContent = json_decode($responseContents, true);

        if ($jsonEncodedResponseContent) {
            return $jsonEncodedResponseContent;
        }

        if (!$responseContents) {
            throw new \HttpResponseException('Response contents is empty.');
        }

        return $responseContents;
    }

    protected function getResponseCode(): int
    {
        $response = $this->getResponse();

        return $response->getStatusCode();
    }

    protected function getResponse(): ?Response
    {
        return $this->httpClient->getResponse();
    }

    protected function getResponseLocation(): ?string
    {
        return $this->getResponse()->headers->get('Location');
    }

    protected function setAuthToken(string $token): void
    {
        $this->httpClient->setServerParameter('HTTP_AUTH_TOKEN', $token);
    }

    /**
     * Get last created entity from database
     * @param string $entityClass
     * @return mixed
     */
    protected function getLastCreated(string $entityClass)
    {
        $repository = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository($entityClass);
        $allEntities = $repository->findAll();

        return array_pop($allEntities);
    }

    public function assertHttpCode(int $expectedStatusCode)
    {
        parent::assertStatusCode($expectedStatusCode, $this->httpClient);
    }
}
