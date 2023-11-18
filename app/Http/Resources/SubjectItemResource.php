<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "deleted_at" => $this->deleted_at,

            "title" => $this->title,
            "description" => $this->description,
            "subject_id" => $this->subject_id,
            "star" => $this->star,
            "price" => $this->price,
            "rating" => $this->rating,

            "subject" => new SubjectResource($this->whenLoaded('subject')),

            "created_by" => new UserResource($this->whenLoaded('createdBy')),
            "updated_by" => new UserResource($this->whenLoaded('updatedBy')),
            "deleted_by" => new UserResource($this->whenLoaded('deletedBy')),
         ];
    }

}
