<?php

declare(strict_types=1);

namespace App\Services\Booking\ExternalClients;

use App\Services\Booking\Entities\EventEntity;
use App\Services\Booking\Entities\PlaceEntity;
use App\Services\Booking\Entities\ReserveEntity;
use App\Services\Booking\Entities\ShowEntity;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final readonly class LeadBookAPIClient implements ExternalBookingClientInterface
{
    public function __construct(private string $url, private string $token)
    {
    }

    /**
     * @throws ConnectionException
     */
    public function getShows(): Collection
    {
        $response = $this->buildPendingRequest()->get($this->buildUrl('shows'));

        $data = $response->json('response');

        return Collection::make(
            array_map(fn($item) => new ShowEntity(
                id: $item['id'],
                name: $item['name']
            ), $data)
        );
    }

    /**
     * @throws ConnectionException
     */
    public function getEventsByShow(int $showId): Collection
    {
        $response = $this->buildPendingRequest()->get($this->buildUrl('shows/' . $showId . '/events'));

        $data = $response->json('response');

        return Collection::make(
            array_map(fn($item) => new EventEntity(
                id: $item['id'],
                showId: $item['showId'],
                dateTime: Carbon::createFromFormat('Y-m-d H:i:s', $item['date'])
            ), $data)
        );
    }

    /**
     * @throws ConnectionException
     */
    public function getPlacesByEvent(int $eventId): Collection
    {
        $response = $this->buildPendingRequest()->get($this->buildUrl('events/' . $eventId . '/places'));

        $data = $response->json('response');

        return Collection::make(
            array_map(fn($item) => new PlaceEntity(
                id: $item['id'],
                x: $item['x'],
                y: $item['y'],
                width: $item['width'],
                height: $item['height'],
                isAvailable: $item['is_available']
            ), $data)
        );
    }

    /**
     * @throws ConnectionException
     */
    public function reservePlaces(int $eventId, string $userName, array $placesIds): ReserveEntity
    {
        $response = $this->buildPendingRequest()->asMultipart()->post($this->buildUrl('events/' . $eventId . '/reserve'), [
            'name'   => $userName,
            'places' => json_encode($placesIds),
        ]);

        $data = $response->json('response');

        return new ReserveEntity(success: $data['success'], reservationId: $data['reservation_id']);
    }

    private function buildUrl(string $endpoint): string
    {
        return $this->url . $endpoint;
    }

    private function buildPendingRequest(): PendingRequest
    {
        return Http::withToken($this->token);
    }
}