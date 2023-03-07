<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'telephone',
        'estacion',
        'total',
        'completado',
        'user_id'

    ];
    public function user(){
        $this->belongsTo(User::class);
    }
    public function productos(){
       return  $this->belongsToMany(Producto::class,'product_pedidos')->withPivot('cantidad');
    }
}
