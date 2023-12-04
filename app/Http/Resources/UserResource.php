<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'users',
                'id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                ]
            ],
            'links' => [
                'self' => url('/users/' . $this->id)
            ]
        ];
    }
}
