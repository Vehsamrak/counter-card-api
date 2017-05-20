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
     * @var float
     * @ORM\Column(name="electricity_day", type="float")
     */
    private $electricityDay;

    /**
     * @var float
     * @ORM\Column(name="electricity_night", type="float")
     */
    private $electricityNight;

    public function __construct(
        float $waterHot,
        float $waterCold,
        float $electricityDay,
        float $electricityNight,
        IdGenerator $idGenerator = null
    ) {
        $idGenerator = $idGenerator ?: new IdGenerator();
        $this->id = $idGenerator->generateUuid();
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

    public function getElectricityDay(): float
    {
        return $this->electricityDay;
    }

    public function setElectricityDay(float $electricityDay): void
    {
        $this->electricityDay = $electricityDay;
    }

    public function getElectricityNight(): float
    {
        return $this->electricityNight;
    }

    public function setElectricityNight(float $electricityNight): void
    {
        $this->electricityNight = $electricityNight;
    }
}
