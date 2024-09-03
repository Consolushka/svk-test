<?php

namespace App\Http\Resources\Event;

use App\Services\Booking\Entities\EventEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @property EventEntity $resource
 *
 *
 * @OA\Schema(
 *     schema="EventResource",
 *     description="Event API resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="showId", type="integer", example=1),
 *     @OA\Property(property="dateTime", type="string", example="2023-01-01 00:00:00"),
 * )
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->resource->id,
            'showId'   => $this->resource->showId,
            'dateTime' => $this->resource->dateTime->format('Y-m-d H:i:s'),
        ];
    }
}
