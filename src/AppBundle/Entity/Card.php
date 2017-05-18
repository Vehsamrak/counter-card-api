<?php

namespace AppBundle\Entity;

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
     * @var int
     * @ORM\Column(name="water_cold", type="integer")
     */
    private $waterCold;

    /**
     * @var int
     * @ORM\Column(name="water_hot", type="integer")
     */
    private $waterHot;

    /**
     * @var int
     * @ORM\Column(name="electricity_day", type="integer")
     */
    private $electricityDay;

    /**
     * @var int
     * @ORM\Column(name="electricity_night", type="integer")
     */
    private $electricityNight;

    public function __construct(
        $waterHot,
        $waterCold,
        $electricityDay,
        $electricityNight,
        IdGenerator $idGenerator = null
    ) {
        $idGenerator = $idGenerator ?: new IdGenerator();
        $this->id = $idGenerator->generateRandomId();
        $this->createdAt = new \DateTimeImmutable();
        $this->waterCold = $waterCold;
        $this->waterHot = $waterHot;
        $this->electricityDay = $electricityDay;
        $this->electricityNight = $electricityNight;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        $createdAt = $this->createdAt;

        if (!$createdAt instanceof \DateTimeImmutable) {
            $createdAt = \DateTimeImmutable::createFromMutable($createdAt);
        }

        return $createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getWaterCold(): int
    {
        return $this->waterCold;
    }

    public function setWaterCold(int $waterCold): void
    {
        $this->waterCold = $waterCold;
    }

    public function getWaterHot(): int
    {
        return $this->waterHot;
    }

    public function setWaterHot(int $waterHot): void
    {
        $this->waterHot = $waterHot;
    }

    public function getElectricityDay(): int
    {
        return $this->electricityDay;
    }

    public function setElectricityDay(int $electricityDay): void
    {
        $this->electricityDay = $electricityDay;
    }

    public function getElectricityNight(): int
    {
        return $this->electricityNight;
    }

    public function setElectricityNight(int $electricityNight): void
    {
        $this->electricityNight = $electricityNight;
    }
}
