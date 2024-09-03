<?php

namespace App\Http\Resources\Place;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *    schema="PlaceResourceCollection",
 *    @OA\Property(
 *      property="response", type="array",
 *      @OA\Items(ref="#/components/schemas/PlaceResource"),
 *    ),
 * )
 */
class PlaceResourceCollection extends ResourceCollection
{
    public static $wrap = 'response';
}
