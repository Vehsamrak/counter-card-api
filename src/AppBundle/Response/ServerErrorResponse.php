<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class ServerErrorResponse extends JsonResponse
{
    public function __construct(int $statusCode, string $message = 'Server error.')
    {
        parent::__construct('', $statusCode, []);

        return $this->setData(new JsonErrorMessage($message));
    }
}
