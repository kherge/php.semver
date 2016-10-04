<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\Compare\Constraint\LessThan;

/**
 * Verifies that the `LessThan` constraint functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Compare\Constraint\LessThan
 */
class LessThanTest extends AbstractCompareTestCase
{
    /**
     * Verify that a lesser version is allowed.
     *
     * @covers ::allows
     */
    public function testAllowALesserVersion()
    {
        $constraint = new LessThan($this->createVersion(2));

        self::assertTrue(
            $constraint->allows($this->createVersion(1)),
            'The version 1.0.0 should be allowed under 2.0.0.'
        );
    }

    /**
     * Verify that a greater version is not allowed.
     *
     * @covers ::allows
     */
    public function testDoNotAllowAGreaterVersion()
    {
        $constraint = new LessThan($this->createVersion(1));

        self::assertFalse(
            $constraint->allows($this->createVersion(2)),
            'The version 2.0.0 should not be allowed under 1.0.0'
        );
    }
}
