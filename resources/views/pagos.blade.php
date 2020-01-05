@extends('layouts.app')

@section('content')

    <div class="card-header py-3">
        <h1 align="center" class="m-0 font-weight-bold text-primary">Pagos</h6>
    </div>
    <br>

 @if(session()->has('success'))

    <div class="alert alert-success" role="alert">{{session('success')}}</div>

@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detalle pago</h6>
    </div>
        <div class="card-body">
            <form id="form1" name="form1" method="POST">
            @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Número de pago (Id):</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="id" class="form-control @error('id') is-invalid @enderror" value="{{old('id')}}" name="id" required autocomplete="iduser">
                        @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Afiliación (Id):</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="afiliacion_id" class="form-control @error('afiliacion_id') is-invalid @enderror" value="{{old('afiliacion_id')}}" name="afiliacion_id" required autocomplete>
                        @error('afiliacion_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="card mb-3">     
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0">
                        @if(!$afiliaciones->isEmpty())
                                <thead>
                                  <tr>
                                    <th>Seleccionar</th>
                                    @foreach ($afiliaciones->get(0) as $key => $value) 
                                        <th>{{$key}}</th>
                                    @endforeach
                                    
                                  </tr>       
                                </thead>
                                <tbody>
                                   @foreach($afiliaciones as $afiliacion)
                                    <tr>
                                        <td align="center">
                                            <a id="{{$afiliacion->Id}}e" class="btn btn-secondary text-white">
                                                <em class="fas fa-angle-up"></em>
                                                Cargar
                                            </a>
                                        </td>
                                        <script type="text/javascript">
                                          
                                            var cambiar = function(){
                                                document.getElementById('afiliacion_id').value = {!!json_encode($afiliacion->Id)!!};
                                                document.getElementById('nombreCliente').value = {!!json_encode($afiliacion->{'Nombre del cliente'})!!};
                                                document.getElementById('cedula').value = {!!json_encode($afiliacion->Cedula)!!};
                                                document.getElementById('servicio_id').value = {!!json_encode($afiliacion->{'Id del servicio'})!!};
                                                document.getElementById('nombreServicio').value = {!!json_encode($afiliacion->{'Nombre del servicio'})!!};
                                                document.getElementById('fechaSiguientePago').value = {!!json_encode($afiliacion->{'Fecha de siguiente pago'})!!};
                                            };
                                            var input = document.getElementById({!!json_encode($afiliacion->Id)!!}+"e");
                                            input.addEventListener('click',cambiar);
                                            
                                        </script>
                                        @foreach ($afiliaciones[0] as $key => $value) 
                                            <td>{{ $afiliacion->{$key} }}</td>
                                        @endforeach
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>Seleccionar</th>
                                    @foreach ($afiliaciones[0] as $key => $value) 
                                        <th>{{$key}}</th>
                                    @endforeach
                                  </tr>
                                </tfoot>
                        @else
                          <h3 align="center">No hay afiliaciones disponibles, intentelo más tarde</h3>
                        @endif
                      </table>
                      

                    </div>
                  </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Nombre cliente:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="nombreCliente" class="form-control @error('nombreCliente') is-invalid @enderror" value="{{old('nombreCliente')}}" name="nombreCliente" required autocomplete>
                        @error('nombreCliente')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Cedula cliente:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="cedula" class="form-control @error('cedula') is-invalid @enderror" value="{{old('cedula')}}" name="cedula" required autocomplete>
                        @error('cedula')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>


                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Número servicio:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="servicio_id" class="form-control @error('servicio_id') is-invalid @enderror" value="{{old('servicio_id')}}" name="servicio_id" required autocomplete>
                        @error('servicio_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Nombre servicio:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="nombreServicio" class="form-control @error('nombreServicio') is-invalid @enderror" value="{{old('nombreServicio')}}" name="nombreServicio" required autocomplete>
                        @error('nombreServicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Fecha límite de pago:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="fechaSiguientePago" class="form-control @error('fechaSiguientePago') is-invalid @enderror" value="{{old('fechaSiguientePago')}}" name="fechaSiguientePago" required autocomplete>
                        @error('fechaSiguientePago')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    
                </div>
        </form>

        <div align="center">
                           
            <br>
            <div class="btn-group col-md">
            <input id="registrar" type="button" value="Registrar" class="btn btn-primary" onclick= "registrarPago()" />

            <input type="button" value="Modificar" class="btn btn-warning" onclick= "modificarPago()" />

            </div>
            <br>
            <div class="btn-group col-md">
            <input type="button" value="Limpiar" class="btn btn-secondary" onclick= "limpiarCampos()" />
            
            <input type="button" value="Eliminar" class="btn btn-danger" onclick= "eliminarPago()" />
            </div>
             <script type="text/javascript">
                
            
                function registrarPago(){

                    document.form1.action = '{{ route('pagos.store') }}';
                    document.form1.submit();
                }

                function modificarPago(){

                    document.form1.action = '{{ route('pagos.update') }}';
                    document.form1.submit();
                }

                function eliminarPago(){
                    var opcion = confirm("¿Está seguro que desea eliminar el pago seleccionado?");
                    if(opcion){
                        var valor = document.getElementById('id').value;
                        document.form1.action = '{{ route('pagos.delete') }}';    
                        document.form1.submit();
                    }
                    
                }

                function limpiarCampos(){
                            document.getElementById('id').value = "";
                            document.getElementById('afiliacion_id').value = "";
                            document.getElementById('nombreCliente').value = "";
                            document.getElementById('cedula').value = "";
                            document.getElementById('servicio_id').value = "";
                            document.getElementById('nombreServicio').value = "";
                            document.getElementById('fechaSiguientePago').value = "";
                        }

            </script>


        </div>

        </div>
    </div>

    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Pagos registrados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                      @if(!$pagos->isEmpty())

                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-name="my_table">
                        
                                <thead>
                                  <tr>
                                    <th>Seleccionar</th>
                                    @foreach ($pagos->get(0) as $key => $value) 
                                       
                                        <th>{{$key}}</th>
                                        
                                    @endforeach
                                    
                                  </tr>       
                                </thead>
                                <tbody>
                                   @foreach($pagos as $registro)
                                    <tr>
                                        <td align="center">
                                            <a id="{{$registro->Id}}" class="btn btn-secondary text-white" href="#page-top">
                                                <em class="fas fa-angle-up"></em> 
                                                Ver
                                            </a>
                                        </td>
                                        <script type="text/javascript">

                                            var cambiar = function(){
                                                document.getElementById('registrar').disabled = true;
                                                document.getElementById('id').value = {!!json_encode($registro->Id)!!};
                                                document.getElementById('afiliacion_id').value = {!!json_encode($registro->{'Id afiliacion'})!!};
                                                document.getElementById('nombreCliente').value = {!!json_encode($registro->{'Nombre cliente'})!!};
                                                document.getElementById('cedula').value = {!!json_encode($registro->Cedula)!!};
                                                document.getElementById('servicio_id').value = {!!json_encode($registro->{'Id servicio'})!!};
                                                document.getElementById('nombreServicio').value = {!!json_encode($registro->{'Nombre servicio'})!!};
                                                document.getElementById('monto').value = {!!json_encode($registro->Monto)!!};

                                            };
                                            var input = document.getElementById({!!json_encode($registro->Id)!!});
                                            input.addEventListener('click',cambiar);
                                            
                                        </script>
                                        @foreach ($registro as $key => $value) 
                                            
                                            <td>{{ $value }}</td>
                                            
                                        @endforeach
                                        
                                    </tr>

                                    @endforeach
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>Seleccionar</th>
                                    @foreach ($pagos[0] as $key => $value) 
                                        
                                        <th>{{$key}}</th>
                                        
                                    @endforeach
                                    
                                  </tr>
                                </tfoot>
                                    
                                  </table>
                                  @else
                                      <h3 align="center">No hay pagos disponibles, intentelo más tarde</h3>
                                  @endif
                                  <script type="text/javascript" src="{{asset('js/spanishtable.js')}}"></script>
                                  <script type="text/javascript" src="{{asset('js/spanish.js')}}"></script>

                                </div>
                              </div>

                            </div>
                    </div>
                <br>
        </div> 
    </div>
</div>
@endsection
