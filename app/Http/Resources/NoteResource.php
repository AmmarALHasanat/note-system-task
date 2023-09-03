<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;
use App\Models\Note;
use Shamaseen\Repository\Utility\Resource as JsonResource;

/**
 * Class NoteResource.
 * @mixin Note
 */
class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable<string, mixed>|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'discrption'=>$this->discrption,
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
