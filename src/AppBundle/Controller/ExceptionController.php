<?php

namespace AppBundle\Controller;

use AppBundle\Response\ServerErrorResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Vehsamrak
 */
class ExceptionController extends Controller
{
    public function handleExceptionAction(FlattenException $exception)
    {
        if ($this->getParameter('kernel.environment') !== \AppKernel::ENVIRONMENT_PRODUCTION) {
            $response = new JsonResponse($exception->toArray());
        } else {
            $response = new ServerErrorResponse($exception->getStatusCode());
        }

        return $response;
    }
}
