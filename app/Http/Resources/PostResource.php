<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'caption' => $this->caption,
            'user' => new ShowUserResource($this->user),
            'photo' => ImageResource::collection($this->image),
            'video' => VideoResource::collection($this->video),
            'created_at' => $this->created_at->format('M D Y, h:m:s a'),
            'likes' => LikeResource::collection($this->like),
            'comments' => CommentResource::collection($this->comment),
        ];
    }
}
