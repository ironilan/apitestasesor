<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function asesors()
    {
       //return $this->belongsToMany(RelatedModel, pivot_table_name, foreign_key_of_current_model_in_pivot_table, foreign_key_of_other_model_in_pivot_table);
        return $this->belongsToMany(
            Asesor::class,
            'asesor_cliente',
            'asesor_id',
            'cliente_id');
    }


    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
