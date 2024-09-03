<?php

namespace App\Services\Booking\Entities;

use Carbon\Carbon;

final class EventEntity
{

    public function __construct(
        public int    $id,
        public int $showId,
        public Carbon $dateTime
    )
    {
    }
}