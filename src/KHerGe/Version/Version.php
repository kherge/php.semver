<?php

namespace KHerGe\Version;

use KHerGe\Version\Compare\Constraint\EqualTo;
use KHerGe\Version\Compare\Constraint\GreaterThan;
use KHerGe\Version\Compare\Constraint\LessThan;

/**
 * Manages the information for a semantic version number as a value object.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Version implements VersionInterface
{
    /**
     * The build metadata.
     *
     * @var string[]
     */
    private $build;

    /**
     * The major version number.
     *
     * @var integer
     */
    private $major;

    /**
     * The minor version number.
     *
     * @var integer
     */
    private $minor;

    /**
     * The patch version number.
     *
     * @var integer
     */
    private $patch;

    /**
     * The pre-release metadata.
     *
     * @var string[]
     */
    private $preRelease;

    /**
     * Initializes the new semantic version number.
     *
     * @param integer  $major      The major version number.
     * @param integer  $minor      The minor version number.
     * @param integer  $patch      The patch version number.
     * @param string[] $preRelease The pre-release metadata.
     * @param string[] $build      The build metadata.
     */
    public function __construct(
        int $major,
        int $minor,
        int $patch,
        array $preRelease,
        array $build
    ) {
        $this->build = $build;
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->preRelease = $preRelease;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        $preRelease = '';

        if (!empty($this->preRelease)) {
            $preRelease = '-' . join('.', $this->preRelease);
        }

        $build = '';

        if (!empty($this->build)) {
            $build = '+' . join('.', $this->build);
        }

        return sprintf(
            '%d.%d.%d%s%s',
            $this->major,
            $this->minor,
            $this->patch,
            $preRelease,
            $build
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBuild() : array
    {
        return $this->build;
    }

    /**
     * {@inheritdoc}
     */
    public function getMajor() : int
    {
        return $this->major;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinor() : int
    {
        return $this->minor;
    }

    /**
     * {@inheritdoc}
     */
    public function getPatch() : int
    {
        return $this->patch;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreRelease() : array
    {
        return $this->preRelease;
    }

    /**
     * Increments the major version number.
     *
     * When an backwards incompatible change is made, the major version
     * number must be incremented. This method will increment the major
     * version number and reset both minor and patch numbers to zero (i.e.
     * `0`) and clear any pre-release or build metadata.
     *
     * ```php
     * $incremented = $version->incrementMajor();
     * ```
     *
     * @param integer $amount The amount to increment by.
     *
     * @return VersionInterface The new semantic version number.
     */
    public function incrementMajor(int $amount = 1) : VersionInterface
    {
        return new Version($this->major + $amount, 0, 0, [], []);
    }

    /**
     * Increments the minor version number.
     *
     * When a new backwards compatible feature is released, or something is
     * deprecated, the minor version number must be incremented. This method
     * will increment the minor version number and reset the patch number to
     * zero (i.e. `0`) and clear any pre-release or build metadata.
     *
     * ```php
     * $incremented = $version->incrementMinor();
     * ```
     *
     * @param integer $amount The amount to increment by.
     *
     * @return VersionInterface The new semantic version number.
     */
    public function incrementMinor(int $amount = 1) : VersionInterface
    {
        return new Version($this->major, $this->minor + $amount, 0, [], []);
    }

    /**
     * Increments the patch version number.
     *
     * When a backwards compatible bug fix is released, the patch version
     * number must be incremented. This method will increment the patch
     * version number and clear any pre-release or build metadata.
     *
     * ```php
     * $increment = $version->incrementPatch();
     * ```
     *
     * @param integer $amount The amount to increment by.
     *
     * @return VersionInterface The new semantic version number.
     */
    public function incrementPatch(int $amount = 1) : VersionInterface
    {
        return new Version(
            $this->major,
            $this->minor,
            $this->patch + $amount,
            [],
            []
        );
    }

    /**
     * Checks if this version number is equal to the one given.
     *
     * @param VersionInterface $version The version to compare against.
     *
     * @return boolean Returns `true` if this number is equal to the one
     *                 that was given. Otherwise, `false` is returned.
     */
    public function isEqualTo(VersionInterface $version)
    {
        return (new EqualTo($version))->allows($this);
    }

    /**
     * Checks if this version number is greater than the one given.
     *
     * @param VersionInterface $version The version to compare against.
     *
     * @return boolean Returns `true` if this number is greater than the one
     *                 that was given. Otherwise, `false` is returned if the
     *                 given number is greater or equal to this number.
     */
    public function isGreaterThan(VersionInterface $version)
    {
        return (new GreaterThan($version))->allows($this);
    }

    /**
     * Checks if this version number is less than the one given.
     *
     * @param VersionInterface $version The version to compare against.
     *
     * @return boolean Returns `true` if this number is less than the one that
     *                 was given. Otherwise, `false` is returned if the given
     *                 number is less or equal to this number.
     */
    public function isLessThan(VersionInterface $version)
    {
        return (new LessThan($version))->allows($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isStable() : bool
    {
        return (0 < $this->major) && empty($this->preRelease);
    }

    /**
     * Sets the new build metadata.
     *
     * ```php
     * $new = $version->setBuild(['a', 'b', 'c']);
     * ```
     *
     * @param string[] $metadata The new build metadata.
     *
     * @return Version The new semantic version number.
     */
    public function setBuild(array $metadata) : Version
    {
        return new Version(
            $this->major,
            $this->minor,
            $this->patch,
            $this->preRelease,
            $metadata
        );
    }

    /**
     * Sets the new major version number.
     *
     * ```php
     * $new = $version->setMajor(9);
     * ```
     *
     * @param integer $number The new major version number.
     *
     * @return Version The new semantic version number.
     */
    public function setMajor(int $number) : Version
    {
        return new Version(
            $number,
            $this->minor,
            $this->patch,
            $this->preRelease,
            $this->build
        );
    }

    /**
     * Sets the new minor version number.
     *
     * ```php
     * $new = $version->setMinor(9);
     * ```
     *
     * @param integer $number The new minor version number.
     *
     * @return Version The new semantic version number.
     */
    public function setMinor(int $number) : Version
    {
        return new Version(
            $this->major,
            $number,
            $this->patch,
            $this->preRelease,
            $this->build
        );
    }

    /**
     * Sets the new patch version number.
     *
     * ```php
     * $new = $version->setPatch(9);
     * ```
     *
     * @param integer $number The new patch version number.
     *
     * @return Version The new semantic version number.
     */
    public function setPatch(int $number) : Version
    {
        return new Version(
            $this->major,
            $this->minor,
            $number,
            $this->preRelease,
            $this->build
        );
    }

    /**
     * Sets the new pre-release metadata.
     *
     * ```php
     * $new = $version->setPreRelease(['a', 'b', 'c']);
     * ```
     *
     * @param string[] $metadata The new pre-release metadata.
     *
     * @return Version The new semantic version number.
     */
    public function setPreRelease(array $metadata) : Version
    {
        return new Version(
            $this->major,
            $this->minor,
            $this->patch,
            $metadata,
            $this->build
        );
    }
}
