
<!-- Custom styles for this template-->
<link href="{{asset('css/sb-admin-2.css')}}" rel="stylesheet">

<div align="center">
    <img src="favicon.png" class="img-fluid" alt="Responsive image">
</div>

<h2 align="center">{{$nombre}}</h2>
<h2 align="center">{{$datosRecibo}}</h2>
<br>


<h4 align="left">
  <label>Fecha: {{$fechaActual}}</label>
  <label>Hora: {{$horaActual}}</label>
</h4>

<h4 align="left">

  <label> Recibo no. {{$numeroRecibo}} </label>
  <br>

  <label> Le atendió: {{$usuario}} </label>
  <br>

  <label> Tipo de pago: {{$tipoPago}} </label>
  <br>

  <label> Número de documento: {{$cc}} </label>
  <br>

  <label> Nombre: {{$nombreCliente}} </label>
  <br>

  @if($direccion != null)

    <label> Dirección: {{$direccion}} </label>
    <br>

  @endif

  @if($telefono != null)

    <label> Teléfono: {{$telefono}} </label>
    <br>

  @endif
  @if($email != null)

    <label> Correo electrónico: {{$email}} </label>
    <br>

  @endif

  <label> Producto: {{$producto}} </label>
  <br>

  <label> Total: $ {{$valor}} </label>
  <br>

</h4>

<h4 align="center">
  <label> Gracias por su compra</label>
</h4>





