<?php

namespace App\Http\Resources\Api;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use ResourceTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'mobile'        => $this->mobile,
            'token'         => $this->when(filled($this->accessToken), $this->accessToken)
        ];
    }
}
