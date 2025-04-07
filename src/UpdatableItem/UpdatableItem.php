<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

class UpdatableItem
{
    private const MINIMUM_ITEM_QUALITY = 0;
    private const AGED_BRIE_ITEM_NAME = 'Aged Brie';
    private const SULFURAS_ITEM_NAME = 'Sulfuras, Hand of Ragnaros';
    private const BACKSTAGE_PASSES_ITEM_NAME = 'Backstage passes to a TAFKAL80ETC concert';

    protected function __construct(
        public string $name,
        public int $sellIn,
        public int $quality
    ) {
    }

    public static function create(
        string $name,
        int $sellIn,
        int $quality
    ): self {
        if (self::SULFURAS_ITEM_NAME === $name) {
            return new SulfurasUpdatableItem(
                $name,
                $sellIn,
                $quality
            );
        }

        if (self::AGED_BRIE_ITEM_NAME === $name) {
            return new AgedBrieUpdatableItem(
                $name,
                $sellIn,
                $quality
            );
        }

        return new self(
            $name,
            $sellIn,
            $quality
        );
    }

    public function update(): self
    {
        $this->updateQuality();

        $this->decreaseSellIn();
    
        if ($this->sellIn >= 0) {
            return $this;
        }

        $this->updateQuality();
        
        return $this;
    }

    protected function updateQuality(): void
    {
        if (self::AGED_BRIE_ITEM_NAME === $this->name || self::BACKSTAGE_PASSES_ITEM_NAME === $this->name) {
            $this->increaseQuality();
        } else {
            $this->decreaseQuality();
        }
    }


    private function increaseQuality(): void
    {
        if (self::BACKSTAGE_PASSES_ITEM_NAME === $this->name && $this->sellIn < 0) {
            $this->quality = self::MINIMUM_ITEM_QUALITY;
            return;
        }

        $this->quality = $this->quality + 1;
        
        if ($this->sellIn >= 11) {
            return;
        }

        $this->quality = $this->quality + 1;

        if ($this->sellIn >= 6) {
            return;
        }
        
        $this->quality = $this->quality + 1;
    }

    private function decreaseQuality(): void
    {
        if ($this->quality <= self::MINIMUM_ITEM_QUALITY) {
            return;
        }
        
        $this->quality = $this->quality - 1;
    }

    protected function decreaseSellIn(): void
    {
        $this->sellIn = $this->sellIn - 1;
    }
}
