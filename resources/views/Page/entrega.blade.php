@extends('voyager::master') @section('page_title', 'Todo') @section('content')
<div class="page-content container-fluid">

  <div class="row  justify-content-end">
    <div class="col-md-6 col-12 text-center">
      <div class="jumbotron">
        <h1 class="display-4">Hola {{ Auth::user()->name}}</h1>
        @if ($consultas->estado=="Dirigiendose a la tienda")
        <p class="lead">El primer paso es dirigirte a traer los productos que el cliente solicito</p>
        <hr class="my-4">
        <ul class="list-group">
          @foreach ($consultas->lista_productos as $producto)
          <li class="list-group-item"><b>Producto: </b> {{$producto->producto_nombre}} <b>Cantidad:
            </b>{{$producto->cantidad}}</li>
          @endforeach
        </ul>
        <hr class="my-4">
        <p>Cuando tengas los productos confirma que te diriges donde el cliente</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="../cliente_informacion/{{$consultas->ids}}" role="button">Dirigirme donde el cliente</a>
        </p>
        @else

       
        <div class="container text-center mt-5">
        <a class="btn btn-primary me-2" href="{{ $consultas->cordenadas}}" target='_blank'>
            <i class="fas fa-map-marker-alt"></i> Google Maps
        </a>
        <a class="btn btn-success me-2" href="{{ $consultas->wsa}}" target='_blank'>
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <a class="btn btn-danger" href="{{ $consultas->tele}}" target='_blank'>
            <i class="fas fa-phone"></i> Llamada
        </a>
        <a class="btn btn-warning" href="{{ route('facturar',['id'=>$consultas->id])}}" >
          <i class="fas fa-phone"></i> Terminar Entrega
      </a>
    </div>
        @endif
      </div>
    </div>
  </div>
</div>

@endsection