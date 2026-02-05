<?php
namespace ActivityLog\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'model'     => $this->model,
            'action'    => $this->action,
            'model_id'  => $this->model_id,
            'ip'        => $this->ip_address,
            'agent'     => $this->user_agent,
            'changes'   => $this->changes,
            'meta'      => $this->meta,
            'created_at'=> $this->created_at->toDateTimeString(),
        ];
    }
}
