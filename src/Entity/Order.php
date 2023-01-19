<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pick_up_location = null;//1

    #[ORM\Column(length: 255)]
    private ?string $pick_up_data_time = null;//2

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    private ?string $time_rental = null;//3

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[ORM\Column]
    private ?int $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPickUpLocation(): ?string
    {
        return $this->pick_up_location;
    }

    public function setPickUpLocation(string $pick_up_location): self
    {
        $this->pick_up_location = $pick_up_location;

        return $this;
    }

    public function getPickUpDataTime(): ?string
    {
        return $this->pick_up_data_time;
    }

    public function setPickUpDataTime(string $pick_up_data_time): self
    {
        $this->pick_up_data_time = $pick_up_data_time;

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

    public function getTimeRental(): ?string
    {
        return $this->time_rental;
    }

    public function setTimeRental(string $time_rental): self
    {
        $this->time_rental = $time_rental;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
