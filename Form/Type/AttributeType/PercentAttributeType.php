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

namespace Owl\Bundle\AttributeBundle\Form\Type\AttributeType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PercentAttributeType extends AbstractType
{
    /**
     * @psalm-return PercentType::class
     */
    public function getParent(): string
    {
        return PercentType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'label' => false,
            ])
            ->setRequired('configuration')
            ->setDefined('locale_code')
        ;
    }

    /**
     * @psalm-return 'sylius_attribute_type_percent'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_attribute_type_percent';
    }
}
