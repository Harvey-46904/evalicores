<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Factura extends Model
{
    protected $fillable = ['id_venta_items', 'created_at', 'updated_at'];
}
