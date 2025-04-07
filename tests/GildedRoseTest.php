<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class GildedRoseTest extends TestCase
{
    private const STANDARD_ITEM_NAME = 'Standard';
    private const AGED_BRIE_ITEM_NAME = 'Aged Brie';
    private const SULFURAS_ITEM_NAME = 'Sulfuras, Hand of Ragnaros';
    private const BACKSTAGE_PASSES_ITEM_NAME = 'Backstage passes to a TAFKAL80ETC concert';
    private const CONJURED_ITEM_NAME = 'Conjured';
    private const MINIMUM_ITEM_QUALITY = 0;
    private const MAXIMUM_ITEM_QUALITY = 50;
    private const SULFURAS_ITEM_QUALITY = 80;

    #[DataProvider('itemDataProvider')]
    public function testUpdateItem(
        string $currentItemName,
        int $currentItemSellIn,
        int $currentItemQuality,
        string $expectedItemName,
        int $expectedItemSellIn,
        int $expectedItemQuality
    ): void {
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

    public static function itemDataProvider(): array
    {
        return [
            'standard item with quality greater than zero should both sellIn and quality decrease by one' => [
                'currentItemName' => self::STANDARD_ITEM_NAME,
                'currentItemSellIn' => 0,
                'currentItemQuality' => 1,
                'expectedItemName' => self::STANDARD_ITEM_NAME,
                'expectedItemSellIn' => -1,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'standard item with quality zero should sellIn decreases by one and quality remains zero' => [
                'currentItemName' => self::STANDARD_ITEM_NAME,
                'currentItemSellIn' => 0,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::STANDARD_ITEM_NAME,
                'expectedItemSellIn' => -1,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'standard item with the sellIn has passed should sellIn decreases by one and quality decreases twice' => [
                'currentItemName' => self::STANDARD_ITEM_NAME,
                'currentItemSellIn' => -1,
                'currentItemQuality' => 2,
                'expectedItemName' => self::STANDARD_ITEM_NAME,
                'expectedItemSellIn' => -2,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'standard item with sellIn has passed and quality is zero should sellIn decreases by one and quality remains zero' => [
                'currentItemName' => self::STANDARD_ITEM_NAME,
                'currentItemSellIn' => -1,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::STANDARD_ITEM_NAME,
                'expectedItemSellIn' => -2,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'agent brie item with quality one should sellIn decrease and quality increase one' => [
                'currentItemName' => self::AGED_BRIE_ITEM_NAME,
                'currentItemSellIn' => 1,
                'currentItemQuality' => 1,
                'expectedItemName' => self::AGED_BRIE_ITEM_NAME,
                'expectedItemSellIn' => 0,
                'expectedItemQuality' => 2
            ],
            'agent brie item with sellIn has passed should quality increase by two' => [
                'currentItemName' => self::AGED_BRIE_ITEM_NAME,
                'currentItemSellIn' => -1,
                'currentItemQuality' => 1,
                'expectedItemName' => self::AGED_BRIE_ITEM_NAME,
                'expectedItemSellIn' => -2,
                'expectedItemQuality' => 3
            ],
            'agent brie item with sellIn has passed should quality increase by two' => [
                'currentItemName' => self::AGED_BRIE_ITEM_NAME,
                'currentItemSellIn' => -1,
                'currentItemQuality' => 1,
                'expectedItemName' => self::AGED_BRIE_ITEM_NAME,
                'expectedItemSellIn' => -2,
                'expectedItemQuality' => 3
            ],
            'agent brie item with maximum quality should quality not increase' => [
                'currentItemName' => self::AGED_BRIE_ITEM_NAME,
                'currentItemSellIn' => 1,
                'currentItemQuality' => self::MAXIMUM_ITEM_QUALITY,
                'expectedItemName' => self::AGED_BRIE_ITEM_NAME,
                'expectedItemSellIn' => 0,
                'expectedItemQuality' => self::MAXIMUM_ITEM_QUALITY
            ],
            'sulfuras item with not sellIn has passed should not change' => [
                'currentItemName' => self::SULFURAS_ITEM_NAME,
                'currentItemSellIn' => 1,
                'currentItemQuality' => self::SULFURAS_ITEM_QUALITY,
                'expectedItemName' => self::SULFURAS_ITEM_NAME,
                'expectedItemSellIn' => 1,
                'expectedItemQuality' => self::SULFURAS_ITEM_QUALITY
            ],
            'sulfuras item with sellIn has passed should not change' => [
                'currentItemName' => self::SULFURAS_ITEM_NAME,
                'currentItemSellIn' => -1,
                'currentItemQuality' => self::SULFURAS_ITEM_QUALITY,
                'expectedItemName' => self::SULFURAS_ITEM_NAME,
                'expectedItemSellIn' => -1,
                'expectedItemQuality' => self::SULFURAS_ITEM_QUALITY
            ],
            'backstage passes item with sellIn more than ten days should quality increase by one' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 11,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => 10,
                'expectedItemQuality' => 1
            ],
            'backstage passes item with sellIn ten days should quality increase by two' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 10,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => 9,
                'expectedItemQuality' => 2
            ],
            'backstage passes item with sellIn less than ten days should quality increase by two' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 9,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => 8,
                'expectedItemQuality' => 2
            ],
            'backstage passes item with sellIn five days should quality increase by three' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 5,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => 4,
                'expectedItemQuality' => 3
            ],
            'backstage passes item with sellIn less than five days should quality increase by three' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 4,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => 3,
                'expectedItemQuality' => 3
            ],
            'backstage passes item with sellIn has passed should quality derease down to zero' => [
                'currentItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'currentItemSellIn' => 0,
                'currentItemQuality' => 30,
                'expectedItemName' => self::BACKSTAGE_PASSES_ITEM_NAME,
                'expectedItemSellIn' => -1,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'conjured item with sellIn has not passed should quality decrease 2' => [
                'currentItemName' => self::CONJURED_ITEM_NAME,
                'currentItemSellIn' => 1,
                'currentItemQuality' => 2,
                'expectedItemName' => self::CONJURED_ITEM_NAME,
                'expectedItemSellIn' => 0,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'conjured item with sellIn has passed should quality decrease 4' => [
                'currentItemName' => self::CONJURED_ITEM_NAME,
                'currentItemSellIn' => 0,
                'currentItemQuality' => 4,
                'expectedItemName' => self::CONJURED_ITEM_NAME,
                'expectedItemSellIn' => -1,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ],
            'conjured item with sellIn has not passed and minimum quality should quality not decrease' => [
                'currentItemName' => self::CONJURED_ITEM_NAME,
                'currentItemSellIn' => 1,
                'currentItemQuality' => self::MINIMUM_ITEM_QUALITY,
                'expectedItemName' => self::CONJURED_ITEM_NAME,
                'expectedItemSellIn' => 0,
                'expectedItemQuality' => self::MINIMUM_ITEM_QUALITY
            ]
        ];
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
