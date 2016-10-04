<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Requires that the given version be less than the constraint version.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class LessThan extends AbstractCompare
{
    /**
     * {@inheritdoc}
     */
    public function allows(VersionInterface $version) : bool
    {
        return (1 === $this->compareTo($version));
    }
}
