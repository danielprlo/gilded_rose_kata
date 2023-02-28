<?php

declare(strict_types=1);

namespace GildedRose;

class StandardGildedRoseItem extends AbstractGildedRoseItem
{

    public function increaseQuality(): void
    {
    }

    public function decreaseQuality(): void
    {
        if ($this->quality > 0) {
            $this->quality -= 1;
        }
    }

    public function decreaseSellInDate(): void
    {
        $this->sellIn -= 1;
    }
}
