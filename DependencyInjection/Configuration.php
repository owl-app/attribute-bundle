<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Owl\Bundle\AttributeBundle\DependencyInjection;

use Owl\Component\Attribute\Model\Attribute;
use Owl\Component\Attribute\Model\AttributeInterface;
use Owl\Component\Attribute\Model\AttributeTranslation;
use Owl\Component\Attribute\Model\AttributeTranslationInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('owl_attribute');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('driver')->defaultValue(SyliusResourceBundle::DRIVER_DOCTRINE_ORM)->end()
            ->end()
        ;

        $this->addResourcesSection($rootNode);

        return $treeBuilder;
    }

    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('subject')->isRequired()->end()
                            ->arrayNode('attribute')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->variableNode('options')->end()
                                    ->arrayNode('classes')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('model')->defaultValue(Attribute::class)->cannotBeEmpty()->end()
                                            ->scalarNode('interface')->defaultValue(AttributeInterface::class)->cannotBeEmpty()->end()
                                            ->scalarNode('controller')->cannotBeEmpty()->end()
                                            ->scalarNode('repository')->cannotBeEmpty()->end()
                                            ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                            ->scalarNode('form')->cannotBeEmpty()->end()
                                        ->end()
                                    ->end()
                                    // ->arrayNode('translation')
                                    //     ->addDefaultsIfNotSet()
                                    //     ->children()
                                    //         ->variableNode('options')->end()
                                    //         ->arrayNode('classes')
                                    //             ->addDefaultsIfNotSet()
                                    //             ->children()
                                    //                 ->scalarNode('model')->defaultValue(AttributeTranslation::class)->cannotBeEmpty()->end()
                                    //                 ->scalarNode('interface')->defaultValue(AttributeTranslationInterface::class)->cannotBeEmpty()->end()
                                    //                 ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                    //                 ->scalarNode('repository')->cannotBeEmpty()->end()
                                    //                 ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                    //                 ->scalarNode('form')->cannotBeEmpty()->end()
                                    //             ->end()
                                    //         ->end()
                                    //     ->end()
                                    // ->end()
                                ->end()
                            ->end()
                            ->arrayNode('attribute_value')
                                ->isRequired()
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->variableNode('options')->end()
                                    ->arrayNode('classes')
                                        ->addDefaultsIfNotSet()
                                        ->children()
                                            ->scalarNode('model')->isRequired()->cannotBeEmpty()->end()
                                            ->scalarNode('interface')->isRequired()->cannotBeEmpty()->end()
                                            ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                                            ->scalarNode('repository')->cannotBeEmpty()->end()
                                            ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                            ->scalarNode('form')->cannotBeEmpty()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
