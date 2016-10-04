<?php

namespace KHerGe\Version;

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
 * ???
 *
 * @param string $string The string to check.
 *
 * @return boolean Returns `true` if the string representation is a valid
 *                 semantic version number. Otherwise, `false` is returned.
 */
function is_valid(string $string)
{
    return (0 < preg_match(VERSION_FORMAT, $string));
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
 */
function parse_components(string $string) : array
{
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
