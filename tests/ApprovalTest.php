<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;
use ApprovalTests\Approvals;

/**
 * This unit test uses [Approvals](https://github.com/approvals/ApprovalTests.php).
 *
 * There are two test cases here with different styles:
 * <li>"foo" is more similar to the unit test from the 'Java' version
 * <li>"thirtyDays" is more similar to the TextTest from the 'Java' version
 *
 * I suggest choosing one style to develop and deleting the other.
 */
class ApprovalTest extends TestCase
{

    public function testListItems(): void
    {
        $items = [
            new Item('foo', 0, 0),
            new Item('foo', 0, 1),
            new Item('Aged Brie', 0, 1),
            new Item('Backstage passes to a TAFKAL80ETC concert', 0, 1),
            new Item('foo', 0, 2),
            new Item('Aged Brie', 0, 50),
            new Item('Aged Brie', 11, 48),
            new Item('Backstage passes to a TAFKAL80ETC concert', 10, 48),
            new Item('Backstage passes to a TAFKAL80ETC concert', 5, 48),
        ];
        $app = new GildedRose($items);
        $app->updateQuality();

        Approvals::verifyList($items);
    }

    public function testThirtyDays(): void
    {
        ob_start();

        $argv = ["", "30"];
        include(__DIR__ . '/../fixtures/texttest_fixture.php');

        $output = ob_get_clean();

        Approvals::verifyString($output);
    }
}
