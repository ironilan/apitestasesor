<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function detallepedidos()
    {
        return $this->hasMany(Detallepedido::class);
    }


    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
