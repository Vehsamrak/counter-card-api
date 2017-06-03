<?php

namespace AppBundle\Controller\Infrastructure;

use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Vehsamrak
 */
abstract class AbstractRestController extends Controller
{

    const FORMAT_JSON = 'json';
    /** @var Serializer */
    private $serializer;

    public function respond($response): Response
    {
        $serializer = $this->get('jms_serializer');

        if ($response instanceof JsonResponse) {
            $serializedData = $serializer->serialize($response->getContent(), self::FORMAT_JSON);
        } else {
            $serializedData = $this->serialize($response);
        }

        $response = new Response($serializedData, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json']);

        return $response;
    }

    private function serialize($data): string
    {
        $serializer = $this->get('jms_serializer');
        $serializedData = $serializer->serialize($data, self::FORMAT_JSON);

        return $serializedData ?? '';
    }
}
