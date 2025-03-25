# GildedRose Kata - PHP Version

See the [top level readme](../README.md) for general information about this exercise. This is the PHP version of the
GildedRose Kata.

## Installation

The kata uses:

- [8.0+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org)

Recommended:

- [Git](https://git-scm.com/downloads)

See [GitHub cloning a repository](https://help.github.com/en/articles/cloning-a-repository) for details on how to
create a local copy of this project on your computer.

```sh
git clone git@github.com:emilybache/GildedRose-Refactoring-Kata.git
```

or

```shell script
git clone https://github.com/emilybache/GildedRose-Refactoring-Kata.git
```

Install all the dependencies using composer

```shell script
cd ./GildedRose-Refactoring-Kata/php
composer install
```

## Dependencies

The project uses composer to install:

- [PHPUnit](https://phpunit.de/)
- [ApprovalTests.PHP](https://github.com/approvals/ApprovalTests.php)
- [PHPStan](https://github.com/phpstan/phpstan)
- [Easy Coding Standard (ECS)](https://github.com/symplify/easy-coding-standard)

## Folders

- `src` - contains the two classes:
    - `Item.php` - this class should not be changed
    - `GildedRose.php` - this class needs to be refactored, and the new feature added
- `tests` - contains the tests
    - `GildedRoseTest.php` - starter test.
        - Tip: ApprovalTests has been included as a dev dependency, see the PHP version of
          the [Theatrical Players Refactoring Kata](https://github.com/emilybache/Theatrical-Players-Refactoring-Kata/)
          for an example
- `Fixture`
    - `texttest_fixture.php` this could be used by an ApprovalTests, or run from the command line

## Fixture

To run the fixture from the php directory:

```shell
php .\fixtures\texttest_fixture.php 10
```

Change **10** to the required days.

## Testing

PHPUnit is configured for testing, a composer script has been provided. To run the unit tests, from the root of the PHP
project run:

```shell script
composer tests
```

A Windows a batch file has been created, like an alias on Linux/Mac (e.g. `alias pu="composer tests"`), the same
PHPUnit `composer tests` can be run:

```shell script
pu.bat
```

### Tests with Coverage Report

To run all test and generate a html coverage report run:

```shell script
composer test-coverage
```

The test-coverage report will be created in /builds, it is best viewed by opening /builds/**index.html** in your
browser.

The [XDEbug](https://xdebug.org/download) extension is required for generating the coverage report.

## Code Standard

Easy Coding Standard (ECS) is configured for style and code standards, **PSR-12** is used. The current code is not upto
standard!

### Check Code

To check code, but not fix errors:

```shell script
composer check-cs
``` 

On Windows a batch file has been created, like an alias on Linux/Mac (e.g. `alias cc="composer check-cs"`), the same
PHPUnit `composer check-cs` can be run:

```shell script
cc.bat
```

### Fix Code

ECS provides may code fixes, automatically, if advised to run --fix, the following script can be run:

```shell script
composer fix-cs
```

On Windows a batch file has been created, like an alias on Linux/Mac (e.g. `alias fc="composer fix-cs"`), the same
PHPUnit `composer fix-cs` can be run:

```shell script
fc.bat
```

## Static Analysis

PHPStan is used to run static analysis checks:

```shell script
composer phpstan
```

On Windows a batch file has been created, like an alias on Linux/Mac (e.g. `alias ps="composer phpstan"`), the same
PHPUnit `composer phpstan` can be run:

```shell script
ps.bat
```

**Happy coding**!

## Refactor
### Development environment
Execute the following commands to setup the development environment. Notice that `docker` is required

- `make build`
- `make up`
- `make install`

To access to the `docker` container

- `make bash`

### Initial configuration
- Execute the following command to pass the `testThirtyDays`

```
php ./fixtures/texttest_fixture.php 30 > tests/approval
s/ApprovalTest.testThirtyDays.approved.txt
```

The command would add the needed fixture at `tests/approvals/ApprovalTest.testThirtyDays.approved.txt` to compare it with the test output

- Add the following lines at `tests/approvals/ApprovalTest.testFoo.approved.txt` to pass the `testFoo`

```
[0] -> foo, -1, 0

```

Original coverage:
    - Item.php -> 100%
    - GildedRose -> 38.46%
    
### Refactor strategy
- First of all, some unit tests would be created following the `GildedRoseRequirements.md`
- Once the tests have been created, it will be checked whether the code has been 100% covered. Otherwise, more unit test would be added to reach the 100%
- No refactor would be applied up until all the unit tests have been implemented to guarantee the correctness of the current business logic before start the changes on the code :)

#### Test strategy
- Follow the `GildedRoseRequirements.md` rather than focusing on the current `GildedRose` class implementation to create the needed unit tests to cover the business logic explained at the requirements document
- Every time that a test has succesfully been tested, the test would be analyze to see whether the test class can be refactored somehow
- Modify `GildedRoseTest foo` test to provide more readibility to the test and to check `sellIn` and `quality` update when `quality` is `0`
- Create unit test to check the logic when the `sellIn` has not passed and `quality` is greather than `0`
- Refactor the tests
    - Extract item into a variable to facilitate the asserts
    - Extract strings into constants
    - Extract the standard item construction into a method to inhance reusability
    - Extrat minimum quality into a constant to improve readibility
- Unit test for `Once the sell by date has passed, Quality degrades twice as fast`
- Refactor the tests
    - Extract current `sellIn` and `quality` magic values into local `variables`
    - Extract expectations also into local variables
    - Extract `update qualite method
    - Remove `buildStandardItem` to promote other refactors
    - Pending refactors for next iteration
        - Extract item creation and update logic execution into a private method
        - Extract multiple assertions into a private method