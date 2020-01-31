

<style>
    @page { size: 73mm 600pt ;margin: 5px;}

    table {
      border: #b2b2b2 1px solid;
    }
    td {
      border: black 1px solid;
    }
</style>
<!--
<div align="center">
    <img src="favicon.png" class="img-fluid" alt="Responsive image">
</div>
-->
<div align="center">
    <img style="width: 50mm; height: 13mm" src="aservi.png" class="img-fluid" alt="Responsive image">
</div>
<div align="center" style="font-size:12px">{{$nombre}}</div>
<div align="center" style="font-size:12px">{{$fijo}}</div>
<div align="center" style="font-size:12px">{{$celular}}</div>
<br>


<div align="left" style="font-size:12px" >
  <label>Fecha: {{$fechaActual}}</label>
  <label>Hora: {{$horaActual}}</label>
  <br>
  <label> Recibo no. {{$numeroRecibo}} </label>
  <br>

  @if($usuario != null)

    <label> Le atendió: {{$usuario}} </label>
    <br>
    
  @endif

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

  <label> Recibo válido hasta: {{$fechaValidez}} </label>
  <br>

</div>

<br>

<div align="center" style="font-size:12px">
  <label>Por favor conservar este tiquete</label>
  <br>
  <label>Gracias por su compra</label>
</div>





