<?php

declare(strict_types=1);

namespace App\Tests\Integration\Store\Application\Command;

use App\Store\Application\Command\CreateProductListCommand;
use App\Store\Application\Command\Handler\CreateProductListCommandHandler;
use App\Store\Domain\Entity\Product\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateProductListCommandHandlerTest extends KernelTestCase
{
    private EntityManagerInterface $em;
    private CreateProductListCommandHandler $handler;

    protected function setUp(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        $this->em = $container->get(EntityManagerInterface::class);
        $this->handler = $container->get(CreateProductListCommandHandler::class);
    }

    public function testHandleCreatesProductsInDatabase(): void
    {
        $productList = [
            'products' => [
                [
                    "sku" => "000501",
                    "name" => "BV Lean leather ankle boots",
                    "category" => "boots",
                    "price" => 89000,
                ],
            ],
        ];
        $command = CreateProductListCommand::createFromArray($productList);

        $this->handler->handle($command);

        /** @var Product $product */
        $product = $this->em->getRepository(Product::class)->findOrFailBySku('000501');
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('000501', $product->sku());
    }
}
