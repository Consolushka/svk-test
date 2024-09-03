<?php

declare(strict_types=1);

namespace App\Services\Booking\ExternalClients;

use App\Services\Booking\Entities\EventEntity;
use App\Services\Booking\Entities\PlaceEntity;
use App\Services\Booking\Entities\ReserveEntity;
use App\Services\Booking\Entities\ShowEntity;
use Illuminate\Support\Collection;

interface ExternalBookingClientInterface
{
    /**
     * @return Collection<ShowEntity>
     */
    public function getShows(): Collection;

    /**
     * @param int $showId
     * @return Collection<EventEntity>
     */
    public function getEventsByShow(int $showId): Collection;

    /**
     * @param int $eventId
     * @return Collection<PlaceEntity>
     */
    public function getPlacesByEvent(int $eventId): Collection;

    public function reservePlaces(int $eventId, string $userName, array $placesIds): ReserveEntity;
}