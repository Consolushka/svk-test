<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservePlacesRequest;
use App\Http\Resources\Place\PlaceResourceCollection;
use App\Services\Booking\ExternalClients\ExternalBookingClientInterface;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

class EventController extends Controller
{

    /**
     * events.places
     *
     * @OA\Get(
     *     path="/api/events/{eventId}/places",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="eventId",
     *         in="path",
     *         description="Event id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *           response=200,
     *           description="Success",
     *           @OA\JsonContent(
     *                ref="#/components/schemas/PlaceResourceCollection"
     *             )
     *      )
     * )
     */
    public function getEventPlaces(int $eventId, ExternalBookingClientInterface $client): PlaceResourceCollection
    {
        return new PlaceResourceCollection($client->getPlacesByEvent($eventId));
    }

    /**
     * events.reserve
     *
     * @OA\Post(
     *     path="/api/events/{eventId}/reserve",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="eventId",
     *         in="path",
     *         description="Event id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="places", type="array",
     *                 @OA\Items(type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *                 @OA\Property(property="response", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="success", type="boolean", example=true),
     *                         @OA\Property(property="reservationId", type="string", example="5d519fe58e3cf"),
     *                     ),
     *                 ),
     *         ),
     *     )
     * )
     */
    public function reserve(int $eventId, ReservePlacesRequest $request, ExternalBookingClientInterface $client): JsonResponse
    {
        $entity = $client->reservePlaces($eventId, $request->getUserName(), $request->getPlacesIds());

        return response()->json(
            [
                'response' => [
                    'success'       => $entity->success,
                    'reservationId' => $entity->reservationId,
                ]
            ]
        );
    }
}
