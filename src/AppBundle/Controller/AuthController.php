<?php

namespace AppBundle\Controller;

use AppBundle\Response\MandatoryParameterMissedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vehsamrak
 */
class AuthController extends Controller
{
    /**
     * @Route("/register", name="api_register_user")
     * @Method("POST")
     * @return JsonResponse
     */
    public function registerAction(Request $request)
    {
        $requestContentsJson = $request->getContent();
        $requestContents = json_decode($requestContentsJson, true);

        $email = $requestContents['email'];
        $name = $requestContents['name'];
        $flatNumber = $requestContents['flatNumber'];

        if ($email && $name && $flatNumber) {
            $userRegistrator = $this->get('counter_card.user_registrator');
            $user = $userRegistrator->registerUser($email, $name, $flatNumber);
        	$response = new JsonResponse($user);
        } else {
            $response = new MandatoryParameterMissedResponse();
        }

        return $response;
    }
}
