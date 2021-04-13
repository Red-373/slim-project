<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use App\Model\Category\Entity\Category;
use App\Model\Product\Type\DescriptionProductType;
use App\Model\Product\Type\NameProductType;
use App\Model\Product\Type\PriceProductType;
use App\Model\Tag\Entity\Tag;
use App\Model\Type\UuidType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
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
     * @var NameProductType
     * @ORM\Column(type="product_name_type")
     */
    private NameProductType $name;

    /**
     * @var DescriptionProductType
     * @ORM\Column(type="product_description_type")
     */
    private DescriptionProductType $description;

    /**
     * @var PriceProductType
     * @ORM\Column(type="product_price_type")
     */
    private PriceProductType $price;

    /**
     * Product constructor.
     * @param UuidType $id
     * @param NameProductType $name
     * @param DescriptionProductType $description
     * @param PriceProductType $price
     */

    /**
     * @var ?Category
     * @ORM\ManyToOne(targetEntity="App\Model\Category\Entity\Category", inversedBy="products", cascade={"persist"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private ?Category $category;

    /**
     * @ManyToMany(targetEntity="App\Model\Tag\Entity\Tag", inversedBy="products")
     * @JoinTable(name="products_tags")
     */
    private Collection $tags;

    public function __construct(
        NameProductType $name,
        DescriptionProductType $description,
        PriceProductType $price,
        ?Category $category = null
    ) {
        $this->id = UuidType::generate();
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category = $category;
        $this->tags = new ArrayCollection();
    }

    /**
     * @return UuidType
     */
    public function getId(): UuidType
    {
        return $this->id;
    }

    /**
     * @return NameProductType
     */
    public function getName(): NameProductType
    {
        return $this->name;
    }

    /**
     * @return DescriptionProductType
     */
    public function getDescription(): DescriptionProductType
    {
        return $this->description;
    }

    /**
     * @return PriceProductType
     */
    public function getPrice(): PriceProductType
    {
        return $this->price;
    }

    public function changeName(NameProductType $anotherName): void
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

    public function attachTags(Collection $tags): void
    {
        if ($this->tags->toArray() === $tags->toArray()) {
            throw new DomainException('Same tags.');
        }
        $this->tags = $tags;
    }

    public function attachTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            throw new DomainException('This product have this tag. Tag id = ' . $tag->getId()->getValue() . '.');
        }

        $this->tags->add($tag);
    }
}
