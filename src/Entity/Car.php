<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[
    ApiResource(
        collectionOperations: [
            'get',
            'post' => ['security' => 'is_granted("ROLE_ADMIN")'],
            'delete' =>['security' => 'is_granted("ROLE_ADMIN)']
        ],
        attributes: ["pagination_items_per_page" => 5],
        denormalizationContext: ['groups' => ['write']],
        normalizationContext: ['groups' => ['read']]
    ),
    ApiFilter(
        SearchFilter::class,
        properties: [
            'name' => SearchFilter::STRATEGY_PARTIAL,
            'description' => SearchFilter::STRATEGY_PARTIAL,
        ]
    ),
    ApiFilter(
        OrderFilter::class,
        properties: ['issueDate']
    )


] #[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[Groups(['read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $photo = null;


    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $model = null;


    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $description = null;


    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $color = null;


    #[Groups(['read', 'write'])]
    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[Groups(['read'])]
    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Order::class)]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCar($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCar() === $this) {
                $order->setCar(null);
            }
        }

        return $this;
    }
}
