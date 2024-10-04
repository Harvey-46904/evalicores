<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VentasItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'precio',
        'informacion_cliente',
        'lista_productos',
        'tipo_orden',
        'medio_pago',
        'accion',
    ];
}
