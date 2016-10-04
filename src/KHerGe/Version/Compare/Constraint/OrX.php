<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Requires that any constraint in a collection allow a version number.
 *
 * This version number constraint will accept a collection of other
 * constraints. If any constraint allows the version number, the constraint
 * will allow it. If none of the constraint allows the version number, the
 * constraint will not allow it.
 *
 * ```php
 * $and = new OrX(
 *     [
 *         new EqualTo(new Version(1, 2, 3, [], [])),
 *         new GreaterThan(new Version(1, 2, 5, [], [])),
 *     ]
 * );
 *
 * if ($and->allows($version)) {
 *     // $version is equal to 1.2.3 or greater than 1.2.5
 * }
 * ```
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class OrX extends AbstractX
{
    /**
     * {@inheritdoc}
     */
    public function allows(VersionInterface $version) : bool
    {
        foreach ($this->constraints as $constraint) {
            if ($constraint->allows($version)) {
                return true;
            }
        }

        return false;
    }
}
