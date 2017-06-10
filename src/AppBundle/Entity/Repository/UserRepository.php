<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\User;

/** {@inheritDoc} */
class UserRepository extends AbstractRepository
{

    /**
     * @return User|object|null
     */
    public function findOneByToken(string $token)
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
    public function findOneByLoginAndPassword(string $login, string $password)
    {
        $user = $this->findOneByEmailOrFlatNumber($login, (int) $login);

        if ($user && $user->getPassword() === $password) {
            return $user;
        }

        return null;
    }

    /**
     * @return User|object|null
     */
    public function findOneByEmailOrFlatNumber(string $email, int $flatNumber)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $q = $qb->select('u')
                ->from('AppBundle:User', 'u')
                ->where('u.email = :email')
                ->orWhere('u.flatNumber = :flatNumber')
                ->setParameters(
                    [
                        'email'      => $email,
                        'flatNumber' => $flatNumber,
                    ]
                )
                ->getQuery();

        return $q->getOneOrNullResult();
    }
}
