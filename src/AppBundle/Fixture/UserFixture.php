<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\User;
use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Vehsamrak
 */
class UserFixture implements FixtureInterface
{
    /** {@inheritDoc} */
    public function load(ObjectManager $manager)
    {
        $user = new User('test@test.ru', 'Tester', 1, new class extends IdGenerator
        {
            public function generateUuid(): string
            {
                return '1';
            }

            public function generateString(int $length = 8): string
            {
                return 'test-token';
            }

        });


        $entities = [
            $user
        ];

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
