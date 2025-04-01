<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    private const MINIMUM_ITEM_QUALITY = 0;
    private const MAXIMUM_ITEM_QUALITY = 50;
    private const AGED_BRIE_ITEM_NAME = 'Aged Brie';
    private const SULFURAS_ITEM_NAME = 'Sulfuras, Hand of Ragnaros';
    private const BACKSTAGE_PASSES_ITEM_NAME = 'Backstage passes to a TAFKAL80ETC concert';

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
            $this->updateItem($item);
        }
    }

    private function updateItem(Item $item): void
    {
        if ($item->name != self::AGED_BRIE_ITEM_NAME and $item->name != self::BACKSTAGE_PASSES_ITEM_NAME) {
            if ($item->quality > self::MINIMUM_ITEM_QUALITY) {
                if ($item->name != self::SULFURAS_ITEM_NAME) {
                    $item->quality = $item->quality - 1;
                }
            }
        } else {
            if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                $this->increaseItemQuality($item);;
                if ($item->name == self::BACKSTAGE_PASSES_ITEM_NAME) {
                    if ($item->sellIn < 11) {
                        if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                            $this->increaseItemQuality($item);;
                        }
                    }
                    if ($item->sellIn < 6) {
                        if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                            $this->increaseItemQuality($item);;
                        }
                    }
                }
            }
        }

        if ($item->name != self::SULFURAS_ITEM_NAME) {
            $item->sellIn = $item->sellIn - 1;
        }

        if ($item->sellIn < 0) {
            if ($item->name != self::AGED_BRIE_ITEM_NAME) {
                if ($item->name != self::BACKSTAGE_PASSES_ITEM_NAME) {
                    if ($item->quality > self::MINIMUM_ITEM_QUALITY) {
                        if ($item->name != self::SULFURAS_ITEM_NAME) {
                            $item->quality = $item->quality - 1;
                        }
                    }
                } else {
                    $item->quality = self::MINIMUM_ITEM_QUALITY;
                }
            } else {
                if ($item->quality < self::MAXIMUM_ITEM_QUALITY) {
                    $this->increaseItemQuality($item);
                }
            }
        }
    }

    private function increaseItemQuality(Item $item): void
    {
        $item->quality = $item->quality + 1;
    }
}
