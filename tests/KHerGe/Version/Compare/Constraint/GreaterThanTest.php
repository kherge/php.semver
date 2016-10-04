<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\Compare\Constraint\GreaterThan;

/**
 * Verifies that the `GreaterThan` constraint functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Compare\Constraint\GreaterThan
 */
class GreaterThanTest extends AbstractCompareTestCase
{
    /**
     * Verify that a greater version is allowed.
     *
     * @covers ::allows
     */
    public function testAllowAGreaterVersion()
    {
        $constraint = new GreaterThan($this->createVersion(1));

        self::assertTrue(
            $constraint->allows($this->createVersion(2)),
            'The version 2.0.0 should be allowed over 1.0.0.'
        );
    }

    /**
     * Verify that a lesser version is not allowed.
     *
     * @covers ::allows
     */
    public function testDoNotAllowALesserVersion()
    {
        $constraint = new GreaterThan($this->createVersion(2));

        self::assertFalse(
            $constraint->allows($this->createVersion(1)),
            'The version 1.0.0 should not be allowed over 2.0.0'
        );
    }
}
