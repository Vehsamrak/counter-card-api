<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\User;
use AppBundle\Service\DateTimeFactory\DateTimeFactory;
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
        $dateTimeFactory = $this->createDateTimeFactoryThatReturns('2017-06-03 18:00');

        $user = new User('test@test.ru', 'Tester', 1, 'testPassword', new class extends IdGenerator
        {
            public function generateUuid(): string
            {
                return '1';
            }

            public function generateString(int $length = 8): string
            {
                return 'test-token';
            }

        }, $dateTimeFactory);


        $entities = [
            $user
        ];

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function createDateTimeFactoryThatReturns(string $formattedDateTime)
    {
        return new class($formattedDateTime) extends DateTimeFactory
        {
            private $formattedDateTime;

            public function __construct(string $formattedDateTime)
            {
                $this->formattedDateTime = $formattedDateTime;
            }

            public function getCurrentDateAndTime(): \DateTimeImmutable
            {
                return new \DateTimeImmutable($this->formattedDateTime);
            }
        };
    }
}
