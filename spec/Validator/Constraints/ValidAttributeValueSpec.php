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

use Owl\Bundle\AttributeBundle\Validator\Constraints\ValidAttributeValue;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Validator\Constraint;

final class ValidAttributeValueSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ValidAttributeValue::class);
    }

    public function it_is_constraint(): void
    {
        $this->shouldHaveType(Constraint::class);
    }

    public function it_has_targets(): void
    {
        $this->getTargets()->shouldReturn(Constraint::CLASS_CONSTRAINT);
    }

    public function it_is_validated_by_specific_validator(): void
    {
        $this->validatedBy()->shouldReturn('sylius_valid_attribute_value_validator');
    }
}
