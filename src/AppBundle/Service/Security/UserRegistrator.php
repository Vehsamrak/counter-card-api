<?php

namespace AppBundle\Service\Security;

use AppBundle\Entity\Repository\UserRepository;
use AppBundle\Entity\User;
use AppBundle\Exception\MultipleRegistration;
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
    public function registerUser(string $email, string $name, int $flatNumber, string $password, string $userIp): User
    {
        if ($this->userRepository->findOneByEmailOrFlatNumber($email, $flatNumber)) {
        	throw new UserExists();
        }

        $usersWithSameIp = $this->userRepository->findByIp($userIp);

        if (count($usersWithSameIp) > 3) {
            throw new MultipleRegistration();
        }

        $user = new User($email, $name, $flatNumber, $password, $userIp, $this->idGenerator);
        $this->userRepository->persist($user);
        $this->userRepository->flush();

        return $user;
    }
}
