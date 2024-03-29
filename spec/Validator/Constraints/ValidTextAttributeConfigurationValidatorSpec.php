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

namespace spec\Owl\Bundle\AttributeBundle\Validator\Constraints;

use Owl\Bundle\AttributeBundle\Validator\Constraints\ValidSelectAttributeConfiguration;
use Owl\Bundle\AttributeBundle\Validator\Constraints\ValidTextAttributeConfiguration;
use Owl\Component\Attribute\AttributeType\SelectAttributeType;
use Owl\Component\Attribute\AttributeType\TextAttributeType;
use Owl\Component\Attribute\Model\AttributeInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class ValidTextAttributeConfigurationValidatorSpec extends ObjectBehavior
{
    public function let(ExecutionContextInterface $context): void
    {
        $this->initialize($context);
    }

    public function it_is_a_constraint_validator(): void
    {
        $this->shouldHaveType(ConstraintValidator::class);
    }

    public function it_adds_a_violation_if_max_entries_value_is_lower_than_min_entries_value(
        ExecutionContextInterface $context,
        AttributeInterface $attribute,
    ): void {
        $constraint = new ValidTextAttributeConfiguration();

        $attribute->getType()->willReturn(TextAttributeType::TYPE);
        $attribute->getConfiguration()->willReturn(['min' => 6, 'max' => 4]);

        $context->addViolation(Argument::any())->shouldBeCalled();

        $this->validate($attribute, $constraint);
    }

    public function it_does_nothing_if_an_attribute_is_not_a_text_type(
        ExecutionContextInterface $context,
        AttributeInterface $attribute,
    ): void {
        $constraint = new ValidTextAttributeConfiguration();

        $attribute->getType()->willReturn(SelectAttributeType::TYPE);

        $context->addViolation(Argument::any())->shouldNotBeCalled();

        $this->validate($attribute, $constraint);
    }

    public function it_throws_an_exception_if_validated_value_is_not_an_attribute(): void
    {
        $constraint = new ValidTextAttributeConfiguration();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('validate', ['badObject', $constraint])
        ;
    }

    public function it_throws_an_exception_if_constraint_is_not_a_valid_text_attribute_configuration_constraint(
        AttributeInterface $attribute,
    ): void {
        $constraint = new ValidSelectAttributeConfiguration();

        $this
            ->shouldThrow(\InvalidArgumentException::class)
            ->during('validate', [$attribute, $constraint])
        ;
    }
}
