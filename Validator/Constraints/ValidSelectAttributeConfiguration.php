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

namespace Owl\Bundle\AttributeBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

final class ValidSelectAttributeConfiguration extends Constraint
{
    /** @var string */
    public $messageMultiple = 'sylius.attribute.configuration.multiple';

    /** @var string */
    public $messageMinEntries = 'sylius.attribute.configuration.min_entries';

    /** @var string */
    public $messageMaxEntries = 'sylius.attribute.configuration.max_entries';

    /**
     * @psalm-return 'class'
     */
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * @psalm-return 'sylius_valid_select_attribute_validator'
     */
    public function validatedBy(): string
    {
        return 'sylius_valid_select_attribute_validator';
    }
}
