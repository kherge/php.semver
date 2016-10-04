<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Requires that all constraints in a collection allow a version number.
 *
 * This version number constraint will accept a collection of other constraints
 * that must all allow a given version number. If any one constraint disallows
 * the version number, the version number will not be allowed.
 *
 * ```php
 * $and = new AndX(
 *     [
 *         new GreaterThan(new Version(1, 2, 3, [], [])),
 *         new LessThan(new Version(2, 0, 0, [], [])),
 *     ]
 * );
 *
 * if ($and->allows($version)) {
 *     // $version is greater than 1.2.3
 *     // $version is less than 2.0.0
 * }
 * ```
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class AndX extends AbstractX
{
    /**
     * {@inheritdoc}
     */
    public function allows(VersionInterface $version) : bool
    {
        foreach ($this->constraints as $constraint) {
            if (!$constraint->allows($version)) {
                return false;
            }
        }

        return true;
    }
}
