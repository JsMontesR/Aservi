

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
          <h4 align="left">Fecha: {{$fechaActual}}</h4>
          <br>
          <h4 align="right">Hola: {{$horaActual}}</h4>
          <br>
          <h4 align="center">Recibo no. {{$numeroRecibo}}</h4>
          <br>
          <h4 align="center">Le atendió: {{$notas}}</h4>
          <br>
          <h4 align="center">Tipo de pago: {{$tipoPago}}</h4>
          <br>
          <h4 align="center">Número de documento: {{$cc}}</h4>
          <br>
          <h4 align="center">Nombre: {{$nombre}}</h4>
          <br>
          @if($direccion != null)
            <h4 align="center">Dirección: {{$direccion}}</h4>
            <br>
          @endif
          @if($telefono != null)
            <h4 align="center">Teléfono: {{$telefono}}</h4>
            <br>
          @endif
          @if($email != null)
            <h4 align="center">Correo electrónico: {{$email}}</h4>
            <br>
          @endif
          <h4 align="left">Producto: {{$producto}}</h4>
          <br>
          <h4 align="left">Total: {{$valor}}</h4>
          <br>
          <h6 align="left">Gracias por su compra}</h4>
    </div>
  </div>
</div>    





