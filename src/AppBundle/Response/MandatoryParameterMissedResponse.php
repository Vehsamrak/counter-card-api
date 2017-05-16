<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class MandatoryParameterMissedResponse extends JsonResponse
{

    public function __construct(JsonErrorMessage $data = null)
    {
        if (null === $data) {
            $data = new JsonErrorMessage('Mandatory parameter missed.');
        }

        parent::__construct('', 400, []);

        return $this->setData($data);
    }
}
