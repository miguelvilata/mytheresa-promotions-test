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

    public function testPushAndPop(): void
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepositoryMock = $this->getProductRepositoryMock();

        $listProductCommandHandler = new ListProductCommandHandler($productRepositoryMock, $priceCalculator);

        $result = $listProductCommandHandler(
            new ListProductCommand('asdf')
        );

        print_r($result);



        $this->assertTrue(false);
    }

    private function getPriceCalculator()
    {
        return $this->container->get(PriceCalculator::class);
    }

    private function getProductRepositoryMock()
    {
//        $productRepository = $this->createMock(Repository::class);
//        $productRepository
//            ->method('filter()')
//            ->willReturn([
//                new Product(new Sku('1'), new Name('pepito'), new Name('category'), New Money(444)),
//            ])
//        ;

        $stub = $this
            ->getMockBuilder(ProductMysqlRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stub->method('filter')
            ->willReturn([
                new Product(new Sku('1'), new Name('pepito'), new Name('category'), new Money(888)),
            ]);

        return $stub;
    }

}