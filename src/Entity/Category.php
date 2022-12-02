<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table]
#[ORM\Index(columns: ['e_id'], name: 'eId_idx')]
#[UniqueEntity('eId')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 3,
        max: 12
    )]
    #[ORM\Column(length: 12)]
    private ?string $title = null;

    #[ORM\Column(unique: true, nullable: true)]
    private ?int $eId = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'categories', cascade: ['persist'])]
    private $products;

    /**
     * @param int|null $eId
     */
    public function __construct(?int $eId = null)
    {
        $this->eId = $eId;
        $this->products = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function __toString() {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEId(): ?int
    {
        return $this->eId;
    }

    public function setEId(?int $eId): self
    {
        $this->eId = $eId;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }
    }

    public function removeProduct(Product $product)
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeCategory($this);
        }
    }

}
