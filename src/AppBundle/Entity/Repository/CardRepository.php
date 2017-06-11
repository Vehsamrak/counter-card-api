<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Card;

/** {@inheritDoc} */
class CardRepository extends AbstractRepository
{

    /**
     * @return Card|object|null
     */
    public function findLastForUser(string $userId)
    {
        return $this->findOneBy(
            [
                'creator' => $userId,
            ],
            ['createdAt' => 'DESC']
        );
    }

    /**
     * @return Card[]|object[]
     */
    public function findAllByUserId(string $userId)
    {
        return $this->findBy(
            [
                'creator' => $userId,
            ],
            ['createdAt' => 'DESC']
        );
    }
}
