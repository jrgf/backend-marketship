<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Producto;
use App\Models\ProductPedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $pedido = new Pedido;
        $pedidos = Pedido::with('productos')->where('user_id',$id)->where('completado',0)->get();
        return ['pedidos'=>$pedidos];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = new Pedido;
      
        $pedido->user_id = Auth::user()->id;
        $pedido->client_name  = $request->client_name;
        $pedido->total = $request->total;
        $pedido->telephone  =$request->telephone;
        $pedido->estacion = $request->estacion;
        $pedido->save();
        $id = $pedido->id;
        $productos = $request->productos;
        $pedido_producto = [];
        foreach($productos as $producto){
            $pedido_producto[]=[
                'pedido_id' => $id,
                'producto_id'=> $producto['id'],
                'cantidad'=> $producto['cantidad'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ];
        }
        ProductPedido::insert($pedido_producto);

        return ['pedido'=>$pedido,'productos'=>$request->productos];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
        $pedido->completado = 1;
        $producto_pedido = ProductPedido::where('pedido_id',$pedido->id)->get();
        
        foreach ($producto_pedido as $pivote) {
            $producto = Producto::where('id',$pivote->producto_id)->first();
            if($producto->stock > 0){
                $producto->stock = $producto->stock - $pivote->cantidad;
                $producto->save();
            }
        }
        $pedido->save();
        return ['pedido'=>$pedido];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
