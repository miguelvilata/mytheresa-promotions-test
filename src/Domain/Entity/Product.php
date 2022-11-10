<?php
declare(strict_types=1);

namespace App\Domain\Entity;

final class Product
{
    private string $sku;
    private string $name;
    private string $category;
    private int $price;

    /**
     * @return mixed
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}