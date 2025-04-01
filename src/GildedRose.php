<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const MINIMUM_ITEM_QUALITY = 0;
    private const MAXIMUM_ITEM_QUALITY = 50;

    /**
     * @param Item[] $items
     */
    public function __construct(
        private array $items
    ) {
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                if ($item->quality > self::MINIMUM_ITEM_QUALITY) {
                    if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                        $item->quality = $item->quality - 1;
                    }
                }
            } else {
                if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                    $item->quality = $item->quality + 1;
                    if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->sellIn < 11) {
                            if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                        if ($item->sellIn < 6) {
                            if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                                $item->quality = $item->quality + 1;
                            }
                        }
                    }
                }
            }

            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                $item->sellIn = $item->sellIn - 1;
            }

            if ($item->sellIn < 0) {
                if ($item->name != 'Aged Brie') {
                    if ($item->name != 'Backstage passes to a TAFKAL80ETC concert') {
                        if ($item->quality > self::MINIMUM_ITEM_QUALITY) {
                            if ($item->name != 'Sulfuras, Hand of Ragnaros') {
                                $item->quality = $item->quality - 1;
                            }
                        }
                    } else {
                        $item->quality = self::MINIMUM_ITEM_QUALITY;
                    }
                } else {
                    if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                        $item->quality = $item->quality + 1;
                    }
                }
            }
        }
    }
}
