<?php

namespace App\Http\Resources\Event;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *    schema="EventResourceCollection",
 *    @OA\Property(
 *      property="response", type="array",
 *      @OA\Items(ref="#/components/schemas/EventResource"),
 *    ),
 * )
 */
class EventResourceCollection extends ResourceCollection
{
    public static $wrap = 'response';
}
