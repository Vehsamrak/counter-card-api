<?php

namespace AppBundle\Controller\Infrastructure;

use JMS\Serializer\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
abstract class AbstractRestController extends Controller
{

    const FORMAT_JSON = 'json';
    /** @var Serializer */
    private $serializer;

    public function respond($response): JsonResponse
    {
        if ($response instanceof JsonResponse) {
            $serializedData = $this->serialize($response->getContent());
            $response->setData($serializedData);
        } else {
            $serializedData = $this->serialize($response);
            $response = new JsonResponse($serializedData, JsonResponse::HTTP_OK);
        }

        return $response;
    }

    private function serialize($data): string
    {
        $serializer = $this->get('jms_serializer');
        $serializedData = $serializer->serialize($data, self::FORMAT_JSON);

        return $serializedData ?? '';
    }
}
