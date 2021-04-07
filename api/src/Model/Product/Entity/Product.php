<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use App\Model\Category\Entity\Category;
use App\Model\Product\Type\DescriptionType;
use App\Model\Product\Type\NameType;
use App\Model\Product\Type\PriceType;
use App\Model\Type\UuidType;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

/**
 * Class Product
 * @package App\Model\Product\Entity
 * @ORM\Entity
 * @ORM\Table
 */
class Product
{
    /**
     * @var UuidType
     * @ORM\Column(type="uuid_type")
     * @ORM\Id
     */
    private UuidType $id;

    /**
     * @var NameType
     * @ORM\Column(type="product_name_type")
     */
    private NameType $name;

    /**
     * @var DescriptionType
     * @ORM\Column(type="product_description_type")
     */
    private DescriptionType $description;

    /**
     * @var PriceType
     * @ORM\Column(type="product_price_type")
     */
    private PriceType $price;

    /**
     * Product constructor.
     * @param UuidType $id
     * @param NameType $name
     * @param DescriptionType $description
     * @param PriceType $price
     */

    /**
     * @var ?Category
     * @ORM\ManyToOne(targetEntity="App\Model\Category\Entity\Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private ?Category $category;

    public function __construct(
        NameType $name,
        DescriptionType $description,
        PriceType $price,
        ?Category $category = null
    )
    {
        $this->id = UuidType::generate();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
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

    /**
     * @return DescriptionType
     */
    public function getDescription(): DescriptionType
    {
        return $this->description;
    }

    /**
     * @return PriceType
     */
    public function getPrice(): PriceType
    {
        return $this->price;
    }

    public function changeName(NameType $anotherName): void
    {
        if (!$this->name->isEqualTo($anotherName)) {
            throw new DomainException('Same name.');
        }
        $this->name = $anotherName;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function hasCategory(): bool
    {
        return isset($this->category);
    }

    public function changeCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function unsetCategory(): void
    {
        $this->category = null;
    }
}
