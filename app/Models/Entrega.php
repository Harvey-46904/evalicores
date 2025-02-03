<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;


class Entrega extends Model
{
    public function scopeUserEntrega($query)
    {
        $usuario = Auth::user();
       
        // Verificar si el usuario no es administrador
        if ($usuario->role_id !== 4) {
            return $query->where('domiciliario_id', $usuario->id)->where('estado',"<>","entregado");
        }
        
        return $query->where('estado',"<>","entregado");
    }
}
