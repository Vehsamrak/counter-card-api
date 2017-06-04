<?php

namespace AppBundle\Controller\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Vehsamrak
 */
abstract class AbstractRestController extends Controller
{

    const FORMAT_JSON = 'json';

    public function respond($response): Response
    {
        $serializer = $this->get('jms_serializer');

        if ($response instanceof JsonResponse) {
            $serializedData = $serializer->serialize($response->getContent(), self::FORMAT_JSON);
            $statusCode = $response->getStatusCode();
        } else {
            $serializedData = $this->serialize($response);
            $statusCode = JsonResponse::HTTP_OK;
        }

        $response = new Response($serializedData, $statusCode, ['Content-Type' => 'application/json']);

        return $response;
    }

    private function serialize($data): string
    {
        $serializer = $this->get('jms_serializer');
        $serializedData = $serializer->serialize($data, self::FORMAT_JSON);

        return $serializedData ?? '';
    }
}
