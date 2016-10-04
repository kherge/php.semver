<?php

namespace KHerGe\Version\Exception;

/**
 * An exception thrown for using an invalid string representation.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class InvalidStringRepresentationException extends Exception
{
    /**
     * Creates a new exception for an invalid string representation.
     *
     * @param string $string The invalid string representation.
     *
     * @return InvalidStringRepresentationException The new exception.
     */
    public static function with(string $string)
    {
        return new self(
            'The string "%s" is not a valid representation of a semantic version number.',
            $string
        );
    }
}
