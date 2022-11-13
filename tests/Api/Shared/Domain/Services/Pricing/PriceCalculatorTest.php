<?php
declare(strict_types=1);

namespace App\tests\Api\Shared\Domain\Services\Pricing;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\Handler\ListProductCommandHandlerInterface;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
use App\Api\Shared\Dto\CalculatorResult;
use App\Api\Shared\Dto\PriceCalculatorResult;
use App\Domain\Entity\Product;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Sku;
use App\Infrastructure\Repository\ProductMysqlRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Api\Shared\Domain\Exception\InvalidPercentageDiscountException;

final class ListProductCommandHandlerTest extends KernelTestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
    }

    public function testWhenNoDiscountAppliedFinalAndOriginalPriceIsEqual()
    {
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('x'), new Name('pepito'), new Name('category'), new Money(1000));
        $result = $priceCalculator->calculate($product);

        $this->assertTrue(1000 === $result->getOriginalPrice());
        $this->assertTrue(1000 === $result->getFinalPrice());
        $this->assertTrue(null === $result->getDiscountPercentage());
    }

    public function testWhenMultipleDiscountsCollideTheGreaterOneIsApplied(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('000003'), new Name('pepito'), new Name('boots'), new Money(1000));
        $result = $priceCalculator->calculate($product);

        $this->assertTrue('boots' === $result->getCategory());
        $this->assertTrue(1000 === $result->getOriginalPrice());
        $this->assertTrue(700 === $result->getFinalPrice());
        $this->assertTrue('30%' === $result->getDiscountPercentage());
    }

    public function testProductWithSkuHas15PercentDiscount(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('000003'), new Name('pepito'), new Name('category'), new Money(1000));
        $result = $priceCalculator->calculate($product);

        $this->assertTrue(1000 === $result->getOriginalPrice());
        $this->assertTrue(850 === $result->getFinalPrice());
        $this->assertTrue('15%' === $result->getDiscountPercentage());
    }

    public function testProductInBootCategoryHas30PercentDiscount(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('1'), new Name('pepito'), new Name('boots'), new Money(1000));
        $result = $priceCalculator->calculate($product);

        $this->assertTrue('boots' === $result->getCategory());
        $this->assertTrue(1000 === $result->getOriginalPrice());
        $this->assertTrue(700 === $result->getFinalPrice());
        $this->assertTrue('30%' === $result->getDiscountPercentage());
    }

    public function testDiscountUnderZeroException(): void
    {
        $this->expectException(InvalidPercentageDiscountException::class);
        $lineDiscount = new CalculatorResult('DiscountByCategoryCalculator', 26700, 'discount_percentage', -1);
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('1'), new Name('pepito'), new Name('category'), new Money(1000));
        $priceCalculatorResult = $priceCalculator->calculate($product);
        $priceCalculatorResult->addLine($lineDiscount);
        $priceCalculatorResult->getDiscountPercentage();
    }

    public function testDiscountAboveOneHundredException(): void
    {
        $this->expectException(InvalidPercentageDiscountException::class);
        $lineDiscount = new CalculatorResult('DiscountByCategoryCalculator', 26700, 'discount_percentage', 101);
        $priceCalculator = $this->getPriceCalculator();
        $product = new Product(new Sku('1'), new Name('pepito'), new Name('category'), new Money(1000));
        $priceCalculatorResult = $priceCalculator->calculate($product);
        $priceCalculatorResult->addLine($lineDiscount);
        $priceCalculatorResult->getDiscountPercentage();
    }

    private function getPriceCalculator(): PriceCalculator
    {
        return $this->container->get(PriceCalculator::class);
    }
}