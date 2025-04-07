<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
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
            $updatableItem = new StandardUpdatableItem(
                $item->name,
                $item->sellIn,
                $item->quality
            );
            $updatableItem = $updatableItem->update();

            $item->quality = $updatableItem->quality;
            $item->sellIn = $updatableItem->sellIn;
        }
    }
}
