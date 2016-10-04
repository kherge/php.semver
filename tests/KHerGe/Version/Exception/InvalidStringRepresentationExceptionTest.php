<?php

namespace Test\KHerGe\Version\Exception;

use KHerGe\Version\Exception\InvalidStringRepresentationException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the exception functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Exception\InvalidStringRepresentationException
 */
class InvalidStringRepresentationExceptionTest extends TestCase
{
    /**
     * Verify that the message is formatted correctly.
     *
     * @covers ::with
     */
    public function testExceptionMessageIsFormattedCorrectly()
    {
        $version = 'x.y.z';
        $exception = InvalidStringRepresentationException::with($version);

        self::assertEquals(
            "The string \"$version\" is not a valid representation of a semantic version number.",
            $exception->getMessage(),
            'The exception message was not formatted correctly.'
        );
    }
}
