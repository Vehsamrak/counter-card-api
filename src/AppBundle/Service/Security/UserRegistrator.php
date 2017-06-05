<?php

namespace AppBundle\Service\Security;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;
use AppBundle\Exception\UserExists;
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
        IdGenerator $idGenerator
    )
    {
        $this->userRepository = $userRepository;
        $this->idGenerator = $idGenerator;
    }

    /**
     * @throws UserExists
     */
    public function registerUser(string $email, string $name, int $flatNumber, string $password): User
    {
        if ($this->userRepository->findOneByEmailOrFlatNumber($email, $flatNumber)) {
        	throw new UserExists();
        }

        $user = new User($email, $name, $flatNumber, $password, $this->idGenerator);
        $this->userRepository->persist($user);
        $this->userRepository->flush();

        return $user;
    }
}
