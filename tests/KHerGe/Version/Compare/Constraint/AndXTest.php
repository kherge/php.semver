<?php

namespace Test\KHerGe\Version\Compare\Constraint;

use KHerGe\Version\Compare\Constraint\AndX;
use KHerGe\Version\Compare\Constraint\ConstraintInterface;
use KHerGe\Version\VersionInterface;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Verifies that the `AndX` constraint functions as intended.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 *
 * @coversDefaultClass \KHerGe\Version\Compare\Constraint\AndX
 *
 * @covers \KHerGe\Version\Compare\Constraint\AbstractX::__construct
 */
class AndXTest extends TestCase
{
    /**
     * The collection constraint.
     *
     * @var AndX
     */
    private $constraint;

    /**
     * The mocks of constraints in the collection.
     *
     * @var ConstraintInterface[]|MockObject[]
     */
    private $constraints;

    /**
     * Verify that all of the constraints are satisfied.
     *
     * @covers ::allows
     */
    public function testAllConstraintsAreSatisfied()
    {
        $version = $this->createMock(VersionInterface::class);

        $this
            ->constraints[0]
            ->expects(self::once())
            ->method('allows')
            ->with($version)
            ->willReturn(true)
        ;

        $this
            ->constraints[1]
            ->expects(self::once())
            ->method('allows')
            ->with($version)
            ->willReturn(true)
        ;

        self::assertTrue(
            $this->constraint->allows($version),
            'The constraint unexpectedly did not allow the version number.'
        );
    }

    /**
     * Verify that if only one constraint is satisfied, it is not allowed.
     *
     * @covers ::allows
     */
    public function testOnlyOneConstraintIsSatisfied()
    {
        $version = $this->createMock(VersionInterface::class);

        $this
            ->constraints[0]
            ->expects(self::once())
            ->method('allows')
            ->with($version)
            ->willReturn(false)
        ;

        $this
            ->constraints[1]
            ->expects(self::never())
            ->method('allows')
        ;

        self::assertFalse(
            $this->constraint->allows($version),
            'The constraint unexpectedly allowed the version number.'
        );
    }

    /**
     * Creates a new collection constraint.
     */
    protected function setUp()
    {
        $this->constraints[] = $this->createMock(ConstraintInterface::class);
        $this->constraints[] = $this->createMock(ConstraintInterface::class);

        $this->constraint = new AndX($this->constraints);
    }
}
