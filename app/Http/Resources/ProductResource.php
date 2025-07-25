<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'producto_id' => $this->id,
            'nombre' => $this->nombre,
            'disponibles' => $this->disponibles,
        ];
    }
}
