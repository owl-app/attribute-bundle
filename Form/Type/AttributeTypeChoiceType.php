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

namespace Owl\Bundle\AttributeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AttributeTypeChoiceType extends AbstractType
{
    /** @var array */
    private $attributeTypes;

    public function __construct(array $attributeTypes)
    {
        $this->attributeTypes = $attributeTypes;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => array_flip($this->attributeTypes),
            'choice_translation_domain' => false,
        ]);
    }

    /**
     * @psalm-return ChoiceType::class
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * @psalm-return 'sylius_attribute_type_choice'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_attribute_type_choice';
    }
}
