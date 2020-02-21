<?php


namespace App\Tests\Util;


use App\Util\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @dataProvider pricesForFoodProduct
     * @param $price
     * @param $expectedTVA
     */
    public function testComputeTVAFoodProduct($price, $expectedTVA): void
    {
        $product = new Product('a food product', Product::FOOD_PRODUCT, $price);

        $this->assertSame($expectedTVA, $product->computeTVA());
    }

    public function testComputeTVAOtherProduct(): void
    {
        $product = new Product('other product', 'other product type', 20);

        $this->assertSame(3.92, $product->computeTVA());
    }

    public function testNegativePriceComputeTVA(): void
    {
        $product = new Product('a food product', Product::FOOD_PRODUCT, -20);

        $this->expectException('LogicException');

        $product->computeTVA();
    }

    public function pricesForFoodProduct(): array
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }
}