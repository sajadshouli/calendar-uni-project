<?php

namespace App\Http\Resources\Api\Task;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'info'          => $this->info,
            'created_at'    => $this->created_at,
            'jcreated_at'   => $this->jcreated_at,
        ];
    }
}
