<?php

namespace App\Http\Resources;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => new ShowUserResource($this->user),
            'emoji' => new ShowEmojiResource($this->emoji),
        ];
    }

}
