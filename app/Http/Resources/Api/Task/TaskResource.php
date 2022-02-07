<?php

namespace App\Http\Resources\Api\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
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
            'expectation'   => $this->expectation,
            'desire'        => $this->desire,
            'items'         => new TaskItemsCollection($this->items),
            'created_at'    => $this->created_at,
            'jcreated_at'   => $this->jcreated_at,
        ];
    }
}
