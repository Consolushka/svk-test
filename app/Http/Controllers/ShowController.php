<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;
use App\Http\Resources\Event\EventResourceCollection;
use App\Http\Resources\Show\ShowResourceCollection;
use App\Services\Booking\ExternalClients\ExternalBookingClientInterface;

class ShowController extends Controller
{
    /**
     * shows.index
     *
     * @OA\Get (
     *     path="/api/shows",
     *     tags={"Shows"},
     *     @OA\Response(
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent(
     *              ref="#/components/schemas/ShowResourceCollection"
     *           )
     *     )
     * )
     */
    public function index(ExternalBookingClientInterface $client): ShowResourceCollection
    {
        return new ShowResourceCollection($client->getShows());
    }

    /**
     * shows.events
     *
     * @OA\Get(
     *     path="/api/shows/{showId}/events",
     *     tags={"Shows"},
     *     @OA\Parameter(
     *         name="showId",
     *         in="path",
     *         description="Show id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *            response=200,
     *            description="Success",
     *            @OA\JsonContent(
     *               ref="#/components/schemas/EventResourceCollection"
     *            )
     *      )
     * )
    */
    public function eventsByShow(int $showId, ExternalBookingClientInterface $client): EventResourceCollection
    {
        return new EventResourceCollection($client->getEventsByShow($showId));
    }
}
