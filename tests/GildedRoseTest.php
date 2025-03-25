<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testGivenStandardItemWhenQualityIsGreaterThanZeroThenBothSellAndQualityDecreaseOne(): void
    {
        $items = [new Item('standard', 0, 1)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('standard', $items[0]->name);
        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
    }
    
    public function testGivenStandardItemWhenQualityIsZeroThenSellInDecreasesOneAndQualityReamainsZero(): void
    {
        $items = [new Item('standard', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('standard', $items[0]->name);
        $this->assertSame(-1, $items[0]->sellIn);
        $this->assertSame(0, $items[0]->quality);
    }
}
