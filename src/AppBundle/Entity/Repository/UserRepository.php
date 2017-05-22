<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;

/** {@inheritDoc} */
class UserRepository extends AbstractRepository
{

    /**
     * @return User|object|null
     */
    public function findOneByName(string $userName)
    {
        return $this->findOneBy(
            [
                'name' => $userName,
            ]
        );
    }

    /**
     * @return User|object|null
     */
    public function findUserByToken(string $token)
    {
        return $this->findOneBy(
            [
                'token' => $token,
            ]
        );
    }

    /**
     * @return User|object|null
     */
    public function findUserByEmail(string $email)
    {
        return $this->findOneBy(
            [
                'email' => $email,
            ]
        );
    }
}
