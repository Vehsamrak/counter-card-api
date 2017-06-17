<?php

namespace AppBundle\Entity;

use AppBundle\Service\DateTimeFactory\DateTimeFactory;
use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\ORM\Mapping as ORM;

/**
 * User card for flat resources metrics to specific date
 * @ORM\Table(name="cards")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CardRepository")
 */
class Card
{
    /**
     * @var string
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var float
     * @ORM\Column(name="water_cold", type="float")
     */
    private $waterCold;

    /**
     * @var float
     * @ORM\Column(name="water_hot", type="float")
     */
    private $waterHot;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="cards")
     * @ORM\JoinColumn(name="creator", referencedColumnName="id")
     */
    private $creator;

    public function __construct(
        User $creator,
        float $waterHot,
        float $waterCold,
        IdGenerator $idGenerator = null,
        DateTimeFactory $dateTimeFactory = null
    ) {
        $idGenerator = $idGenerator ?: new IdGenerator();
        $dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory();
        $this->id = $idGenerator->generateUuid();
        $this->createdAt = $dateTimeFactory->getCurrentDateAndTime();
        $this->creator = $creator;
        $this->waterCold = $waterCold;
        $this->waterHot = $waterHot;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        $createdAt = $this->createdAt;

        if ($createdAt instanceof \DateTime) {
            $createdAt = \DateTimeImmutable::createFromMutable($createdAt);
        }

        return $createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getWaterCold(): float
    {
        return $this->waterCold;
    }

    public function setWaterCold(float $waterCold): void
    {
        $this->waterCold = $waterCold;
    }

    public function getWaterHot(): float
    {
        return $this->waterHot;
    }

    public function setWaterHot(float $waterHot): void
    {
        $this->waterHot = $waterHot;
    }
}
