<?php

namespace App\Services\Booking\Entities;

use Spatie\LaravelData\Data;

final class ReserveEntity extends Data
{
    public function __construct(public bool $success, public string $reservationId)
    {

    }
}