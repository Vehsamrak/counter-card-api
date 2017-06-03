<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Card;
use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Vehsamrak
 */
class CardFixture implements FixtureInterface
{

    /** {@inheritDoc} */
    public function load(ObjectManager $manager)
    {
        $card = new Card(
            1.1, 2.2, 3.3, 4.4, new class extends IdGenerator
               {

                   public function generateUuid(): string
                   {
                       return '1';
                   }
               }
        );

        $entities = [
            $card,
        ];

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
