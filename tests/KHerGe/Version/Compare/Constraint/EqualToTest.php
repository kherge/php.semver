<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\Compare\Constraint\EqualTo;

/**
 * Verifies that `EqualTo` to constraint functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Compare\Constraint\EqualTo
 */
class EqualToTest extends AbstractCompareTestCase
{
    /**
     * Verify that an equal version is allowed.
     *
     * @covers ::allows
     */
    public function testAllowAnEqualVersion()
    {
        $constraint = new EqualTo($this->createVersion(1, 2, 3));

        self::assertTrue(
            $constraint->allows($this->createVersion(1, 2, 3)),
            'The versions 1.2.3 and 1.2.3 should be equal.'
        );
    }

    /**
     * Verify that a non-equal version is not allowed.
     *
     * @covers ::allows
     */
    public function testDoNotAllowNonEqualVersion()
    {
        $constraint = new EqualTo($this->createVersion(1));

        self::assertFalse(
            $constraint->allows($this->createVersion(4)),
            'The versions 1.0.0 and 4.0.0 should not be equal.'
        );
    }
}
