<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
    private const STANDARD_ITEM_NAME = 'Standard';
    private const AGED_BRIE_ITEM_NAME = 'Aged Brie';
    private const MINIMUM_ITEM_QUALITY = 0;
    private const MAXIMUM_ITEM_QUALITY = 50;
    
    public function testGivenStandardItemWhenUpdateWithQualityIsGreaterThanZeroThenBothSellAndQualityDecreaseOne(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = 0;
        $currentItemQuality = 1;

        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -1;
        $expectedItemQuality = self::MINIMUM_ITEM_QUALITY;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );

        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }
    
    public function testGivenStandardItemWhenUpdateWithQualityIsZeroThenSellInDecreasesOneAndQualityReamainsZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = 0;
        $currentItemQuality = self::MINIMUM_ITEM_QUALITY;

        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -1;
        $expectedItemQuality = self::MINIMUM_ITEM_QUALITY;
        
        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );

        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenStandardItemWhenUpdateWithTheSellInHasPassedThenSellInDecreasesByOneAndQualityDecreasesTwiceAsFast(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 2;

        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_ITEM_QUALITY;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );

        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenStandardItemWhenTheUpdateSellInHasPassedAndQualityIsZeroThenSellInDecreasesByOneAndQualityRemainsZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 0;

        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_ITEM_QUALITY;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );

        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenStandardItemWhenUpdateWithTheSellInHasPassedAndQualityIsOneThenSellInDecreasesByOneAndQualityDecresesTillZero(): void
    {
        $currentItemName = self::STANDARD_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 1;
        
        $expectedItemName = self::STANDARD_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = self::MINIMUM_ITEM_QUALITY;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );
        
        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenAgentBrieItemWhenUpdateWithThenQualityIncreasesOnce(): void
    {
        $currentItemName = self::AGED_BRIE_ITEM_NAME;
        $currentItemSellIn = 1;
        $currentItemQuality = 1;
        
        $expectedItemName = self::AGED_BRIE_ITEM_NAME;
        $expectedItemSellIn = 0;
        $expectedItemQuality = 2;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );
        
        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenAgentBrieItemWhenUpdateWithSellInHasPassedThenQualityIncreasesTwice(): void
    {
        $currentItemName = self::AGED_BRIE_ITEM_NAME;
        $currentItemSellIn = 1;
        $currentItemQuality = self::MAXIMUM_ITEM_QUALITY;
        
        $expectedItemName = self::AGED_BRIE_ITEM_NAME;
        $expectedItemSellIn = 0;
        $expectedItemQuality = self::MAXIMUM_ITEM_QUALITY;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );
        
        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    public function testGivenAgentBrieItemWhenUpdateWithMaximumQualityThenQualityDoesNotIncrease(): void
    {
        $currentItemName = self::AGED_BRIE_ITEM_NAME;
        $currentItemSellIn = -1;
        $currentItemQuality = 1;
        
        $expectedItemName = self::AGED_BRIE_ITEM_NAME;
        $expectedItemSellIn = -2;
        $expectedItemQuality = 3;

        $item = $this->whenUpdateItem(
            $currentItemName,
            $currentItemSellIn,
            $currentItemQuality,
        );
        
        $this->thenItemHasBeenUpdatedAsExpected(
            $item,
            $expectedItemName,
            $expectedItemSellIn,
            $expectedItemQuality
        );
    }

    private function whenUpdateItem(
        string $itemName,
        int $itemSellIn,
        int $itemQuality
    ): Item {
        $item = new Item($itemName, $itemSellIn, $itemQuality);
        $items = [$item];
        
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();

        return $item;
    }

    private function thenItemHasBeenUpdatedAsExpected(
        Item $item,
        string $expectedItemName,
        int $expectedItemSellIn,
        int $expectedItemQuality
    ): void {
        $this->assertSame($expectedItemName, $item->name);
        $this->assertSame($expectedItemSellIn, $item->sellIn);
        $this->assertSame($expectedItemQuality, $item->quality);
    }
}
