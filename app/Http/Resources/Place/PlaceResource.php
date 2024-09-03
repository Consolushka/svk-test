<?php

namespace App\Http\Resources\Place;

use App\Services\Booking\Entities\PlaceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property PlaceEntity $resource
 *
 * @OA\Schema(
 *     schema="PlaceResource",
 *     description="Event API resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="x", type="integer", example=0),
 *     @OA\Property(property="y", type="integer", example=60),
 *     @OA\Property(property="width", type="integer", example=20),
 *     @OA\Property(property="height", type="integer", example=20),
 *     @OA\Property(property="isAvailable", type="boolean", example=true),
 * )
 */
class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->resource->id,
            'x'           => $this->resource->x,
            'y'           => $this->resource->y,
            'width'       => $this->resource->width,
            'height'      => $this->resource->height,
            'isAvailable' => $this->resource->isAvailable,
        ];
    }
}
