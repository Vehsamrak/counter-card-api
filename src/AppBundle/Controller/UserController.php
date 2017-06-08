<?php

namespace AppBundle\Controller;

use AppBundle\Controller\Infrastructure\AbstractRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @author Vehsamrak
 * @Security("has_role('ROLE_USER')")
 */
class UserController extends AbstractRestController
{

    /**
     * @Route("/user", name="api_user_current")
     * @Method("GET")
     */
    public function getCurrentUserAction()
    {
        return $this->respond($this->getUser());
    }
}
