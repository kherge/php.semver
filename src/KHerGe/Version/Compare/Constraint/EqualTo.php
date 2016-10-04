<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Requires that the given version equal to the constraint version.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class EqualTo extends AbstractCompare
{
    /**
     * {@inheritdoc}
     */
    public function allows(VersionInterface $version) : bool
    {
        return (0 === $this->compareTo($version));
    }
}
