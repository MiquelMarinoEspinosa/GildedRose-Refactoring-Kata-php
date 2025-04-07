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

## Refactors
The refactors have been implemented in 3 different branches. Check them out to see the solution proposal. The `README.md` has been updated in all branches with the followed steps

- `refactor-add-test-coverage`
    - Add unit test coverage to the initial implementation
- `refactor-quick-wins`
    - Refactor applying quick wins at the `GildedRose` class
- `refactor-template-method`
    - Refactor quick wins applying the `template method` design pattern

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
        - Consider a data provider!
- Add unit tests for sell by date has passed
    - When `quality` is `0` does not decrease the `quality`
    - When `quality` is `1` decreases the `quality` down to `0`
- Refactor tests
    - `DataProvider` approach discarded because it would decrease test class clarity
    - Extract item creation and update into a new private method called `whenUpdateItem`
    - Extract assertions code into a private method called `thenItemHasBeenUpdatedAsExpected`
    - Notice that the new 2 private methods as well as the tests names follow the `GivenWhenThen` notation
    - Notice also that the 2 refactors have been pushed in independent commits
- So far these 2 requirements have been covered by the current tests
    - Once the sell by date has passed, Quality degrades twice as fast
    - The Quality of an item is never negative
- Next step, test the new requirement in the list
    - "Aged Brie" actually increases in Quality the older it gets
    - It has been found that when "Aged Brie" `sellIn` has passed, the `quality` increases by `2`. Covered already with a test
- Refactor step
    - Extract `Aged Brie` name into a constant
    - Refactor `MINIMUM_QUALITY` constant in to `MINIMUM_ITEM_QUALITY` fro the sake of readability
- Unit test quality no more than `50` for `Aged Brie`
- Unit test for `Sulfuras` expectations
    - I have had to take a look into the code because intially I have coded with only `Sulfuras` name but the test has not passed. Checking the code I have noticed that the right name is `Sulfuras, Hand of Ragnaros` :)

- Unit tests to cover `Backstage passes`
    - Side note: start to reconsider the `data provider` approach now that I have just gotten familiar with the logic and the tests
- At this point all the current logic should have been covered by unit tests according to the requirements
    - No refactor has been done yet
    - First the current coverage for the `GildedRose` class would be checked
        - In case that it is not 100%, new unit tests would be added to finalize the coverage
    - Once has been checked that the class has been fully covered by unit tests, branches would be created from this one to apply the refactors and eventually add the required new logic for the `Conjured` product
- The `GildedRose` has `100%` coverage ^_^. Notice that the unit tests have been implemented without looking at the code logic, just using as guide the requirements explained at the `GildedRoseRequirements.md`
- Ready to start the refactor |:D

#### Refactor quick wins
- A new branch would be created called `refactor-quick-wins`
- Eventually, the unit test class would be refactor to use `data provider`. It feels like a cleaner solution than the current one
- Quick wins would be applied and the logic decoupled by items at the same very class
- Once the logic has been decoupled, there are a couple of ideas to refactor and place the item's logic to its own classes
        - `strategy pattern`
        - `polimorfysm` without altering the `Item` class
        - For each solution, a new branch would be added
- Eventually the new logic would be added
    - In a real case scenario it could be that there is some urgency to add this logic. Then, once the tests have been finished, I would use the current code to very quick adding the new logic in the legacy code. I would follow a TDD approach. I might do this approach in a different branch also. The inconvinient of this approach is that the refactor should be left for further iterations with the risk of never doing it. Is the developer and team responsability to push further on paying this technical debt at some point in the nearest future
- Refactor unit test to use a data provider
    - The migration has been done test by test, removing the test migrated at each step and checking the coverage every time a test has been migrated
- Checking on quick wins to start the refactor
    - Every time a refactor is applied, the tests would be executed with their coverage to guarantee the correctness of the process
    - Change `$item->quality - $item->quality` to `0`
    - Extract magic numbers into constants as it has been done at the test class
        - extract `0` into `MINIMUM_ITEM_QUALITY` constant
        - extract `50` into `MAXIMUM_ITEM_QUALITY` constant
    - Extract magic strings into constans as it has been done at the test class to improve readability
        - extract `Aged Brie` string into a constant
        - extract `Sulfuras, Hand of Ragnaros` string into a constant
        - extract `Backstage passes to a TAFKAL80ETC concert` string into a constant
