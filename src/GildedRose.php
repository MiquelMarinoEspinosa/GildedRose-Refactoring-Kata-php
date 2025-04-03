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
        if (self::AGED_BRIE_ITEM_NAME === $item->name || self::BACKSTAGE_PASSES_ITEM_NAME === $item->name) {
            $this->increaseItemQuality($item);
        } else {
            $this->decreaseItemQuality($item);
        }

        $this->decreaseSellIn($item);
    
        if ($item->sellIn >= 0) {
            return;
        }

        if (self::AGED_BRIE_ITEM_NAME === $item->name || self::BACKSTAGE_PASSES_ITEM_NAME === $item->name) {
            $this->increaseItemQuality($item);
        } else {
            $this->decreaseItemQuality($item);
        }       
    }

    private function increaseItemQuality(Item $item): void
    {
        if (self::BACKSTAGE_PASSES_ITEM_NAME === $item->name && $item->sellIn < 0) {
            $item->quality = self::MINIMUM_ITEM_QUALITY;
            return;
        }

        if ($item->quality >= self::MAXIMUM_ITEM_QUALITY) {
            return;
        }

        $item->quality = $item->quality + 1;
        
        if($item->name !== self::BACKSTAGE_PASSES_ITEM_NAME) {
            return;
        }
        
        if ($item->sellIn >= 11) {
            return;
        }

        $item->quality = $item->quality + 1;

        if ($item->sellIn >= 6) {
            return;
        }
        
        $item->quality = $item->quality + 1;
    }

    private function decreaseItemQuality(Item $item): void
    {
        if ($item->quality <= self::MINIMUM_ITEM_QUALITY) {
            return;
        }

        if (self::SULFURAS_ITEM_NAME === $item->name) {
            return;
        }
        
        $item->quality = $item->quality - 1;
    }

    private function decreaseSellIn(Item $item): void
    {
        if (self::SULFURAS_ITEM_NAME === $item->name) {
            return;
        }
        
        $item->sellIn = $item->sellIn - 1;
    }
}
