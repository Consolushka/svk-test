<?php

namespace App\Http\Resources\Show;

use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *    schema="ShowResourceCollection",
 *    @OA\Property(
 *      property="response", type="array",
 *      @OA\Items(ref="#/components/schemas/ShowResource"),
 *    ),
 * )
 */
class ShowResourceCollection extends ResourceCollection
{
    public static $wrap = 'response';
}
