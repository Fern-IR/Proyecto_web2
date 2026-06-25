<?php

namespace App\Support;

class TravelImages
{
    public static function resolve(?string $destino, ?string $url = null): string
    {
        if ($destino) {
            $mapped = config("travel.imagenes_destino.{$destino}");
            if ($mapped) {
                return $mapped;
            }
        }

        return $url ?: config('travel.imagen_default');
    }
}
