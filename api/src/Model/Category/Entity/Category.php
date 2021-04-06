<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameType;
use App\Model\Product\Entity\Product;
use App\Model\Type\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

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
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Model\Product\Entity\Product", mappedBy="category", cascade={"persist"})
     */
    private Collection $products;

    /**
     * Category constructor.
     * @param UuidType $id
     * @param NameType $name
     */
    public function __construct(UuidType $id, NameType $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->products = new ArrayCollection();
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
        if ($this->name->isEqualTo($anotherName)) {
            throw new DomainException('Same name.');
        }
        $this->name = $anotherName;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function addProduct(Product $products): void
    {
        $this->products->add($products);
    }
}
