<?php
declare(strict_types=1);

namespace App\tests\Api\Action\Product;

use App\Api\Action\Product\Command\ListProductCommand;
use App\Api\Action\Product\Handler\ListProductCommandHandler;
use App\Api\Shared\Domain\Services\Pricing\PriceCalculator;
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

    public function testTest()
    {
        $this->assertTrue(true);
    }

    public function testFilterBootCategory()
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepository = $this->getProductRepository();
        $listProductCommandHandler = new ListProductCommandHandler($productRepository, $priceCalculator);
        $result = $listProductCommandHandler(
            new ListProductCommand(['category' => 'boots',])
        );

        $categories = array_column($result, 'category');
        $category = array_unique($categories);

        $this->assertIsArray($result);
        $this->assertTrue(3 === count($result));
        $this->assertTrue(1 === count($category));
        $this->assertTrue('boots' === $result[0]['category']);
    }

    public function testFilterPriceLT()
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepository = $this->getProductRepository();
        $listProductCommandHandler = new ListProductCommandHandler($productRepository, $priceCalculator);
        $result = $listProductCommandHandler(
            new ListProductCommand(['price_lt' => '59001',])
        );

        $categories = array_column($result, 'category');
        $category = array_unique($categories);

        $this->assertIsArray($result);
        $this->assertTrue(1 === count($category));
        $this->assertTrue('sneakers' === $result[0]['category']);
        $this->assertTrue(59000 === $result[0]['price']['final']);
    }

    public function testFiltersCombined()
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepository = $this->getProductRepository();
        $listProductCommandHandler = new ListProductCommandHandler($productRepository, $priceCalculator);
        $result = $listProductCommandHandler(
            new ListProductCommand(['price_lt' => '59001', 'category' => 'sneakers'])
        );

        $categories = array_column($result, 'category');
        $category = array_unique($categories);

        $this->assertIsArray($result);
        $this->assertTrue(1 === count($category));
        $this->assertTrue('sneakers' === $result[0]['category']);
        $this->assertTrue(59000 === $result[0]['price']['final']);
    }

    public function testFiltersCategoryNonExistent()
    {
        $priceCalculator = $this->getPriceCalculator();
        $productRepository = $this->getProductRepository();
        $listProductCommandHandler = new ListProductCommandHandler($productRepository, $priceCalculator);
        $result = $listProductCommandHandler(
            new ListProductCommand(['category' => 'no_category',])
        );

        $categories = array_column($result, 'category');
        $category = array_unique($categories);

        $this->assertIsArray($result);
        $this->assertTrue(0 === count($category));
    }

    private function getPriceCalculator(): PriceCalculator
    {
        return $this->container->get(PriceCalculator::class);
    }

    private function getProductRepository(): ProductMysqlRepository
    {
        return $this
            ->container
            ->get(ProductMysqlRepository::class);
    }

}