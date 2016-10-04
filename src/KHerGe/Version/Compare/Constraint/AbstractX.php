<?php

namespace KHerGe\Version\Compare\Constraint;

/**
 * Handles basic functionality for a set of constraints.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
abstract class AbstractX implements ConstraintInterface
{
    /**
     * The constraints to enforce.
     *
     * @var ConstraintInterface
     */
    protected $constraints;

    /**
     * Initializes the new constraint.
     *
     * @param ConstraintInterface[] $constraints The constraints to enforce.
     */
    public function __construct(array $constraints)
    {
        $this->constraints = $constraints;
    }
}
