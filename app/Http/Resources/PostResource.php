<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="PostResource")
 * {
 *
 *   @OA\Property(
 *       property="id",
 *       type="integer",
 *       description="The user id"
 *    ),
 *   @OA\Property(
 *       property="name",
 *       type="string",
 *       description="The post resource name"
 *    ),
 *    @OA\Property(
 *        property="content",
 *        type="string",
 *        description="The post resource content"
 *    ),
 *   @OA\Property(
 *       property="created_at",
 *       type="string",
 *       description="The resource created date."
 *    ),
 * }
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            $this->mergeWhen($this->relationLoaded('user'), [
                'author' => new UserResource($this->user),
            ]),
            'slug' => $this->slug,
        ];
    }
}
