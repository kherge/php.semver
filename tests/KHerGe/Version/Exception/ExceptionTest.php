<?php

namespace Test\KHerGe\Version\Exception;

use KHerGe\Version\Exception\Exception;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the base exception class functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Exception\Exception
 */
class ExceptionTest extends TestCase
{
    /**
     * Verify that a new exception can be created.
     *
     * @covers ::__construct
     */
    public function testCreateANewException()
    {
        $previous = new \Exception();
        $exception = new Exception(
            'This is a %s message.',
            'test',
            $previous
        );

        self::assertEquals(
            'This is a test message.',
            $exception->getMessage(),
            'The exception message was not set properly.'
        );

        self::assertSame(
            $previous,
            $exception->getPrevious(),
            'The previous exception was not set.'
        );
    }
}
