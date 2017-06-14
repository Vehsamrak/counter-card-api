<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Infrastructure\AbstractRestController;
use AppBundle\Exception\MultipleRegistration;
use AppBundle\Exception\UserExists;
use AppBundle\Response\AlreadyExistsResponse;
use AppBundle\Response\MandatoryParameterMissedResponse;
use AppBundle\Response\NotAllowedResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vehsamrak
 */
class AuthController extends AbstractRestController
{

    /**
     * @Route("/register", name="api_register_user")
     * @Method("POST")
     * @return JsonResponse
     */
    public function registerAction(Request $request)
    {
        $email = $request->get('login');
        $name = $request->get('name');
        $flatNumber = (int) $request->get('flatNumber');
        $password = $request->get('password');
        $userIp = $request->getClientIp();

        if ($email && $name && $flatNumber && $password) {
            $userRegistrator = $this->get('counter_card.user_registrator');

            try {
                $user = $userRegistrator->registerUser($email, $name, $flatNumber, $password, $userIp);
                $response = new JsonResponse($user->getToken());
            } catch (UserExists $exception) {
                $response = new AlreadyExistsResponse('User with this email of flat number already exists.');
            } catch (MultipleRegistration $exception) {
                $response = new NotAllowedResponse(sprintf('Too many registrations with same ip: %s', $userIp));
            }
        } else {
            $response = new MandatoryParameterMissedResponse();
        }

        return $response;
    }

    /**
     * @Route("/login", name="api_login")
     * @Method("POST")
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        $login = $request->get('login');
        $rawPassword = $request->get('password');
        $password = md5($rawPassword);

        if ($login && $password) {
            $userRepository = $this->get('counter_card.user_repository');
            $user = $userRepository->findOneByLoginAndPassword($login, $password);

            if (!$user) {
                $result = new NotAllowedResponse('Invalid login and password.');
            } else {
                $newToken = $this->get('id_generator')->generateString();
                $user->updateToken($newToken);
                $userRepository->flush($user);

                $result = $user->getToken();
            }
        } else {
            $result = new MandatoryParameterMissedResponse();
        }

        return $this->respond($result);
    }
}
