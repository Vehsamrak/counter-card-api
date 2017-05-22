<?php

namespace AppBundle\Service\Security;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;
use AppBundle\Service\IdGenerator\IdGenerator;

/**
 * @author Vehsamrak
 */
class UserRegistrator
{
    /** @var UserRepository */
    private $userRepository;
    /** @var IdGenerator */
    private $idGenerator;

    public function __construct(
        UserRepository $userRepository,
        IdGenerator $idGenerator = null
    )
    {
        $this->userRepository = $userRepository;
        $this->idGenerator = $idGenerator ?? new IdGenerator();
    }

    public function registerUser(string $email, string $name, int $flatNumber): User
    {
        $user = $this->userRepository->findUserByEmail($email);

        if (!$user) {
        	$user = new User($email, $name, $flatNumber, $this->idGenerator);
        	$this->userRepository->persist($user);
        	$this->userRepository->flush();
        }

        return $user;
    }
}
