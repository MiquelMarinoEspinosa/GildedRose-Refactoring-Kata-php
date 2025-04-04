<?php

declare(strict_types=1);

namespace GildedRose;

final class UpdatableItem
{
    private const MINIMUM_ITEM_QUALITY = 0;
    private const MAXIMUM_ITEM_QUALITY = 50;
    private const AGED_BRIE_ITEM_NAME = 'Aged Brie';
    private const SULFURAS_ITEM_NAME = 'Sulfuras, Hand of Ragnaros';
    private const BACKSTAGE_PASSES_ITEM_NAME = 'Backstage passes to a TAFKAL80ETC concert';

    public function __construct(
        public string $name,
        public int $sellIn,
        public int $quality
    ) {
    }

    public function updateItem(Item $item): void
    {
        $this->updateItemQuality($item);

        $this->decreaseSellIn($item);
    
        if ($this->sellIn >= 0) {
            return;
        }

        $this->updateItemQuality($item);      
    }

    private function updateItemQuality(Item $item): void
    {
        if (self::AGED_BRIE_ITEM_NAME === $this->name || self::BACKSTAGE_PASSES_ITEM_NAME === $this->name) {
            $this->increaseItemQuality($item);
        } else {
            $this->decreaseItemQuality($item);
        }
    }


    private function increaseItemQuality(Item $item): void
    {
        if (self::BACKSTAGE_PASSES_ITEM_NAME === $this->name && $this->sellIn < 0) {
            $this->quality = self::MINIMUM_ITEM_QUALITY;
            return;
        }

        if ($this->quality >= self::MAXIMUM_ITEM_QUALITY) {
            return;
        }

        $this->quality = $this->quality + 1;
        
        if($this->name !== self::BACKSTAGE_PASSES_ITEM_NAME) {
            return;
        }
        
        if ($this->sellIn >= 11) {
            return;
        }

        $this->quality = $this->quality + 1;

        if ($this->sellIn >= 6) {
            return;
        }
        
        $this->quality = $this->quality + 1;
    }

    private function decreaseItemQuality(Item $item): void
    {
        if ($this->quality <= self::MINIMUM_ITEM_QUALITY) {
            return;
        }

        if (self::SULFURAS_ITEM_NAME === $this->name) {
            return;
        }
        
        $this->quality = $this->quality - 1;
    }

    private function decreaseSellIn(Item $item): void
    {
        if (self::SULFURAS_ITEM_NAME === $this->name) {
            return;
        }
        
        $this->sellIn = $this->sellIn - 1;
    }
}
