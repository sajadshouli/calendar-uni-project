<?php

namespace App\Http\Resources\Api\Task;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskItemsResource extends JsonResource
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
            'task_id'       => $this->task_id,
            'content'       => $this->content,
            'created_at'    => $this->created_at,
            'jcreated_at'   => $this->jcreated_at,
            'done_at'       => $this->done_at,
            'jdone_at'      => $this->jdone_at,
        ];
    }
}