- Extract paragraph loop inside code into a private method to reduce nesting level and improve readability
- Extract `increase` item `quality` by one in a private method to improve readability
- Extract `decrease` item `quality` by one in a private method to improve readability
- Extract `decrease` item `sellIn` in a private method to improve readability
- Move related new private methods conditions into the new private methods
    - Move `$item->quality < self::MAXIMUM_ITEM_QUALITY` to `increaseItemQuality` to enhance `tell do not ask` principle
    - Move `$item->name != self::SULFURAS_ITEM_NAME` and `$item->quality > self::MINIMUM_ITEM_QUALITY` to `decreaseItemQuality`
    - Move `$item->name != self::SULFURAS_ITEM_NAME` to `decreaseSellIn` method
- Extract `backstage passes quality` increase item quality into a private method
- Next steps
    - Change conditionals private methods into early returns guard clauses
    - Move and refactor last conditions in the `updateItem` to the private methods
- Change conditionals private methods into early returns guard clauses changing the conditional into its contrary, which will increase the readability as well as reduce the cognitive load
    - Change `decreaseItemSellIn` `sulfuras` conditional into early return using yoda condition
    - Change `increaseItemQuality` `maximum item quality` conditional into early return
    - Change `increaseBackstagePassesQuality` conditionals
        - Change `$item->sellIn < 6` inner conditional into early return
        - Change `$item->sellIn < 11` inner conditional into early return
        - Change `backstage passes` outter conditional into early return
    - Change `decreaseItemQuality` conditionals
        - Change `sulfuras` item name inner conditions into early return with yoda condition
        - Change `minimum item quality` outer condition into early return
    - Move `increaseBackstagePassesQuality` logic into `increaseItemQuality` method  and remove call in `updateItem` method
    - Change `updateItem` `$item->sellIn < 0` conditionals into early return
    - Move `BACKSTAGE_PASSES_ITEM_NAME` inner conditional logic into `decreaseItemQuality`
- Next steps
    - Move after `sellIn` check `updateItem` `AGED_BRIE_ITEM_NAME` conditional into `decreaseItemQuality`
- Move `backstage passes minimum quality when sellIn has passed` from `decreaseItemQuality` to `increaseItemQuality`
    - According to the requirements and the code implementation, the `backstage passes` always `increases` its `quality` until the `sellIn` has passed
    - Then changes its quality to `0` which creates the fall impresion that the logic should be implemented in `decreaseItemQuality`
    - However the `decreaseItemQuality` method is never called for `backstage passes`. Instead `increaseItemQuality` is called. For that reason this logic has eventually been placed at this method
- Slowly during the refactors, started to emerge a design proposal by the code which indicates that applying `polymorfism` might be a good idea, more specifically applying the `template method design pattern`
- Duplicate `$item->name != self::AGED_BRIE_ITEM_NAME and $item->name != self::BACKSTAGE_PASSES_ITEM_NAME` conditional logic for both code's block - before and after updating `sellIn`
- Inverse `$item->name != self::AGED_BRIE_ITEM_NAME and $item->name != self::BACKSTAGE_PASSES_ITEM_NAME` conditional to possitive `self::AGED_BRIE_ITEM_NAME === $item->name || self::BACKSTAGE_PASSES_ITEM_NAME === $item->name` conditional to reduce cognitive load
- Extract `decrease` and `increase` quality from `updateItem` into a new method called `updateItemQuality`

#### Refactor template method

- After the first refactor applying quick wins, emerged an indication of design pattern analysing the `updateItem` method
    - The method has `4` well defined steps
        - `updateItemQuality`
        - `decreaseSellIn`
        - `check sell in has passed`
        - `updateItemQuality`
    - Notice also that the different logic applied by item is encapsulated at the methods
