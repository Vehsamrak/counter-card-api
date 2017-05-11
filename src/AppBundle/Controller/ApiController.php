<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{

    /**
     * @Route("/", name="api_index")
     */
    public function indexAction()
    {
        return new JsonResponse();
    }

    /**
     * @Route("/card", name="api_create_card")
     */
    public function createAction()
    {
        return new JsonResponse([]);
    }
}
