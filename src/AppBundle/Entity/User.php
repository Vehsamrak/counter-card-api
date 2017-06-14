<?php

namespace AppBundle\Entity;

use AppBundle\Service\DateTimeFactory\DateTimeFactory;
use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type as SerializerType;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 */
class User implements UserInterface
{
    private const TOKEN_LENGTH = 32;
    private const ROLE_USER = 'ROLE_USER';

    /**
     * @var string
     * @ORM\Column(name="id", type="string", length=255)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;


    /**
     * @var integer
     * @ORM\Column(name="flat", type="smallint", length=5, unique=true)
     */
    private $flatNumber;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=32, unique=true)
     * @Serializer\Exclude
     */
    private $token;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=32, unique=false)
     * @Serializer\Exclude
     */
    private $password;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string", length=16, unique=false)
     * @Serializer\Exclude
     */
    private $ip;

    /**
     * @var \DateTime
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    /**
     * @var array
     * @ORM\Column(name="roles", type="simple_array", nullable=true)
     * @Serializer\Exclude
     */
    private $roles;

    /** @var IdGenerator */
    private $idGenerator;

    /** @var DateTimeFactory */
    private $dateTimeFactory;

    /* @var Card[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Card", mappedBy="creator")
     * @SerializerType("array")
     */
    private $cards;

    public function __construct(
        string $email,
        string $name,
        int $flatNumber,
        string $password,
        string $userIp,
        IdGenerator $idGenerator = null,
        DateTimeFactory $dateTimeFactory = null
    ) {
        $this->idGenerator = $idGenerator ?? new IdGenerator();
        $this->dateTimeFactory = $dateTimeFactory ?? new DateTimeFactory();
        $this->id = $idGenerator->generateUuid();
        $this->token = $idGenerator->generateString(self::TOKEN_LENGTH);
        $this->registrationDate = $this->dateTimeFactory->getCurrentDateAndTime();
        $this->name = $name;
        $this->flatNumber = $flatNumber;
        $this->email = $email;
        $this->password = md5($password);
        $this->ip = $userIp;
        $this->cards = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    /** {@inheritDoc} */
    public function getRoles(): array
    {
        return array_merge(
            $this->roles,
            [
                self::ROLE_USER,
            ]
        );
    }

    public function updateToken(string $token): void
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /** {@inheritDoc} */
    public function getPassword(): string
    {
        return $this->password;
    }

    /** {@inheritDoc} */
    public function getSalt()
    {
    }

    /** {@inheritDoc} */
    public function eraseCredentials()
    {
    }

    /** {@inheritDoc} */
    public function getUsername(): string
    {
        return $this->getId();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFlatNumber(): int
    {
        return $this->flatNumber;
    }
}
