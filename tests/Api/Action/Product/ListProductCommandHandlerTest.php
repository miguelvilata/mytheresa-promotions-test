<?php
declare(strict_types=1);

namespace App\tests\Api\Action\Product;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\Handler\ListProductCommandHandler;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
use App\Domain\Entity\Product;
use App\Domain\Interface\Repository;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Sku;
use App\Infrastructure\Repository\ProductMysqlRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class ListProductCommandHandlerTest extends KernelTestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
    }

    public function testProductInBootCategoryHave30PercentDiscount(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepositoryMock = $this->getProductRepositoryMock();
        $productRepositoryMock->method('filter')
            ->willReturn([
                new Product(new Sku('1'), new Name('pepito'), new Name('boots'), new Money(1000)),
            ]);

        $listProductCommandHandler = new ListProductCommandHandler($productRepositoryMock, $priceCalculator);

        $result = $listProductCommandHandler(
            new ListProductCommand('asdf')
        );

        print_r($result);

        $this->assertIsArray($result);
        $this->assertTrue(1 === count($result));
        $this->assertTrue('boots' === $result[0]['category']);
        $this->assertTrue(1000 === $result[0]['price']['original']);
        $this->assertTrue(700 === $result[0]['price']['final']);
        $this->assertTrue('30%' === $result[0]['price']['discount_percentage']);
    }

    private function getPriceCalculator()
    {
        return $this->container->get(PriceCalculator::class);
    }

    private function getProductRepositoryMock()
    {
        return $this
            ->getMockBuilder(ProductMysqlRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

}