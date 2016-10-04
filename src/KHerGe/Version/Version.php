<?php

namespace KHerGe\Version;

/**
 * Manages the information for a semantic version number as a value object.
 *
 * @author Kevin Herrera <kherrera@ebsco.com>
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
    public function __toString()
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
     * {@inheritdoc}
     */
    public function isStable() : bool
    {
        return (0 < $this->major) && empty($this->preRelease);
    }
}
