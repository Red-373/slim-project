<?php

declare(strict_types=1);

namespace App\Model\Category\Entity;

use App\Model\Category\Type\NameCategoryType;
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
     * @var NameCategoryType
     * @ORM\Column(type="category_name_type", unique=true)
     */
    private NameCategoryType $name;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="App\Model\Product\Entity\Product", mappedBy="category", cascade={"persist", "remove"})
     */
    private Collection $products;

    /**
     * Category constructor.
     * @param UuidType $id
     * @param NameCategoryType $name
     */
    public function __construct(UuidType $id, NameCategoryType $name)
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
     * @return NameCategoryType
     */
    public function getName(): NameCategoryType
    {
        return $this->name;
    }

    public function changeName(NameCategoryType $anotherName): void
    {
        if ($this->name->isEqualTo($anotherName)) {
            throw new DomainException('Same name.');
        }
        $this->name = $anotherName;
    }

    public function getProducts(): array
    {
        return $this->products->toArray();
    }

    public function addProduct(Product $products): void
    {
        $this->products->add($products);
    }

    public function isEqualTo(self $another): bool
    {
        return $this === $another;
    }
}
