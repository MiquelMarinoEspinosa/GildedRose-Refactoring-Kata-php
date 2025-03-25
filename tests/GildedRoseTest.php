<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    private const STANDARD_ITEM_NAME = 'standard';
    private const MINIMUM_QUALITY = 0;

    public function testGivenStandardItemWhenQualityIsGreaterThanZeroThenBothSellAndQualityDecreaseOne(): void
    {
        $item = $this->buildStandardItem(0, 1);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(self::STANDARD_ITEM_NAME, $item->name);
        $this->assertSame(-1, $item->sellIn);
        $this->assertSame(self::MINIMUM_QUALITY, $item->quality);
    }
    
    public function testGivenStandardItemWhenQualityIsZeroThenSellInDecreasesOneAndQualityReamainsZero(): void
    {
        $item = $this->buildStandardItem(0, self::MINIMUM_QUALITY);
        $items = [$item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame(self::STANDARD_ITEM_NAME, $item->name);
        $this->assertSame(-1, $item->sellIn);
        $this->assertSame(self::MINIMUM_QUALITY, $item->quality);
    }

    private function buildStandardItem(
        int $sellIn,
        int $quality
    ): Item {
        return new Item(
            self::STANDARD_ITEM_NAME,
            $sellIn,
            $quality
        );
    }
}
