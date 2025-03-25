<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
    private const STANDARD_ITEM_NAME = 'standard';
    private const MINIMUM_QUALITY = 0;

    public function testGivenStandardItemWhenQualityIsGreaterThanZeroThenBothSellAndQualityDecreaseOne(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = 0;
        $currentItemQuality = 1;
        $item = new Item($currentItemName, $currentItemSellIn, $currentItemQuality);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -1;
        $expectedItemQuality = self::MINIMUM_QUALITY;
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }
    
    public function testGivenStandardItemWhenQualityIsZeroThenSellInDecreasesOneAndQualityReamainsZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = 0;
        $currentItemQuality = self::MINIMUM_QUALITY;
        $item = new Item($currentItemName, $currentItemSellIn, $currentItemQuality);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -1;
        $expectedItemQuality = self::MINIMUM_QUALITY;
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }

    public function testGivenStandardItemWhenTheSellInHasPassedThenSellInDecreasesByOneAndQualityDecreasesTwiceAsFast(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 2;
        $item = new Item($currentItemName, $currentItemSellIn, $currentItemQuality);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_QUALITY;
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }

    public function testGivenStandardItemWhenTheSellInHasPassedAndQualityIsZeroThenSellInDecreasesByOneAndQualityRemainsZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 0;
        $item = new Item($currentItemName, $currentItemSellIn, $currentItemQuality);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_QUALITY;
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }

    public function testGivenStandardItemWhenTheSellInHasPassedAndQualityIsOneThenSellInDecreasesByOneAndQualityDecresesTillZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 1;
        $item = new Item($currentItemName, $currentItemSellIn, $currentItemQuality);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_QUALITY;
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }
}
