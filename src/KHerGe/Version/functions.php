<?php

namespace KHerGe\Version;

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
