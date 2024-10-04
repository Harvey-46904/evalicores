<?php

namespace App\Http\Controllers;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use DB;
use App\Models\Ventasitem;
use Illuminate\Support\Facades\Crypt;
class WebPageController extends Controller
{
    public function index(){

        $productos = DB::table('categorias')
        ->join('productos', 'categorias.id', '=', 'productos.categoria_id')
        ->select('categorias.id as categoria_id', 'categorias.nombre as categoria_nombre', 'productos.id as producto_id', 'productos.nombre as producto_nombre','productos.precio','productos.image')
        ->get()
        ->groupBy('categoria_id');
       
// Transformar cada producto dentro de cada grupo
$productos = $productos->map(function ($productosPorCategoria) {
    return $productosPorCategoria->map(function ($producto) {
        // Agrega la URL completa de la imagen
        $producto->image_url = Voyager::image($producto->image);
        return $producto;
    });
});
        
   //return response(["data"=>$productos]);
        return view('Page.index',compact('productos'));
    }


    public function orden($code_orden){

        $decryptedData = Crypt::decrypt($code_orden);

        $informacion=DB::table("ventas_items")
        ->select("informacion_cliente",'id')
        ->where('id',"=",$decryptedData)
        ->first();

        $informacion->informacion_cliente=json_decode( $informacion->informacion_cliente);
        //return response(["data"=>$informacion]);

        $msjwpp=self::enviar_wasap($informacion->informacion_cliente->Nombres_completos,$decryptedData);
        return view('Page.checkout',compact("informacion",'msjwpp'));
    }

    public function crear_orden(Request $request){
       
        $informacionClienteJson = json_encode($request->informacion_cliente);
        $informacionProductoJson = json_encode($request->lista_productos);


       $orden= DB::table('ventas_items')->insertGetId([
            'precio' =>$request->precio,
            'informacion_cliente' => $informacionClienteJson,
            'lista_productos' => $informacionProductoJson,
            'tipo_orden' => $request->tipo_orden,
            'medio_pago' => $request->medio_pago,
            'created_at' => now(), // Añade timestamps si es necesario
            'updated_at' => now(),
        ]);
        $encryptedData = Crypt::encrypt($orden);
        // Retornar respuesta
        return response()->json([
            'message' => 'Orden creada con éxito',
            'code_orden'=>$encryptedData
        ], 201);
    }

    //generar mensaje wpp
    public function enviar_wasap($nombre,$orden){
        $numero = '573024352326'; // Número en formato internacional
        $mensaje = 'Hola soy '.$nombre.' , acabo de generar un pedido desde la pagina y quiero autorizar mi orden con id #'.$orden;
        $mensajeCodificado = urlencode($mensaje);
        
        $enlaceWhatsApp = "https://wa.me/{$numero}?text={$mensajeCodificado}";

        return $enlaceWhatsApp;
    }
}
