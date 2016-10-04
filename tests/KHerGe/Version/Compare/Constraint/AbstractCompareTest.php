<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\Compare\Constraint\AbstractCompare;
use KHerGe\Version\VersionInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use ReflectionMethod;

/**
 * Verifies that abstract comparison constraint functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Compare\Constraint\AbstractCompare
 *
 * @covers ::__construct
 */
class AbstractCompareTest extends TestCase
{
    /**
     * Returns the versions to compare against.
     *
     * @return array The test case arguments.
     */
    public function getVersionsToCompare() : array
    {
        return [

            ['0.0.0 === 0.0.0'], // #0
            ['0.0.1 === 0.0.1'], // #1
            ['0.1.0 === 0.1.0'], // #2
            ['1.0.0 === 1.0.0'], // #3

            ['0.0.0-0 === 0.0.0-0'], // #4
            ['0.0.0+0 === 0.0.0+0'], // #5

            ['0.0.2 > 0.0.1'], // #6
            ['0.2.0 > 0.1.0'], // #7
            ['2.0.0 > 1.0.0'], // #8

            ['0.0.0   > 0.0.0-0'], // #9
            ['0.0.0-2 > 0.0.0-1'], // #10
            ['0.0.0-a > 0.0.0-3'], // #11
            ['0.0.0-b > 0.0.0-a'], // #12

            ['0.0.0-a.b.c > 0.0.0-a.1'], // #13
            ['0.0.0-1.2.b > 0.0.0-1.2'], // #14

            ['0.0.0-rc   > 0.0.0-beta'], // #15
            ['0.0.0-beta > 0.0.0-alpha'], // #16

            ['1.0.0            > 1.0.0-rc.1'], // #17
            ['1.0.0-rc.1       > 1.0.0-beta.11'], // #18
            ['1.0.0-beta.11    > 1.0.0-beta.2'], // #19
            ['1.0.0-beta.2     > 1.0.0-beta'], // #20
            ['1.0.0-beta       > 1.0.0-alpha.beta'], // #21
            ['1.0.0-alpha.beta > 1.0.0-alpha.1'], // #22
            ['1.0.0-alpha.1    > 1.0.0-alpha'] // #23

        ];
    }

    /**
     * Verify that the constraint version can be compared against.
     *
     * @param string $rule The constraint rule to test.
     *
     * @covers ::compareIdentifier
     * @covers ::compareNumber
     * @covers ::comparePreRelease
     * @covers ::compareTo
     *
     * @dataProvider getVersionsToCompare
     */
    public function testCompareAgainstConstraintVersion(string $rule)
    {
        list($left, $right, $expect) = $this->parseRule($rule);

        $method = $this->createCompareToMock($left);

        self::assertEquals(
            $expect,
            $method($right),
            preg_replace(
                '/\s+/',
                ' ',
                "The rules \"$rule\" was not true."
            )
        );

        $method = $this->createCompareToMock($right);

        self::assertEquals(
            $expect * -1,
            $method($left),
            preg_replace(
                '/\s+/',
                ' ',
                "The flipped version (a -> b, b <- a) of the rule \"$rule\" was not true."
            )
        );
    }

    /**
     * Creates a new mock abstract compare constraint.
     *
     * @param VersionInterface $version The constraint version.
     *
     * @return callable The `compareTo` method.
     */
    private function createCompareToMock(VersionInterface $version)
    {
        $abstract = $this
            ->getMockBuilder(AbstractCompare::class)
            ->setConstructorArgs([$version])
            ->setMethods(['allows'])
            ->getMockForAbstractClass()
        ;

        $method = new ReflectionMethod(AbstractCompare::class, 'compareTo');
        $method->setAccessible(true);

        return function (VersionInterface $version) use ($abstract, $method) {
            $result = $method->invoke($abstract, $version);

            $method->setAccessible(false);

            return $result;
        };
    }

    /**
     * Parses a constraint rule into usable components.
     *
     * @param string $rule The rule.
     *
     * @return mixed The components.
     */
    private function parseRule(string $rule)
    {
        list($left, $op, $right) = preg_split('/\s+/', $rule);

        switch ($op) {
            case '===':
                $op = 0;
                break;

            case '>':
                $op = 1;
                break;

            case '<':
                $op = -1;
                break;
        }

        return [
            $this->parseVersion($left),
            $this->parseVersion($right),
            $op
        ];
    }

    /**
     * Parses a version string into a mock semantic version number.
     *
     * @param string $version The version string.
     *
     * @return MockObject|VersionInterface The mock semantic version number.
     */
    private function parseVersion(string $version)
    {
        $build = explode('+', $version, 2);
        $version = array_shift($build);
        $build = array_pop($build);
        $build = (null === $build) ? [] : explode('.', $build);

        $pre = explode('-', $version, 2);
        $version = array_shift($pre);
        $pre = array_pop($pre);
        $pre = (null === $pre) ? [] : explode('.', $pre);

        list($major, $minor, $patch) = explode('.', $version);

        $mock = $this->createMock(VersionInterface::class);

        $mock
            ->expects(self::any())
            ->method('getBuild')
            ->willReturn($build)
        ;

        $mock
            ->expects(self::any())
            ->method('getMajor')
            ->willReturn((int) $major)
        ;

        $mock
            ->expects(self::any())
            ->method('getMinor')
            ->willReturn((int) $minor)
        ;

        $mock
            ->expects(self::any())
            ->method('getPatch')
            ->willReturn((int) $patch)
        ;

        $mock
            ->expects(self::any())
            ->method('getPreRelease')
            ->willReturn($pre)
        ;

        $mock
            ->expects(self::any())
            ->method('isStable')
            ->willReturn((0 < (int) $major) && empty($pre))
        ;

        return $mock;
    }
}
