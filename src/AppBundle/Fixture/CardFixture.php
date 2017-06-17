<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Card;
use AppBundle\Entity\User;
use AppBundle\Service\DateTimeFactory\DateTimeFactory;
use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Vehsamrak
 */
class CardFixture implements FixtureInterface
{

    /** {@inheritDoc} */
    public function load(ObjectManager $manager): void
    {
        $idGenerator = static::createIdGeneratorThatReturns(1);
        $secondIdGenerator = static::createIdGeneratorThatReturns(2);
        $dateTimeFactory = static::createDateTimeFactoryThatReturns('2016-06-03 18:48');
        $secondDateTimeFactory = static::createDateTimeFactoryThatReturns('2016-01-01 10:00');

        $user = $manager->getRepository(User::class)->find('first-user');

        $firstCard = new Card($user, 1.1, 2.2, $idGenerator, $dateTimeFactory);
        $secondCard = new Card($user, 1.1, 2.2, $secondIdGenerator, $secondDateTimeFactory);

        $entities = [
            $firstCard,
            $secondCard,
        ];

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public static function createIdGeneratorThatReturns(string $id)
    {
        return new class($id) extends IdGenerator {
            private $id;

            public function __construct(string $id)
            {
                $this->id = $id;
            }

            public function generateUuid(): string
            {
                return $this->id;
            }
        };
    }

    public static function createDateTimeFactoryThatReturns(string $formattedDateTime)
    {
        return new class($formattedDateTime) extends DateTimeFactory {
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
