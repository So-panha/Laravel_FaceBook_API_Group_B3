<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'birthday' =>$this->birthday,
            'place'=>$this->place,
            'bio'=>$this->bio,
            'avatar_url'=>$this->avatar
        ];
    }
}
