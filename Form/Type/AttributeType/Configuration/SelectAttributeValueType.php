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

use Sylius\Bundle\ResourceBundle\Form\Type\FixedCollectionType;
use Sylius\Component\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SelectAttributeValueType extends AbstractType
{
    /** @var string[] */
    private $definedLocalesCodes;

    /** @var string */
    private $defaultLocaleCode;

    public function __construct(TranslationLocaleProviderInterface $localeProvider)
    {
        $this->definedLocalesCodes = $localeProvider->getDefinedLocalesCodes();
        $this->defaultLocaleCode = $localeProvider->getDefaultLocaleCode();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'entries' => ['name'],
            'entry_name' => function (string $name): string {
                return $name;
            },
            // 'entries' => $this->definedLocalesCodes,
            // 'entry_name' => function (string $localeCode): string {
            //     return $localeCode;
            // },
            // 'entry_options' => function (string $localeCode): array {
            //     return [
            //         'required' => $localeCode === $this->defaultLocaleCode,
            //     ];
            // },
        ]);
    }

    /**
     * @psalm-return FixedCollectionType::class
     */
    public function getParent(): string
    {
        return FixedCollectionType::class;
    }

    /**
     * @psalm-return 'sylius_select_attribute_value_translations'
     */
    public function getBlockPrefix(): string
    {
        return 'sylius_select_attribute_value_translations';
    }
}
