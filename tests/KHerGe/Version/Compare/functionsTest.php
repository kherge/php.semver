<?php

namespace Test\KHerGe\Version\Compare;

use Test\KHerGe\Version\Compare\Constraint\AbstractCompareTestCase;

use function KHerGe\Version\Compare\is_equal_to;
use function KHerGe\Version\Compare\is_greater_than;
use function KHerGe\Version\Compare\is_less_than;

/**
 * Verifies that the comparison functions function as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class functionsTest extends AbstractCompareTestCase
{
    /**
     * Verify that one version can equal another.
     *
     * @covers \KHerGe\Version\Compare\is_equal_to
     */
    public function testVersionIsEqualToAnother()
    {
        self::assertTrue(
            is_equal_to(
                $this->createVersion(1),
                $this->createVersion(1)
            ),
            'The version 1.0.0 should be equal to 1.0.0.'
        );
    }

    /**
     * Verify that one version can be greater than another.
     *
     * @covers \KHerGe\Version\Compare\is_greater_than
     */
    public function testVersionIsGreaterThanAnother()
    {
        self::assertTrue(
            is_greater_than(
                $this->createVersion(2),
                $this->createVersion(1)
            ),
            'The version 2.0.0 should be greater than 1.0.0.'
        );
    }

    /**
     * Verify that one version can be less than another.
     *
     * @covers \KHerGe\Version\Compare\is_less_than
     */
    public function testVersionIsLessThanAnother()
    {
        self::assertTrue(
            is_less_than(
                $this->createVersion(1),
                $this->createVersion(2)
            ),
            'The version 1.0.0 should be greater than 2.0.0.'
        );
    }
}
