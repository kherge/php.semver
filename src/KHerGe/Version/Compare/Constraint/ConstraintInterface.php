<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Defines the public interface for a comparison constraint.
 *
 * A constraint simply determines if a version number is allowed. What the
 * conditions of the constraint are is dependent on the implementation of
 * the constraint. With mindful design, constraints can be changed or even
 * nested to perform more complex comparison operations.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface ConstraintInterface
{
    /**
     * Checks if a version number is allowed by the constraint.
     *
     * This method will check to see if the given version number satisfies
     * the restriction imposed by this constraint. If the version number is
     * satisfactory, `true` is returned as indication of success. Otherwise,
     * `false` is returned indicating that the constraint was not satisfied.
     *
     * ```php
     * if ($constraint->allows($version)) {
     *     // $version is allowed
     * }
     * ```
     *
     * @param VersionInterface $version The version to constrain.
     *
     * @return boolean Returns `true` if it is allowed, `false` if not.
     */
    public function allows(VersionInterface $version) : bool;
}
