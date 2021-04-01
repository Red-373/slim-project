<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use Doctrine\ORM\Mapping as ORM;
use LogicException;

/**
 * Class Category
 * @package App\Model\Category\Entity
 * @ORM\Entity
 * @ORM\Table
 */
class Category
{
    /**
     * @var UuidType
     * @ORM\Column(type="uuid_type")
     * @ORM\Id
     */
    private UuidType $id;

    /**
     * @var NameType
     * @ORM\Column(type="category_name_type", unique=true)
     */
    private NameType $name;

    /**
     * Category constructor.
     * @param UuidType $id
     * @param NameType $name
     */
    public function __construct(UuidType $id, NameType $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return UuidType
     */
    public function getId(): UuidType
    {
        return $this->id;
    }

    /**
     * @return NameType
     */
    public function getName(): NameType
    {
        return $this->name;
    }

    public function changeName(NameType $anotherName): void
    {
        if (!$this->name->isEqualTo($anotherName)) {
            throw new LogicException('Same name.');
        }
        $this->name = $anotherName;
    }
}
