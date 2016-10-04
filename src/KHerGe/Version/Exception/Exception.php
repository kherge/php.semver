<?php

namespace KHerGe\Version\Exception;

/**
 * The base exception class for the library.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Exception extends \Exception
{
    /**
     * Initializes the new exception.
     *
     * @param string     $format    The message format.
     * @param mixed      $value,... The value to format.
     * @param \Exception $previous  The previous exception.
     */
    public function __construct(string $format, ...$value)
    {
        $previous = null;

        if (end($value) instanceof \Exception) {
            $previous = array_pop($value);
        }

        parent::__construct(sprintf($format, ...$value), 0, $previous);
    }
}
