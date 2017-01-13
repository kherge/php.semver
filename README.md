[![Build Status](https://travis-ci.org/kherge-php/semver.svg?branch=master)](https://travis-ci.org/kherge-php/semver)
[![Packagist](https://img.shields.io/packagist/v/kherge/semver.svg)](https://packagist.org/packages/kherge/semver)
[![Packagist Pre Release](https://img.shields.io/packagist/vpre/kherge/semver.svg)](https://packagist.org/packages/kherge/semver)

Version
=======

A library for parsing and comparing semantic version numbers.

Usage
-----

Please note that full qualified names are not used in the examples below. All
references to interfaces, classes, and functions can be found in the namespace
`KHerGe\Version`. Also note that the examples below do not demonstrate the
complete abilities of the library. Please refer to the source files for more
information.

### Simple

#### Parsing

For very simple use cases, you only need the `parse()` function.

```php
use function KHerGe\Version\parse;
```

With this function, you can create a value object that represents an individual
semantic version number. The value object is immutable, but convenience methods
are available so that you can alter values and receive new value objects.

```php
// Create a new value object.
$version = parse('1.2.3-alpha.1+20161004');

// Bump the patch number: 1.0.1
$patched = $version->incrementPatch();

// The original value object is unchanged.
echo $version; // 1.2.3-alpha.1+20161004

// But the patched version number has the change.
echo $patched; // 1.2.4
```

#### Comparing

Simple comparisons can also be performed directly on the value objects.

```php
if ($patched->isGreaterThan($version)) {
    // $patched is greater than $version
}
```

#### Validating

While, the `parse()` function throws a `InvalidStringRepresentationException`
for invalid string representations of a semantic version number, you can still
check yourself by using the `is_valid()` function.

```php
use function KHerGe\Version\is_valid;

$version = '1.2.3-alpha.1+20161004';

if (is_valid($version)) {
    // $version is valid
}
```

### Complex

#### Implementations

The library will work on any implementation of `VersionInterface` but provides
a `Version` implementation that includes a lot of extra methods for convenience.

```php
$version = new Version(

    // major
    1,

    // minor
    2,

    // patch
    3,

    // pre-release
    ['a', 'b', 'c'],

    // build
    ['x', 'y', 'z']

);
```

#### Parsing

If you need to use your own implementation of `VersionInterface`, the library
provides a function to parse the components of a string representation so that
you won't have to.

```php
use function KHerGe\Version\parse_components;

$components = parse_components('1.2.3-alpha.1+20161004');
```

The result of `parse_components()` can be used to create a new instance that
implements `VersionInterface`. This function performs its own validation, so
checking with `is_valid()` will be redundant.

```php
$components = [
    'major' => 1,
    'minor' => 2,
    'patch' => 3,
    'pre-release' => ['alpha', '1'],
    'build' => ['20161004']
];
```

#### Comparing

The library contains a set of pre-made constraints, all of which implement
`ConstraintInterface`. These constraints can be mixed and matched in order to
perform far more complex comparison operations than by using the constraints
on their own.

```php
use KHerGe\Version\Compare\Constraint\AndX;
use KHerGe\Version\Compare\Constraint\EqualTo;
use KHerGe\Version\Compare\Constraint\GreaterThan;
use KHerGe\Version\Compare\Constraint\LessThan;
use KHerGe\Version\Compare\Constraint\OrX;

use function KHerGe\Version\parse;

// Match any of the following constraints.
$constraint = new OrX(
    [
        // Match all of the following constraints.
        new AndX(
            [
                // Must be greater than "0.2.3".
                new GreaterThan(parse('0.2.3')),

                // Must be less than "0.4.4".
                new LessThan(parse('0.4.4')),
            ]
        ),

        // Match exactly "0.4.5".
        new EqualTo(parse('0.4.5'))
    ]
);

// Verify that the version meets the constraints.
$version = parse('0.4.0');

if ($constraint->allows($version)) {
    // $version is allowed
}

```

Requires
--------

- PHP 7.0 or greater

Install
-------

To install, you will need to use Composer.

    composer require kherge/semver

License
-------

Released under both MIT and Apache 2.0.

See [LICENSE](LICENSE).
