<?php

declare(strict_types=1);

namespace App\Model\User\Entity;

use App\Model\Type\UuidType;
use App\Model\User\Type\EmailType;
use App\Model\User\Type\PasswordType;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"email"})
 * })
 */
class User
{
    /**
     * @var UuidType
     * @ORM\Column(type="uuid_type")
     * @ORM\Id
     */
    private UuidType $id;

    /**
     * @var EmailType
     * @ORM\Column(type="user_email", unique=true)
     */
    private EmailType $email;

    /**
     * @var PasswordType
     * @ORM\Column(type="user_password", unique=true)
     */
    private PasswordType $password;

    public function __construct(EmailType $email, PasswordType $password)
    {
        $this->id = UuidType::generate();
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): UuidType
    {
        return $this->id;
    }

    public function getEmail(): EmailType
    {
        return $this->email;
    }

    public function getPassword(): PasswordType
    {
        return $this->password;
    }

    public function changePassword(PasswordType $password): void
    {
        $this->password = $password;
    }
}
