<?php

namespace Test\KHerGe\Version;

use PHPUnit_Framework_TestCase as TestCase;

use function KHerGe\Version\parse_components;

/**
 * Verifies that the version functions function as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class functionsTest extends TestCase
{
    /**
     * Verify that the components can be parsed from a string.
     *
     * @covers \KHerGe\Version\parse_components
     */
    public function testParseComponentsFromAStringRepresentation()
    {
        self::assertEquals(
            [
                'major' => 1,
                'minor' => 2,
                'patch' => 3,
                'pre-release' => ['alpha', '1'],
                'build' => ['20161004']
            ],
            parse_components('1.2.3-alpha.1+20161004'),
            'The string representation was not parsed correctly.'
        );
    }
}
