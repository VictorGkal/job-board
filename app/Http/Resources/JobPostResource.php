<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'location'    => $this->location,
            'type'        => $this->type,
            'salary_min'  => $this->salary_min,
            'salary_max'  => $this->salary_max,
            'status'      => $this->status,
            'posted_at'   => $this->created_at->diffForHumans(),
            'category'    => $this->category->name,
            'employer'    => new UserResource($this->employer),
        ];
    }
}