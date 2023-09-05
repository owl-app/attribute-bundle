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

use Sylius\Component\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SelectAttributeType extends AbstractType
{
    /** @var string */
    private $defaultLocaleCode;

    public function __construct(TranslationLocaleProviderInterface $localeProvider)
    {
        $this->defaultLocaleCode = $localeProvider->getDefaultLocaleCode();
    }

    /**
     * @return string
     *
     * @psalm-return ChoiceType::class
     */
    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (is_array($options['configuration'])
            && isset($options['configuration']['multiple'])
            && !$options['configuration']['multiple']) {
            $builder->addModelTransformer(new CallbackTransformer(
                /**
                 * @param mixed $array
                 *
                 * @return mixed
                 */
                function ($array) {
                    if (is_array($array) && count($array) > 0) {
                        return $array[0];
                    }

                    return null;
                },
                /**
                 * @param mixed $string 
                 *
                 * @psalm-return list{0?: mixed}
                 */
                function ($string): array {
                    if (null !== $string) {
                        return [$string];
                    }

                    return [];
                }
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setRequired('configuration')
            ->setDefault('placeholder', 'owl.form.attribute_type_configuration.select.choose')
            ->setNormalizer('choices', function (Options $options) {
                if (is_array($options['configuration'])
                    && isset($options['configuration']['choices'])
                    && is_array($options['configuration']['choices'])) {
                    $choices = [];

                    foreach ($options['configuration']['choices'] as $key => $choice) {
                        if (isset($choice['name']) && '' !== $choice['name'] && null !== $choice['name']) {
                            $choices[$key] = $choice['name'];

                            continue;
                        }

                        if (false === isset($choice['name']) || '' === $choice['name']) {
                            continue;
                        }
                    }

                    $choices = array_flip($choices);
                    ksort($choices);

                    return $choices;
                }

                return [];
            })
            ->setNormalizer('multiple', function (Options $options): bool {
                if (is_array($options['configuration']) && isset($options['configuration']['multiple'])) {
                    return $options['configuration']['multiple'];
                }

                return false;
            })
        ;
    }

    /**
     * @return string
     *
     * @psalm-return 'sylius_attribute_type_select'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_attribute_type_select';
    }
}
