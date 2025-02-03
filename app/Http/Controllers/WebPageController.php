<?php

namespace App\Http\Controllers;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use DB;
use App\Models\Ventasitem;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Factura;
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
            'cordenadas'=> $request->cordenada ?? 'Tienda',
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

    public function domicilios_vista(){
        $domicilios=DB::table("domicilios")
        ->select("ventas_items.*","domicilios.id AS ids")
        ->join("ventas_items","domicilios.venta_item_id","ventas_items.id")
        ->where("domicilios.estado","=","Buscando Domiciliario")
        ->get();

        foreach ($domicilios as $domicilio) {
            
            $domicilio->informacion_cliente = json_decode($domicilio->informacion_cliente);
        }
        //return response(["data"=>$domicilios]);
        return view("Page.domicilios",compact("domicilios"));
    }

    public function confirmar($id){
        $ventaItem = DB::table('ventas_items')->where('id', $id)->first(); // Reemplaza $id con el ID que deseas consultar

        if ($ventaItem) {
            // Realiza cualquier lógica necesaria con el registro consultado
            $orden=$ventaItem->tipo_orden;
            $accion="";
            if($orden=="Domicilio"){
                $accion="Buscando domiciliario";
                self::crear_domicilios($id);

            }else{
                $venta=$ventaItem->id;
                $accion="Esperando en tienda";
                $usuario=Auth::user()->id;
                $data = [
                    'venta_id' => $venta,          // Reemplaza con el ID de la venta correspondiente
                    'domiciliario_id' => $usuario,   // Reemplaza con el ID del domiciliario correspondiente
                    'estado' => $accion,  
                    'tipo' => "Tienda",  // Estado de la entrega (puede ser 'Pendiente', 'Completada', etc.)
                    ];
                   // return response(["data"=>$data]);
                $idCreado = DB::table('entregas')->insertGetId($data);
               

            }
            // Actualiza la columna 'accion'
            DB::table('ventas_items')
                ->where('id', $id) // Asegúrate de usar el mismo ID
                ->update(['accion' => $accion]); // Reemplaza 'nuevo valor' con el valor que desees

                return back(); // Redirige a la página anterior
        } else {
            echo "Registro no encontrado.";
        }
    }

    public function crear_domicilios($data){
        DB::table('domicilios')->insert([
            'venta_item_id' => $data,
            'estado' => 'Buscando domiciliario', // Estado inicial
        ]); 
    }

    public function aceptar($id){
        $consulta=DB::table("domicilios")->where("id","=",$id)->first();
        
        //return response(["data"=>$consulta]);
       $disponibilidad =self::comprobar_disponibilidad($consulta);
        if($disponibilidad){
            return self::asignar_orden($consulta);
        }else{
            return back();
        }
        
    }
    public function asignar_orden($consulta){
       $usuario=Auth::user()->id;
       $venta=$consulta->venta_item_id;
       $data = [
        'venta_id' => $venta,          // Reemplaza con el ID de la venta correspondiente
        'domiciliario_id' => $usuario,   // Reemplaza con el ID del domiciliario correspondiente
        'estado' => 'Dirigiendose a la tienda', 
        'tipo' => 'Domicilio',   // Estado de la entrega (puede ser 'Pendiente', 'Completada', etc.)
        ];
       // return response(["data"=>$data]);
        $idCreado = DB::table('entregas')->insertGetId($data);
        return redirect()->route('status', ['id' => $idCreado]);
    }

    public function status($id){
       
        $consultas=DB::table("entregas")
        ->select("ventas_items.*","entregas.id as ids","entregas.estado","entregas.id")
        ->join("ventas_items","entregas.venta_id","ventas_items.id")
        ->where("entregas.id","=",$id)
        ->first();
        $coordinates =  $consultas->cordenadas;

        // Generar el enlace de Google Maps desde la ubicación actual hasta las coordenadas
        $googleMapsLink = "https://www.google.com/maps/dir/?api=1&origin=&destination=" . urlencode($coordinates);
        $consultas->cordenadas=$googleMapsLink;
        $consultas->telefonos=$jsonObject = json_decode($consultas->informacion_cliente);
        $telefono=$consultas->telefonos->Celular;
        $consultas->numero=$telefono;

        $telefono = $consultas->numero;

        // Enlace para llamada
        $callLink = "tel:" . $telefono;
        $consultas->tele=$callLink;
        // Enlace para WhatsApp
        $whatsappLink = "https://wa.me/" ."+57". $telefono;
        $consultas->wsa=$whatsappLink;

       //return response(["data"=>$consultas]);
        $consultas->lista_productos = json_decode( $consultas->lista_productos);

        return view("page.entrega",compact("consultas"));
    }
    public function cliente_informacion($id){
        $consultas=DB::table("entregas")
        ->where("entregas.id","=",$id)
        ->update(['estado' => "Dirigiendose donde el cliente"]);
        return redirect()->route('status', ['id' => $id]);
    }
    public function comprobar_disponibilidad($consulta){
        if ($consulta && strpos($consulta->estado, 'Buscando domiciliario') !== false) {
            DB::table('domicilios')
            ->where('id', '=', $consulta->id)
            ->update(['estado' => "asignando orden"]);
            return true;
        } else {
            return false;
            return back();
        }
    }

    public function stream()
    {
        // Establecer cabeceras para la respuesta SSE
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        while (true) {
            // Obtener las solicitudes de domicilios
            $domicilios = DB::table('domicilios')
                ->where('estado', 'Buscando domiciliario')
                ->get();

            // Enviar los datos como un evento
            echo "data: " . json_encode($domicilios) . "\n\n";
            ob_flush();
            flush();

            // Esperar antes de la siguiente consulta
            sleep(20); // Espera 5 segundos antes de volver a consultar
        }
    }

    public function prueba(){
        $usuario = Auth::user();
        return response(["data"=>$usuario]);
    }

    public function facturar($id){
       //actualiz el estado

       $consultar=DB::table('entregas')
       ->select("venta_id")
       ->where('id', '=', $id)
       ->first();

        DB::table('entregas')
        ->where('id', '=', $id)
        ->update(
            ['estado' => "entregado"]
        );

        //creo su facturacion

        $factura = Factura::create([
            'id_venta_items' => $consultar->venta_id, // Asigna el valor adecuado
            'created_at' => now(),             // Usamos la fecha actual para created_at
            'updated_at' => now()              // Usamos la fecha actual para updated_at
        ]);

        //return response(["data"=>$consulta]);
        return back();

    }

}
