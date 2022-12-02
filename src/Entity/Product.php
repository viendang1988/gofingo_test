<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table]
#[ORM\Index(columns: ['e_id'], name: 'eId_idx')]
#[UniqueEntity('eId')]
class Product
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

    #[Assert\Range(
        min: 0,
        max: 200
    )]
    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(unique: true, nullable: true)]
    private ?int $eId = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'product_category')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private $categories;

    /**
     * @param int|null $eId
     */
    public function __construct(?int $eId = null)
    {
        $this->eId = $eId;

        $this->categories = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function addCategory(Category $category)
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->addProduct($this);
        }
    }

    public function removeCategory(Category $category)
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeProduct($this);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

}
