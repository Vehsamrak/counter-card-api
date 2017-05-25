<?php

namespace AppBundle\Controller;

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
        return new JsonResponse(
            $exception->toArray()
        );
    }
}
