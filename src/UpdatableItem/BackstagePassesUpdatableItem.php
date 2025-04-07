<?php

declare(strict_types=1);

namespace GildedRose\UpdatableItem;

final class BackstagePassesUpdatableItem extends UpdatableItem
{
    private const MINIMUM_QUALITY = 0;

    protected function updateQuality(): void
    {
        if ($this->sellIn < 0) {
            $this->quality = self::MINIMUM_QUALITY;
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
}
