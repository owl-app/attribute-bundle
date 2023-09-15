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

namespace Owl\Bundle\AttributeBundle;

use Owl\Bundle\AttributeBundle\DependencyInjection\Compiler\RegisterAttributeFactoryPass;
use Owl\Bundle\AttributeBundle\DependencyInjection\Compiler\RegisterAttributeTypePass;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class OwlAttributeBundle extends AbstractResourceBundle
{
    /**
     * @return string[]
     *
     * @psalm-return list{'doctrine/orm'}
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterAttributeTypePass());
        $container->addCompilerPass(new RegisterAttributeFactoryPass());
    }

    /**
     * @psalm-suppress MismatchingDocblockReturnType https://github.com/vimeo/psalm/issues/2345
     *
     * @psalm-return 'Owl\Component\Attribute\Model'
     */
    protected function getModelNamespace(): string
    {
        return 'Owl\Component\Attribute\Model';
    }
}
