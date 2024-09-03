<?php

namespace App\Http\Resources\Show;

use App\Services\Booking\Entities\ShowEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property ShowEntity $resource
 *
 * @OA\Schema(
 *     schema="ShowResource",
 *     description="Show API resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Show 1"),
 * )
 */
class ShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
