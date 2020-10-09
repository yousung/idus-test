<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender ?? null,
            'last_order' => collect($this->orders)->last(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
