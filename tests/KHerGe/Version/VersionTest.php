<?php declare(strict_types=1);

namespace Test\KHerGe\Version;

use KHerGe\Version\Version;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the semantic version number functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Version
 *
 * @covers ::__construct
 */
class VersionTest extends TestCase
{
    /**
     * The build metadata.
     *
     * @var string[]
     */
    private $build = ['x', 'y', 'z'];

    /**
     * The major version number.
     *
     * @var integer
     */
    private $major = 1;

    /**
     * The minor version number.
     *
     * @var integer
     */
    private $minor = 2;

    /**
     * The patch version number.
     *
     * @var integer
     */
    private $patch = 3;

    /**
     * The pre-release metadata.
     *
     * @var string[]
     */
    private $preRelease = ['a', 'b', 'c'];

    /**
     * The semantic version number.
     *
     * @var Version
     */
    private $version;

    /**
     * Returns the version numbers to check for stability.
     *
     * @return array[] The test case arguments.
     */
    public function getStabilityVersions()
    {
        return [

            // unstable: 0.1.2
            [new Version(0, 1, 2, [], []), false],

            // unstable: 1.2.3-a
            [new Version(1, 2, 3, ['a'], []), false],

            // stable: 1.2.3
            [new Version(1, 2, 3, [], []), true]

        ];
    }

    /**
     * Verify that the object can be cast as a string.
     *
     * @covers ::__toString
     */
    public function testCastingToStringReturnsAStringRepresentation()
    {
        self::assertEquals(
            sprintf(
                '%d.%d.%d-%s+%s',
                $this->major,
                $this->minor,
                $this->patch,
                join('.', $this->preRelease),
                join('.', $this->build)
            ),
            (string) $this->version,
            'The expected string representation was not returned.'
        );
    }

    /**
     * Verify that the build metadata can be retrieved.
     *
     * @covers ::getBuild
     */
    public function testRetrieveTheBuildMetadata()
    {
        self::assertEquals(
            $this->build,
            $this->version->getBuild(),
            'The build metadata was not returned.'
        );
    }

    /**
     * Verify that the major version number can be retrieved.
     *
     * @covers ::getMajor
     */
    public function testRetrieveTheMajorVersionNumber()
    {
        self::assertEquals(
            $this->major,
            $this->version->getMajor(),
            'The major version number was not returned.'
        );
    }

    /**
     * Verify that the minor version number can be retrieved.
     *
     * @covers ::getMinor
     */
    public function testRetrieveTheMinorVersionNumber()
    {
        self::assertEquals(
            $this->minor,
            $this->version->getMinor(),
            'The minor version number was not returned.'
        );
    }

    /**
     * Verify that the patch version number can be retrieved.
     *
     * @covers ::getPatch
     */
    public function testRetrieveThePatchVersionNumber()
    {
        self::assertEquals(
            $this->patch,
            $this->version->getPatch(),
            'The patch version number was not returned.'
        );
    }

    /**
     * Verify that the pre-release metadata can be retrieved.
     *
     * @covers ::getPreRelease
     */
    public function testRetrieveThePreReleaseMetadata()
    {
        self::assertEquals(
            $this->preRelease,
            $this->version->getPreRelease(),
            'The pre-release metadata was not returned.'
        );
    }

    /**
     * Verify that the stableness can be checked.
     *
     * @param Version $version The version to check.
     * @param boolean $stable  Is it stable?
     *
     * @covers ::isStable
     *
     * @dataProvider getStabilityVersions
     */
    public function testCheckIfVersionIsStable(Version $version, bool $stable)
    {
        self::assertSame(
            $stable,
            $version->isStable(),
            sprintf(
                'The number was unexpectedly %s.',
                $stable ? 'unstable' : 'stable'
            )
        );
    }

    /**
     * Creates a new semantic version number.
     */
    protected function setUp()
    {
        $this->version = new Version(
            $this->major,
            $this->minor,
            $this->patch,
            $this->preRelease,
            $this->build
        );
    }
}
