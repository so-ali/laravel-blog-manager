<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User as UserModel;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    =>  $this->id,
            'user' => User::collection(UserModel::query()->find($this->user_id)->get())->toArray($request)[0],
            'slug' => $this->slug,
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
            'excerpt' => $this->excerpt,
        ];
    }
}
