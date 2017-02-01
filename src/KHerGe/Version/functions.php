<?php

namespace KHerGe\Version;

use KHerGe\Version\Exception\InvalidStringRepresentationException;

/**
 * The expression for a valid string representation of a semantic version number.
 *
 * @var string
 */
define(
    'VERSION_FORMAT',
    <<<'REGEX'
/^
    # major
    (?:0|[1-9]\d*)\.

    # minor
    (?:0|[1-9]\d*)\.

    # patch
    (?:0|[1-9]\d*)

    # pre-release
    (?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?

    # build
    (?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?
$/x
REGEX
);

/**
 * Checks if a string representation is a valid semantic version number.
 *
 * This function will check if the string representation conforms to the
 * semantic version number specific (as defined in version 2.0.0). If the
 * string representation is valid, it can then be parsed into its base
 * components.
 *
 * ```php
 * if (is_valid('1.0.0-alpha.1+20161004')) {
 *     // it is valid
 * }
 * ```
 *
 * @param string $string The string to check.
 *
 * @return boolean Returns `true` if the string representation is a valid
 *                 semantic version number. Otherwise, `false` is returned.
 */
function is_valid(string $string) : bool
{
    return (0 < preg_match(VERSION_FORMAT, $string));
}

/**
 * Parses a string representation into a value object.
 *
 * This function will parse the string representation into a semantic version
 * number value object. This value object can then be used for comparisons on
 * other version numbers.
 *
 * ```php
 * $version = parse('1.2.3-alpha.1+20161004');
 * ```
 *
 * @param string $string The string representation to parse.
 *
 * @return Version The semantic version number value object.
 */
function parse(string $string) : Version
{
    $components = parse_components($string);

    return new Version(
        $components['major'],
        $components['minor'],
        $components['patch'],
        $components['pre-release'],
        $components['build']
    );
}

/**
 * Parses a string representation into semantic version number components.
 *
 * This function will break apart a string representation of a semantic
 * version number into its base components. These components can then be
 * used to construct a semantic version number value object.
 *
 * ```php
 * $components = parse_components('1.2.3-alpha.1+20161004');
 * ```
 *
 * ```php
 * $components = [
 *     'major' => 1,
 *     'minor' => 2,
 *     'patch' => 3,
 *     'pre-release' => ['alpha', '1'],
 *     'build' => ['20161004']
 * ];
 * ```
 *
 * @param string $string The string representation to parse.
 *
 * @return array[]|int[] The components.
 *
 * @throws InvalidStringRepresentationException If the string representation
 *                                              does not conform to the semantic
 *                                              versioning specification
 *                                              (version 2.0.0).
 */
function parse_components(string $string) : array
{
    if (!is_valid($string)) {
        throw InvalidStringRepresentationException::with($string);
    }

    $build = explode('+', $string, 2);
    $string = array_shift($build);
    $build = array_pop($build);

    if (null !== $build) {
        $build = explode('.', $build);
    } else {
        $build = [];
    }

    $pre = explode('-', $string, 2);
    $string = array_shift($pre);
    $pre = array_pop($pre);

    if (null !== $pre) {
        $pre = explode('.', $pre);
    } else {
        $pre = [];
    }

    $number = explode('.', $string);

    return [
        'major' => (int) $number[0],
        'minor' => (int) $number[1],
        'patch' => (int) $number[2],
        'pre-release' => $pre,
        'build' => $build
    ];
}
