<?php

namespace AppBundle\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class NotFoundResponse extends JsonResponse
{

    public function __construct(JsonErrorMessage $data = null)
    {
        if (null === $data) {
            $data = new JsonErrorMessage('Entity was not found.');
        }

        parent::__construct('', 404, []);

        return $this->setData($data);
    }
}
