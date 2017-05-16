<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Card;

/** {@inheritDoc} */
class CardRepository extends AbstractRepository
{

    /**
     * @return Card|object|null
     */
    public function findLast()
    {
        return $this->findOneBy([], ['id' => 'DESC']);
    }
}
