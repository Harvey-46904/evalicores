@extends('voyager::master') @section('page_title', 'Todo') @section('content')
<div class="page-content container-fluid">
   Lista domicilios
   <div class="row  justify-content-end">
        <div class="col-md-6 col-12 text-center">
            <div class="card" style="width: 18rem;">
                @foreach ($domicilios as $domicilio)
                <div class="card-body">
                        <h5 class="card-title">{{$domicilio->informacion_cliente->Nombres_completos}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">25 min</h6>
                        <p class="card-text">mz f barrio colo</p>
                        <a href="aceptacion/{{$domicilio->ids}}" class="card-link btn btn-success">Aceptar</a>
                </div>
                @endforeach
            </div>
        </div>
   </div>
</div>

@endsection
