<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class CreatedResponse extends JsonResponse
{

    public function __construct($data = null)
    {
        parent::__construct('', self::HTTP_CREATED);

        if (null === $data) {
            $data = new \ArrayObject();
        }

        $this->setData($data);
    }
}
