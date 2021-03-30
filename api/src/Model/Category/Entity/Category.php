<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameType;
use App\Model\Type\UuidType;
use LogicException;

class Category
{
    private UuidType $id;
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
