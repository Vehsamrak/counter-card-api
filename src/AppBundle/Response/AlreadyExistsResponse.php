<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class AlreadyExistsResponse extends JsonResponse
{

    public function __construct(string $message)
    {
        $data = new JsonErrorMessage($message);

        parent::__construct('', self::HTTP_CONFLICT, []);

        return $this->setData($data);
    }
}
