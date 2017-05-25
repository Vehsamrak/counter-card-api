<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class MandatoryParameterMissedResponse extends JsonResponse
{

    public function __construct(string $message = 'Mandatory parameter missed.')
    {
        $data = new JsonErrorMessage($message);

        parent::__construct('', self::HTTP_BAD_REQUEST, []);

        return $this->setData($data);
    }
}
