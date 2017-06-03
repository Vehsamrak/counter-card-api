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
    public function load(ObjectManager $manager)
    {
        $idGenerator = $this->createIdGeneratorThatReturns(1);
        $dateTimeFactory = $this->createDateTimeFactoryThatReturns('2017-06-03 18:48');

        $user = $manager->getRepository(User::class)->find(1);

        $card = new Card($user, 1.1, 2.2, 3.3, 4.4, $idGenerator, $dateTimeFactory);

        $entities = [
            $card,
        ];

        foreach ($entities as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }

    private function createIdGeneratorThatReturns(string $id)
    {
        return new class($id) extends IdGenerator
        {
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
