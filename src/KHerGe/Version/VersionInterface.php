<?php

namespace KHerGe\Version;

/**
 * Defines the public interface for a semantic version number.
 *
 * This interface defines the public interface for a class that is designed
 * to manages the information for a semantic version number as it is defined
 * in [version 2](http://semver.org/spec/v2.0.0.html) of the specification.
 * While this documentation provides a rough overview of what each value is
 * representing, it is strongly advised that you read and understand the
 * specification.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface VersionInterface
{
    /**
     * Returns a string representation of the semantic version number.
     *
     * A semantic version number consists of major, minor, and patch number
     * delimited by a dot (i.e. `.`). The number may optionally be followed
     * by pre-release metadata, prefixed with a dash (i.e. `-`). The number
     * may also be followed by build metadata, prefixed with a plus (i.e.
     * `+`).
     *
     * @return string The string representation.
     */
    public function __toString();

    /**
     * Returns the build metadata.
     *
     * The build metadata is a list of identifiers used to identify specifics
     * about a build. This build metadata is ignored when version numbers are
     * compared. Each identifier in the build metadata will only consist of
     * 0-9, A-Z, a-z, and/or a dash (i.e. `-`).
     *
     * The build metadata is typically used to hold a date or build number.
     *
     * ```php
     * // 1.2.3+20161004
     * echo $version->getBuild()[0]; // 20161004
     *
     * // 1.2.3+x86-64.20161004
     * echo $version->getBuild()[0]; // x86-64
     * ```
     *
     * @return string[] The build metadata.
     */
    public function getBuild() : array;

    /**
     * Returns the major version number.
     *
     * The major version number is used to indicate backwards compatibility
     * with earlier releases of the same version number. A change that breaks
     * backwards compatibility will have an incremented major version number.
     *
     * ```php
     * if ($a->getMajor() === $b->getMajor()) {
     *     // $a and $b are compatible
     * }
     * ```
     *
     * ```php
     * if ($a->getMajor() < $b->getMajor()) {
     *     // $b has backwards incompatible changes
     * }
     * ```
     *
     * @return integer The major version number.
     */
    public function getMajor() : int;

    /**
     * Returns the minor version number.
     *
     * The minor version number is used to indicate the addition of one or more
     * new backwards compatible features. A minor version number bump could also
     * result from existing features being marked as deprecated. The deprecated
     * features will only be removed in a major version number release.
     *
     * ```php
     * if ($a->getMajor() === $b->getMajor()) {
     *     if ($a->getMinor() < $b->getMinor()) {
     *         // $b has new features available
     *     }
     * }
     * ```
     *
     * @return integer The minor version number.
     */
    public function getMinor() : int;

    /**
     * Returns the patch version number.
     *
     * The patch version number is used to indicate the addition of backwards
     * compatible bug fixes. A bug fix is defined as an internal change that
     * fixes incorrect behavior.
     *
     * ```php
     * if ($a->getMajor() === $b->getMajor()) {
     *     if ($a->getMinor() === $b->getMinor()) {
     *         if ($a->getPatch() < $b->getPatch()) {
     *             // $b has bug fixes
     *         }
     *     }
     * }
     * ```
     *
     * @return integer The patch version number.
     */
    public function getPatch() : int;

    /**
     * Returns the pre-release metadata.
     *
     * The pre-release metadata is a list of identifiers used to identify the
     * progress towards a future version number. Pre-release identifiers that
     * are commonly used are "alpha", "beta", "RC", and others. When comparing
     * version numbers, a version number with pre-release metadata is always a
     * lower precedence than an equivalent version number without pre-release
     * metadata.
     *
     * ```php
     * if ($a->getMajor() === $b->getMajor()) {
     *     if ($a->getMinor() === $b->getMinor()) {
     *         if ($a->getPatch() === $b->getPatch()) {
     *             if (!empty($a->getPreRelease()) && empty($b->getPreRelease())) {
     *                 // $b is greater
     *             }
     *         }
     *     }
     * }
     * ```
     *
     * @return string[] The pre-release metadata.
     */
    public function getPreRelease() : array;

    /**
     * Checks if the version number is considered stable.
     *
     * A stable version number is any number with a major version greater than
     * zero (i.e. `0`) and has no pre-release metadata. Any version number with
     * zero as the major version number or with any pre-release metadata is
     * always considered unstable.
     *
     * @return boolean Returns `true` if stable, `false` if unstable.
     */
    public function isStable() : bool;
}
