<?php

declare(strict_types=1);

namespace GildedRose;

interface InterfaceGildedRoseItem
{
    public function __toString(): string;

    public function increaseQuality(): void;

    public function decreaseQuality(): void;

    public function decreaseSellInDate(): void;

    public function getName(): string;

    public function getQuality(): int;

    public function getSellIn(): int;
}
