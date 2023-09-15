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

use Owl\Component\Attribute\Model\AttributeInterface;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

abstract class AttributeType extends AbstractResourceType
{
    /** @var string */
    protected $attributeTranslationType;

    /** @var FormTypeRegistryInterface */
    protected $formTypeRegistry;

    public function __construct(
        string $dataClass,
        array $validationGroups,
        FormTypeRegistryInterface $formTypeRegistry,
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->formTypeRegistry = $formTypeRegistry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventSubscriber(new AddCodeFormSubscriber())
            ->add('type', AttributeTypeChoiceType::class, [
                'label' => 'owl.form.attribute.type',
                'disabled' => true,
            ])
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $attribute = $event->getData();

            if (!$attribute instanceof AttributeInterface) {
                return;
            }

            if (!$this->formTypeRegistry->has($attribute->getType(), 'configuration')) {
                return;
            }

            $event->getForm()->add('configuration', $this->formTypeRegistry->get($attribute->getType(), 'configuration'), [
                'auto_initialize' => false,
                'label' => 'sylius.form.attribute_type.configuration',
            ]);
        });
    }
}
