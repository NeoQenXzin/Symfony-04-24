<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'Product_Category')]
    private Collection $category_products;

    public function __construct()
    {
        $this->category_products = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getCategoryProducts(): Collection
    {
        return $this->category_products;
    }

    public function addCategoryProduct(Product $categoryProduct): static
    {
        if (!$this->category_products->contains($categoryProduct)) {
            $this->category_products->add($categoryProduct);
            $categoryProduct->setProductCategory($this);
        }

        return $this;
    }

    public function removeCategoryProduct(Product $categoryProduct): static
    {
        if ($this->category_products->removeElement($categoryProduct)) {
            // set the owning side to null (unless already changed)
            if ($categoryProduct->getProductCategory() === $this) {
                $categoryProduct->setProductCategory(null);
            }
        }

        return $this;
    }
}
