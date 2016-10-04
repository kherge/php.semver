<?php

namespace Test\KHerGe\Version;

use KHerGe\Version\Exception\InvalidStringRepresentationException;
use PHPUnit_Framework_TestCase as TestCase;

use function KHerGe\Version\is_valid;
use function KHerGe\Version\parse_components;

/**
 * Verifies that the version functions function as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class functionsTest extends TestCase
{
    /**
     * Returns string representations for validation testing.
     *
     * @return array The test case arguments.
     */
    public function getStringRepresentations() : array
    {
        return [

            ['x.0.0', false],
            ['0.x.0', false],
            ['0.0.x', false],

            ['-1.0.0', false],
            ['0.-1.0', false],
            ['0.0.-1', false],

            ['0.0.0-', false],
            ['0.0.0+', false],

            ['0.0.0-!', false],
            ['0.0.0+!', false],

            ['0.0.0+0+0', false],

            ['00.0.0', false],
            ['0.00.0', false],
            ['0.0.00', false],

            ['00.00.00', false],

            ['0.0.0', true],
            ['1.0.0', true],
            ['0.1.0', true],
            ['0.0.1', true],
            ['1.1.1', true],

            ['0.0.0+0', true],
            ['0.0.0-0', true],

            ['0.0.0-0+0', true],
            ['0.0.0-0-0', true],
            ['0.0.0+0-0', true],
            ['0.0.0-a-a', true],
            ['0.0.0-a+a', true],
            ['0.0.0+a-a', true],

            ['10.0.0', true],
            ['0.10.0', true],
            ['0.0.10', true],
            ['10.10.10', true],

        ];
    }

    /**
     * Verify that the string representation can be validated.
     *
     * @param string  $string The string representation.
     * @param boolean $valid  Is the representation valid?
     *
     * @covers \KHerGe\Version\is_valid
     *
     * @dataProvider getStringRepresentations
     */
    public function testValidateAStringRepresentation(
        string $string,
        bool $valid
    ) {
        self::assertSame(
            $valid,
            is_valid($string),
            sprintf(
                'The string representation was unexpectedly %s.',
                $valid ? 'not valid' : 'valid'
            )
        );
    }

    /**
     * Verify that parsing an invalid string representation throws an exception.
     *
     * @covers \KHerGe\Version\parse_components
     */
    public function testParsingComponentsFromAnInvalidStringRepresentationThrowsAnException()
    {
        $this->expectException(InvalidStringRepresentationException::class);

        parse_components('x.y.z');
    }

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

        self::assertEquals(
            [
                'major' => 1,
                'minor' => 2,
                'patch' => 3,
                'pre-release' => [],
                'build' => []
            ],
            parse_components('1.2.3'),
            'The string representation was not parsed correctly.'
        );
    }
}
