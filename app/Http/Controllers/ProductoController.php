<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Http\Resources\ProductoCollection;
use App\Models\Producto;
use Faker\Provider\Image;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function index(){
        return new ProductoCollection(Producto::where('disponible',1)->get());
    }

    public function store(ProductoRequest $request){
       
        $data = $request->validated();
        
       
            //Guardar imagen en el server
            $file=$data['imagen'];
            $filename = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path('/img'),$filename);
        $producto = new Producto;
        $producto->nombre = $data['nombre'];
        $producto->precio = $data['precio'];
        $producto->imagen = $filename;
        $producto->stock = $data['stock'];
        $producto->save();
       return ['producto'=>$producto];


    }
    public function update(Request $request,Producto $producto){
            $producto->nombre = $request->nombre;
            $producto->precio =$request->precio;
            $producto->stock = $request->stock;
            $producto->save();
            return ['producto'=>$producto];
    }
    public function destroy($id){
        $producto = Producto::where('id',$id)->get();
        unlink(public_path('/img/').$producto[0]->imagen);
        Producto::where('id',$id)->delete();
        return 'Deleted successfully';
    }
}
