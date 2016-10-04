<?php

namespace KHerGe\Version\Compare;

use KHerGe\Version\Compare\Constraint\EqualTo;
use KHerGe\Version\Compare\Constraint\GreaterThan;
use KHerGe\Version\Compare\Constraint\LessThan;
use KHerGe\Version\VersionInterface;

/**
 * Checks if two semantic version numbers are equal.
 *
 * @param VersionInterface $left  The left number.
 * @param VersionInterface $right The right number.
 *
 * @return boolean Returns `true` if the `$left` and `$right` numbers are
 *                 equal to each other. Otherwise, `false` is returned.
 */
function is_equal_to(
    VersionInterface $left,
    VersionInterface $right
) : bool {
    return (new EqualTo($left))->allows($right);
}

/**
 * Checks if a version number is greater than another.
 *
 * @param VersionInterface $left  The left number.
 * @param VersionInterface $right The right number.
 *
 * @return boolean Returns `true` if the `$left` number is greater than
 *                 the `$right` number. Otherwise, `false` is returned.
 */
function is_greater_than(
    VersionInterface $left,
    VersionInterface $right
) : bool {
    return (new GreaterThan($right))->allows($left);
}

/**
 * Checks if a version number is less than another.
 *
 * @param VersionInterface $left  The left number.
 * @param VersionInterface $right The right number.
 *
 * @return boolean Returns `true` if the `$left` number is less than
 *                 the `$right` number. Otherwise, `false` is returned.
 */
function is_less_than(
    VersionInterface $left,
    VersionInterface $right
) : bool {
    return (new LessThan($right))->allows($left);
}
