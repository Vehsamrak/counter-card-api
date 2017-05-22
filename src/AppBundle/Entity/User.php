<?php

namespace AppBundle\Entity;

use AppBundle\Service\IdGenerator\IdGenerator;
use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\Column(name="id", type="string", length=255, nullable=false)
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;


    /**
     * @var integer
     * @ORM\Column(name="flat", type="smallint", length=5, nullable=false, unique=true)
     */
    private $flatNumber;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=32, nullable=false, unique=true)
     */
    private $token;

    /**
     * @var \DateTime
     * @ORM\Column(name="registration_date", type="datetime", nullable=false)
     */
    private $registrationDate;

    /**
     * @var array
     * @ORM\Column(name="roles", type="simple_array", nullable=true)
     */
    private $roles;

    /** @var IdGenerator */
    private $idGenerator;

    public function __construct(
        string $email,
        string $name,
        int $flatNumber,
        IdGenerator $idGenerator = null
    ) {
        $this->idGenerator = $idGenerator ?: new IdGenerator();
        $this->id = $idGenerator->generateUuid();
        $this->registrationDate = new \DateTime();
        $this->name = $name;
        $this->flatNumber = $flatNumber;
        $this->email = $email;
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

    public function updateToken(): void
    {
        $this->token = $this->idGenerator->generateString(self::TOKEN_LENGTH);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    /** {@inheritDoc} */
    public function getPassword()
    {
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
}
