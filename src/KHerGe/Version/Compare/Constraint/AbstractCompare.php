<?php

namespace KHerGe\Version\Compare\Constraint;

use KHerGe\Version\VersionInterface;

/**
 * Handles basic functionality for comparison constraints.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
abstract class AbstractCompare implements ConstraintInterface
{
    /**
     * The version number to compare against.
     *
     * @var VersionInterface
     */
    private $version;

    /**
     * Initializes the new comparison constraint.
     *
     * @param VersionInterface $version The version number to compare against.
     */
    public function __construct(VersionInterface $version)
    {
        $this->version = $version;
    }

    /**
     * Compares the given version number against the constraint version number.
     *
     * This method will compare the given version number against the version
     * number defined in the constraint. If the version number defined in the
     * constraint is greater than the one given, `1` is returned. If the two
     * version numbers are equal, `0` is returned. If the given version number
     * is greater than the version number defined in the constraint, `-1` is
     * returned.
     *
     * ```php
     * switch ($this->compareTo($version)) {
     *     case 1:
     *         break; // $this is greater
     *     case 0:
     *         break; // $this and $version are equal
     *     case -1:
     *         break; // $version is greater
     * }
     * ```
     *
     * @param VersionInterface $version The version number to compare.
     *
     * @return integer Returns `-1` if the constraint is greater, `0` if the
     *                 version numbers are equal, or `1` if the given version
     *                 number is greater than the constraint.
     */
    protected function compareTo(VersionInterface $version) : int
    {
        $major = $this->compareNumber(
            $this->version->getMajor(),
            $version->getMajor()
        );

        if (0 !== $major) {
            return $major;
        }

        $minor = $this->compareNumber(
            $this->version->getMinor(),
            $version->getMinor()
        );

        if (0 !== $minor) {
            return $minor;
        }

        $patch = $this->compareNumber(
            $this->version->getPatch(),
            $version->getPatch()
        );

        if (0 !== $patch) {
            return $patch;
        }

        return $this->comparePreRelease(
            $this->version->getPreRelease(),
            $version->getPreRelease()
        );
    }

    /**
     * Determines the metadata identifier with the greatest precedence.
     *
     * @param string $left  The left identifier.
     * @param string $right The right identifier.
     *
     * @return integer Returns `1` if the left identifier is greater, `0` if
     *                 both are equal, or `-1` if the right identifier is
     *                 greater.
     */
    private function compareIdentifier(string $left, string $right) : int
    {
        $leftDigit = (0 < preg_match('/^\d+$/', $left));
        $rightDigit = (0 < preg_match('/^\d+$/', $right));

        if ($leftDigit && !$rightDigit) {
            return -1;
        } elseif (!$leftDigit && $rightDigit) {
            return 1;
        }

        return $left <=> $right;
    }

    /**
     * Finds the number with greater precedence.
     *
     * @param integer $left  The left number.
     * @param integer $right The right number.
     *
     * @return integer Returns `1` if the left number is greater, `0` if both
     *                 are equal, or `-1` if the right number is greater.
     */
    private function compareNumber(int $left, int $right) : int
    {
        if ($left > $right) {
            return 1;
        } elseif ($left < $right) {
            return -1;
        }

        return 0;
    }

    /**
     * Finds the identifier with the greater precedence.
     *
     * @param string[] $left  The left metadata identifiers.
     * @param string[] $right The right metadata identifiers.
     *
     * @return integer Returns `1` if the left metadata identifiers have a
     *                 greater precedence, `0` if both sets are equal, or `-1`
     *                 if the right metadata identifiers have a greater
     *                 precedence.
     */
    private function comparePreRelease(array $left, array $right) : int
    {
        $leftEmpty = empty($left);
        $rightEmpty = empty($right);

        if ($leftEmpty && !$rightEmpty) {
            return 1;
        } elseif (!$leftEmpty && $rightEmpty) {
            return -1;
        }

        $count = count($left);
        $left = array_values($left);
        $right = array_values($right);

        for ($i = 0; $i < $count; $i++) {
            if (!isset($right[$i])) {
                return 1;
            }

            $result = $this->compareIdentifier($left[$i], $right[$i]);

            if (0 !== $result) {
                return $result;
            }

            if (!isset($left[$i + 1]) && isset($right[$i + 1])) {
                return -1;
            }
        }

        return 0;
    }
}
