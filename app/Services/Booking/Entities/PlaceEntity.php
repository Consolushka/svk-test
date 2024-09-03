<?php

namespace App\Services\Booking\Entities;

use Spatie\LaravelData\Data;

final class PlaceEntity extends Data
{
    public function __construct(
        public int   $id,
        public float $x,
        public float $y,
        public float $width,
        public float $height,
        public bool  $isAvailable
    )
    {
    }
}