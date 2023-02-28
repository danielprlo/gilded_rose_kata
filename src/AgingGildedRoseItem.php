<?php

declare(strict_types=1);

namespace GildedRose;

class AgingGildedRoseItem extends AbstractGildedRoseItem
{
    public function increaseQuality(): void
    {
        ++$this->quality;
    }

    public function decreaseQuality(): void
    {
    }

    public function decreaseSellInDate(): void
    {
        --$this->sellIn;
    }
}
