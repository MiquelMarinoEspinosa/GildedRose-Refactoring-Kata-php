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
            $this->decreaseItemQuality($item);
        } else {
            $this->increaseItemQuality($item);
            $this->increaseBackstagePassesQuality($item);  
        }

        $this->decreaseSellIn($item);
    
        if ($item->sellIn < 0) {
            if ($item->name != self::AGED_BRIE_ITEM_NAME) {
                if ($item->name != self::BACKSTAGE_PASSES_ITEM_NAME) {
                    $this->decreaseItemQuality($item);
                } else {
                    $item->quality = self::MINIMUM_ITEM_QUALITY;
                }
            } else {
                $this->increaseItemQuality($item);
            }
        }
    }

    private function increaseItemQuality(Item $item): void
    {
        if ($item->quality >= self::MAXIMUM_ITEM_QUALITY) {
            return;
        }

        $item->quality = $item->quality + 1;        
    }

    private function decreaseItemQuality(Item $item): void
    {
        if ($item->quality > self::MINIMUM_ITEM_QUALITY) {
            if ($item->name != self::SULFURAS_ITEM_NAME) {
                $item->quality = $item->quality - 1;
            }
        }
    }

    private function decreaseSellIn(Item $item): void
    {
        if (self::SULFURAS_ITEM_NAME === $item->name) {
            return;
        }
        
        $item->sellIn = $item->sellIn - 1;
    }

    private function increaseBackstagePassesQuality(Item $item): void
    {
        if ($item->name == self::BACKSTAGE_PASSES_ITEM_NAME) {
            if ($item->sellIn < 11) {
                $this->increaseItemQuality($item);
            }
            if ($item->sellIn < 6) {
                $this->increaseItemQuality($item);
            }
        }
    }
}
