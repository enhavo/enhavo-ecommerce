<?php

namespace Enhavo\Bundle\ShopBundle\Factory;

use Enhavo\Bundle\ResourceBundle\Factory\Factory;
use Enhavo\Bundle\ShopBundle\Model\OrderItemInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;

class OrderItemFactory extends Factory
{
    public function __construct(
        string $className,
        private ProductVariantProxyFactoryInterface $productVariantProxyFactory,
    ) {
        parent::__construct($className);
    }

    public function createWithProductVariant(ProductVariantInterface $productVariant): OrderItemInterface
    {
        /** @var OrderItemInterface $item */
        $item = $this->createNew();
        $productVariantProxy = $this->productVariantProxyFactory->createNew($productVariant);
        $item->setProduct($productVariantProxy);
        $item->setName(sprintf('%s, %s', $productVariant->getProduct()->getName(), $productVariantProxy->getTitle()));
        return $item;
    }
}
