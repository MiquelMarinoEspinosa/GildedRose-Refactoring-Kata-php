<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

class UpdatableItem
{
    private const MINIMUM_QUALITY = 0;
    private const AGED_BRIE_NAME = 'Aged Brie';
    private const SULFURAS_NAME = 'Sulfuras, Hand of Ragnaros';
    private const BACKSTAGE_PASSES_NAME = 'Backstage passes to a TAFKAL80ETC concert';

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
        return match ($name) {
            self::SULFURAS_NAME => new SulfurasUpdatableItem(
                $name,
                $sellIn,
                $quality
            ),
            self::AGED_BRIE_NAME => new AgedBrieUpdatableItem(
                $name,
                $sellIn,
                $quality
            ),
            self::BACKSTAGE_PASSES_NAME => new BackstagePassesUpdatableItem(
                $name,
                $sellIn,
                $quality
            ),
            default => new self(
                $name,
                $sellIn,
                $quality
            )
        };
    }

    public function update(): self
    {
        $this->updateQuality();

        $this->decreaseSellIn();
    
        if ($this->hasPassed()) {
            return $this;
        }

        $this->updateQuality();
        
        return $this;
    }

    protected function updateQuality(): void
    {
        if ($this->quality <= self::MINIMUM_QUALITY) {
            return;
        }
        
        $this->quality = $this->quality - 1; 
    }

    protected function decreaseSellIn(): void
    {
        $this->sellIn = $this->sellIn - 1;
    }

    private function hasPassed(): bool
    {
        return $this->sellIn >= 0;
    }
}
