<?php

namespace Tests\Feature;

use App\Services\Booking\Entities\EventEntity;
use App\Services\Booking\Entities\PlaceEntity;
use App\Services\Booking\Entities\ReserveEntity;
use App\Services\Booking\Entities\ShowEntity;
use App\Services\Booking\ExternalClients\ExternalBookingClientInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class BookingAPITest extends TestCase
{
    public function test_it_returns_shows_list(): void
    {
        $expectedCollection = Collection::make([
            new ShowEntity(id: 1, name: 'Show #1'),
            new ShowEntity(id: 2, name: 'Show #2'),
            new ShowEntity(id: 3, name: 'Show #3'),
        ]);
        $expectedJson = [
            'response' => [
                [
                    'id'   => 1,
                    'name' => 'Show #1',
                ],
                [
                    'id'   => 2,
                    'name' => 'Show #2',
                ],
                [
                    'id'   => 3,
                    'name' => 'Show #3',
                ],
            ]
        ];

        $mock = $this->createClientMock();

        $mock->shouldReceive('getShows')->once()->andReturn($expectedCollection);

        $response = $this->getJson(route('shows.index'));

        $response->assertJson($expectedJson);
    }

    public function test_it_returns_list_of_show_events(): void
    {
        $expectedCollection = Collection::make([
            new EventEntity(id: 1, showId: 1, dateTime: Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-01 12:00:00')),
            new EventEntity(id: 2, showId: 1, dateTime: Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-02 12:00:00')),
            new EventEntity(id: 3, showId: 1, dateTime: Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-03 12:00:00')),
        ]);
        $expectedJson = [
            'response' => [
                [
                    'id'       => 1,
                    'showId'   => '1',
                    'dateTime' => '2023-01-01 12:00:00',
                ],
                [
                    'id'       => 2,
                    'showId'   => '1',
                    'dateTime' => '2023-01-02 12:00:00',
                ],
                [
                    'id'       => 3,
                    'showId'   => '1',
                    'dateTime' => '2023-01-03 12:00:00',
                ],
            ]
        ];

        $mock = $this->createClientMock();

        $mock->shouldReceive('getEventsByShow')->once()->andReturn($expectedCollection);

        $response = $this->getJson(route('shows.events', ['showId' => 1]));

        $response->assertJson($expectedJson);
    }

    public function test_it_returns_list_of_event_places(): void
    {
        $expectedCollection = Collection::make([
            new PlaceEntity(id: 1, x: 1, y: 1, width: 1, height: 1, isAvailable: true),
            new PlaceEntity(id: 2, x: 2, y: 2, width: 2, height: 2, isAvailable: false),
            new PlaceEntity(id: 3, x: 3, y: 3, width: 3, height: 3, isAvailable: true),
        ]);
        $expectedJson = [
            'response' => [
                [
                    'id'          => 1,
                    'x'           => 1,
                    'y'           => 1,
                    'width'       => 1,
                    'height'      => 1,
                    'isAvailable' => true,
                ],
                [
                    'id'          => 2,
                    'x'           => 2,
                    'y'           => 2,
                    'width'       => 2,
                    'height'      => 2,
                    'isAvailable' => false,
                ],
                [
                    'id'          => 3,
                    'x'           => 3,
                    'y'           => 3,
                    'width'       => 3,
                    'height'      => 3,
                    'isAvailable' => true,
                ],
            ]
        ];

        $mock = $this->createClientMock();

        $mock->shouldReceive('getPlacesByEvent')->once()->andReturn($expectedCollection);

        $response = $this->getJson(route('events.places', ['eventId' => 1]));

        $response->assertJson($expectedJson);
    }

    public function test_it_returns_reservation(): void
    {
        $expectedEntity = new ReserveEntity(success: true, reservationId: '66d2f3e0700e5');
        $expectedJson = [
            'response' => [
                'success'       => true,
                'reservationId' => '66d2f3e0700e5',
            ]
        ];

        $mock = $this->createClientMock();

        $mock->shouldReceive('reservePlaces')->once()->andReturn($expectedEntity);

        $response = $this->postJson(route('events.reserve', ['eventId' => 1]), [
            'name'   => 'John Doe',
            'places' => [1, 2, 3, 4]
        ]);

        $response->assertJson($expectedJson);
    }


    private function createClientMock(): MockInterface
    {
        return $this->mock(ExternalBookingClientInterface::class);
    }
}
