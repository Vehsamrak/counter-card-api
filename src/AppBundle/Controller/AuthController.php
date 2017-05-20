<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vehsamrak
 * @Route("/api")
 */
class AuthController
{
    /**
     * @Route("/register", name="api_register_user")
     * @Method("GET")
     * @return JsonResponse
     */
    public function registerAction(Request $request)
    {
        return new JsonResponse([]);
    }
}
