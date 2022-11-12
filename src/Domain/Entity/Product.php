<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Sku;

final class Product
{
    private string $sku;
    private string $name;
    private string $category;
    private int $price;

    /**
     * @param string $sku
     * @param string $name
     * @param string $category
     * @param int $price
     */
    public function __construct(Sku $sku, Name $name, Name $category, Money $price)
    {
        $this->sku = $sku->value();
        $this->name = $name->value();
        $this->category = $category->value();
        $this->price = $price->value();
    }

    static public function fromArray(array $data)
    {
        return new self(
            new Sku($data->sku),
            new Name($data->name),
            new Name($data->category),
            new Money($data->price),
        );

    }

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