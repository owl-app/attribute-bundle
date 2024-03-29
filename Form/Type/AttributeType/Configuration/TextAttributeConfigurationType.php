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

namespace Owl\Bundle\AttributeBundle\Form\Type\AttributeType\Configuration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

final class TextAttributeConfigurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('min', NumberType::class, [
                'label' => 'owl.form.attribute_type_configuration.text.min',
                'required' => false,
            ])
            ->add('max', NumberType::class, [
                'label' => 'owl.form.attribute_type_configuration.text.max',
                'required' => false,
            ])
        ;
    }

    /**
     * @psalm-return 'sylius_attribute_type_configuration_text'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_attribute_type_configuration_text';
    }
}