- It looks like that the `template method` design pattern can be applied for this code
    - Unfortunatelly, the `Item` class cannot be changed due to previous requirements
    - Therefore, a new class called `UpdatableItem` would be created, which will have the same data as `Item`
    - The logic at `updateItem` method will be placed at this new class
    - Then the `polymorfism` will be created to move the specific logic to the new `subclasses` which will extend from `UpdatableItem`
    - Finally, the `Conjured` new item logic will be implemented
    - Create `UpdatableItem` class and move `updateItem` method to the new class
    - Add fields to the construct `UpdatableItem` and pass the `Item` valies to the new construct method class
- Use `UpdatableItem` internal values to update the values accordingly and assign the result to `Item` values
- Remove unused `$item` parameter in `UpdatableItem` methods
- Return the `UpdatableItem` once updated and remove `Item` word in `UpdatableItem methods`
- Rename `UpadtableItem` to `StandardUpdatableItem` since some logic will be reused accross to items which does not have special logic, this way a new class will not be created to cover the generic update logic
- Implement a `factory method` to create `StandardUpdatableItem` instances
- Revert `StandardUpdatableItem` name change to `UpdatableItem` again for the sake of clarity
- Change `UpdatableItem` construct method to `protected` to force clients to use the factory method to instantiate the class
- Create a new folder to place the `UpdatableItem` related code
- Create a new class `SulfurasUpdatableItem` which extends from `UpdatableItem` and instanciate it at the factory method
- Change `updateQuality` method visibility to `protected` and pull down the `sulfuras` logic to the `SulfurasUpdatableItem`
- Change `sellIn` method visibility to `protected` and pull down the `sulfuras` logic to the `SulfurasUpdatableItem`
- Introduce `AgedBrieUpdatableItem` `UpdatableItem` subclass
- Middleway refactor strategy clarification
    - At this point, the subclasses are being introduced to pull down the specific logic from this items from `UpdatableItem` generic class to the `subclasses`
    - The goal is to remove all the item's specific logic from `UpdatableItem` and just leave the common code accross all the products
- Pull down `updateQuality` `aged brie` business logic at `AgedBrieUpdatableItem` subclass
- Replace if conditions at the `factory method` for `match` instruction
- Remove `aged brie` at `updateQuality` unused condition to `increaseQuality`
- Introduce `BackstagePassesUpdatableItem` subclass
- Pull down `incrementQuality` logic from `UpdatableItem` superclass to `BackstagePassesUpdatableItem` subclass
- Introduce `MINIMUM_QUALITY` constant at `BackstagePassesUpdatableItem` and rename `UpdatableItem` constants to remove `Item` word
- refactor `decreaseQuality` inline method
- refactor extract `sellIn` check logic into a new method for the sake of increasing readability
- At this point the refactor can be considered finished
    - The `template method pattern` has been applied for the refactor
    - The template method is `update` at the `UpdatableItem`
    - The override methods called at the template method by the subclasses are
        - `updateQuality` overrided by all subclasses
        - `decreaseSellIn` just overrided by `SulfurasUpdatableItem`
        - In this case niether the methods are abstact nor the `UpdatableItem` class, having the generic methods implementation for the not special cases
- Next steps
    - Introduce `Conjured` updateble item logic using `TDD` strategy
- TDD
    - RED: Implements failing test for `Conjured` new item
    - GREEN: Fix the test applying the mininmum changes
        - The changes are directly added inline at the `updateQuality` `UpdatableItem` parent class with `Conjure` condition
    - BLUE: Add `Conjured` new subclass and pull down its logic from the parent class
        - Introduce `ConjuredUpdatableItem` subclass
        - Pull down its logic from the parent class
- Fix `sellIn` method wrong name to `hasNotPassed`
- Add extra unit test to confirm that the `Conjured` item decreased twice when the item has passed
- TDD
    - RED: add failing test when `Conjured` has minimum quality should not decrease
    - GREEN: apply fix copying safe guard from the parent class
    - BLUES: extract magic number into a constant

- At this point the refactor can be considered finished. Notice that adding the `Conjured` item with the new architecture has been easy and its has not be needed to change the logic of the other logic making easy adding / removing items enhancing `Open close principle` as well as `Single responsability principle` :D
- Ideas for further refactors
    - Extract the `factory method` into a `factory class`
    - Split the unit test by updatable item subclasses
    - Identify common code which can be extracted somehow to the parent class to be reused