

<!-- Page level plugin CSS-->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

<link href="{{asset('css/styles.css')}}" rel="stylesheet">

<div align="center">
    <img src="favicon.png" class="img-fluid" alt="Responsive image">
</div>
<h1 align="center">{{$nombre}}</h1>
<br>

<div class="card mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <h4 align="center">Cliente: {{$cliente}}</h4>
          <br>
          <h4 align="center">{{$equipo}}</h4>
          <br>
          <h4 align="center">Problema reportado: {{$problema}}</h4>
          <br>
          @if($notas != null)
          <h4 align="center">Notas: {{$notas}}</h4>
          <br>
          @endif
          <h4 align="center">Fecha: {{$fecha}}</h4>
          <br>
    </div>
  </div>
</div>    





