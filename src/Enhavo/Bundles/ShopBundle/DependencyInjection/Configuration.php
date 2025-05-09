<?php

namespace Enhavo\Bundle\ShopBundle\DependencyInjection;

use Enhavo\Bundle\AppBundle\Controller\ResourceController;
use Enhavo\Bundle\ResourceBundle\Repository\EntityRepository;
use Enhavo\Bundle\ShopBundle\Entity\UserAddress;
use Enhavo\Bundle\ShopBundle\Entity\Voucher;
use Enhavo\Bundle\ShopBundle\Entity\VoucherRedemption;
use Enhavo\Bundle\ShopBundle\Factory\ProductVariantProxyFactory;
use Enhavo\Bundle\ShopBundle\Factory\UserAddressFactory;
use Enhavo\Bundle\ShopBundle\Factory\VoucherFactory;
use Enhavo\Bundle\ShopBundle\Factory\VoucherRedemptionFactory;
use Enhavo\Bundle\ShopBundle\Form\Type\VoucherType;
use Enhavo\Bundle\ShopBundle\Model\ProductVariantProxy;
use Enhavo\Bundle\ShopBundle\Repository\VoucherRepository;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('enhavo_shop');
        $rootNode = $treeBuilder->getRootNode();

        $this->addDocumentSection($rootNode);
        $this->addResourcesSection($rootNode);
        $this->addProductSection($rootNode);

        return $treeBuilder;
    }

    private function addDocumentSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('document')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('bill')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('background_image')->defaultValue(null)->end()
                            ->end()
                        ->end()
                        ->arrayNode('packing_slip')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('background_image')->defaultValue(null)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addResourcesSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
            ->end()
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('voucher')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Voucher::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->defaultValue(VoucherRepository::class)->end()
                                        ->scalarNode('factory')->defaultValue(VoucherFactory::class)->end()
                                        ->scalarNode('form')->defaultValue(VoucherType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('voucher_redemption')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(VoucherRedemption::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->defaultValue(EntityRepository::class)->end()
                                        ->scalarNode('factory')->defaultValue(VoucherRedemptionFactory::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('user_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(UserAddress::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('repository')->defaultValue(EntityRepository::class)->end()
                                        ->scalarNode('factory')->defaultValue(UserAddressFactory::class)->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function addProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('variant_proxy')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('model')->defaultValue(ProductVariantProxy::class)->end()
                            ->scalarNode('factory')->defaultValue(ProductVariantProxyFactory::class)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
