<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Simplifies the process of testing comparison constraints.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class AbstractCompareTestCase extends TestCase
{
    /**
     * Creates a new mock semantic version number.
     *
     * @param integer|null $major The major version number.
     * @param integer|null $minor The minor version number.
     * @param integer|null $patch The patch version number.
     * @param array|null   $pre   The pre-release metadata.
     * @param array|null   $build The build metadata.
     *
     * @return MockObject|VersionInterface The mock semantic version number.
     */
    protected function createVersion(
        int $major = null,
        int $minor = null,
        int $patch = null,
        array $pre = null,
        array $build = null
    ) {
        $mock = $this->createMock(VersionInterface::class);

        if (null !== $build) {
            $mock
                ->expects(self::once())
                ->method('getBuild')
                ->willReturn($build)
            ;
        }

        if (null !== $major) {
            $mock
                ->expects(self::once())
                ->method('getMajor')
                ->willReturn($major)
            ;
        }

        if (null !== $minor) {
            $mock
                ->expects(self::once())
                ->method('getMinor')
                ->willReturn($minor)
            ;
        }

        if (null !== $patch) {
            $mock
                ->expects(self::once())
                ->method('getPatch')
                ->willReturn($patch)
            ;
        }

        if (null !== $pre) {
            $mock
                ->expects(self::once())
                ->method('getPreRelease')
                ->willReturn($pre)
            ;
        }

        return $mock;
    }
}
