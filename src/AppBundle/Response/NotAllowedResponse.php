<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class NotAllowedResponse extends JsonResponse
{

    public function __construct(string $message = 'Action not allowed.')
    {
        $data = new JsonErrorMessage($message);

        parent::__construct('', self::HTTP_FORBIDDEN, []);

        return $this->setData($data);
    }
}
