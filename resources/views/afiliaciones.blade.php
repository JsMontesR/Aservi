@extends('layouts.app')


@section('content')
    <div class="card-header py-3">
        <h1 align="center" class="m-0 font-weight-bold text-primary">Afiliaciones</h6>
    </div>
    <br>

 @if(session()->has('success'))

    <div class="alert alert-success" role="alert">{{session('success')}}</div>

@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detalle afiliación</h6>
    </div>
        <div class="card-body">
            <form id="form1" name="form1" method="POST">
            @csrf

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Número de afiliación (Id):</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="id" class="form-control @error('id') is-invalid @enderror" value="{{old('id')}}" name="id" required autocomplete="id">
                        @error('id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Empresa a la cual se desea afiliar:</label>

                    <div class="col-md-8">
                        <select id="empresa_id" name="empresa_id" class="form-control @error('empresa_id') is-invalid @enderror" style="text-transform: capitalize" value="{{old('empresa_id')}}">
                            @foreach($empresas as $empresa)
                                <option value={{$empresa->Id}}>{{$empresa->Nombre}}</option>
                            @endforeach
                            <script type="text/javascript">
                                var value = {!!json_encode(old('empresa_id'))!!};
                                if(value != null){
                                    document.getElementById("empresa_id").value = {!!json_encode(old('empresa_id'))!!}
                                }
                            </script>
                        </select>
                        @error('empresa_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Cliente:</label>

                    <div class="col-md-8">
                        <input readonly="readonly" id="cliente_id" class="form-control @error('cliente_id') is-invalid @enderror" value="{{old('cliente_id')}}" name="cliente_id" required autocomplete>
                        @error('cliente_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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

                <div class="card mb-3">     
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0" data-page-length='5'>
                            @if(!$clientes->isEmpty())
                                    <thead>
                                      <tr>
                                        <th>Seleccionar</th>
                                        @foreach ($clientes->get(0) as $key => $value) 
                                            <th>{{$key}}</th>
                                        @endforeach
                                        
                                      </tr>       
                                    </thead>
                                    <tbody>
                                       @foreach($clientes as $cliente)
                                        <tr>
                                            <td align="center">
                                                <a id="{{$cliente->Id}}c" class="btn btn-secondary text-white">
                                                    <em class="fas fa-angle-up"></em>
                                                    Cargar
                                                </a>
                                            </td>
                                            <script type="text/javascript">
                                              
                                                var cambiar = function(){
                                                    document.getElementById('cliente_id').value = {!!json_encode($cliente->Id)!!};
                                                    document.getElementById('nombreCliente').value = {!!json_encode($cliente->{'Nombre del cliente'})!!};
                                                };
                                                var input = document.getElementById({!!json_encode($cliente->Id)!!}+"c");
                                                input.addEventListener('click',cambiar);
                                                
                                            </script>
                                            @foreach ($clientes[0] as $key => $value) 
                                                <td>{{ $cliente->{$key} }}</td>
                                            @endforeach
                                        </tr>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <th>Seleccionar</th>
                                        @foreach ($clientes[0] as $key => $value) 
                                            <th>{{$key}}</th>
                                        @endforeach
                                      </tr>
                                    </tfoot>
                            @else
                              <h3 align="center">No hay clientes disponibles, intentelo más tarde</h3>
                            @endif
                          </table>
                          

                        </div>
                      </div>
                    </div> 




                    <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-left">Servicio:</label>

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

                    <div class="card mb-3">     
                          <div class="card-body">
                            @if(!$servicios->isEmpty())
                            <div class="table-responsive">

                              <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0" data-page-length='5'>
                                
                                        <thead>
                                          <tr>
                                            <th>Seleccionar</th>
                                            @foreach ($servicios->get(0) as $key => $value) 
                                
                                                    <th>{{$key}}</th>
                                              
                                            @endforeach
                                            
                                          </tr>       
                                        </thead>
                                        <tbody>
                                           @foreach($servicios as $servicio)
                                            <tr>
                                                <td align="center">
                                                    <a id="{{$servicio->Id}}e" class="btn btn-secondary text-white">
                                                        <em class="fas fa-angle-up"></em>
                                                        Cargar
                                                    </a>
                                                </td>
                                                <script type="text/javascript">
                                                  
                                                    var cambiar = function(){
                                                        document.getElementById('servicio_id').value = {!!json_encode($servicio->Id)!!};
                                                        document.getElementById('nombreServicio').value = {!!json_encode($servicio->{'Nombre del servicio'})!!};
                                                    };
                                                    var input = document.getElementById({!!json_encode($servicio->Id)!!}+"e");
                                                    input.addEventListener('click',cambiar);
                                                    
                                                </script>
                                                @foreach ($servicio as $key => $value) 
                                                        
                                                        <td>{{ $value }}</td>
                                                        
                                                @endforeach
                                            </tr>

                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th>Seleccionar</th>
                                            @foreach ($servicios[0] as $key => $value) 

                                                    <th>{{$key}}</th>

                                            @endforeach
                                          </tr>
                                        </tfoot>
                                
                              </table>
                              </div>
                              @else
                                  <h3 align="center">No hay servicios disponibles, intentelo más tarde</h3>
                              @endif

                            
                          </div>
                        </div> 

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left" >Activo:</label>

                            <div class="col-md-8">
                                <input type="checkbox" id="activo" class="form-control" value="{{old('activo')}}" name="activo" checked="true">
                                @error('activo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
        </form>
        <br>
        <div class="d-flex justify-content-center">
        <div align="center" class="btn-toolbar" role="toolbar">
                           
            <br>
            <div class="btn-group col-md">
            <input id="registrar" type="button" value="Registrar" class="btn btn-primary" onclick= "registrarAfiliacion()" />
            <input type="button" value="Limpiar" class="btn btn-secondary" onclick= "limpiarCampos()" />
            </div>
            <br>
            <div class="btn-group col-md">
        <input type="button" value="Modificar" class="btn btn-warning" onclick= "modificarAfiliacion()" />
            
            
            <input type="button" value="Eliminar" class="btn btn-danger" onclick= "eliminarAfiliacion()" />
            </div>
             <script type="text/javascript">
                
            
                function registrarAfiliacion(){

                    document.form1.action = '{{ route('afiliaciones.store') }}';
                    document.form1.submit();
                }

                function modificarAfiliacion(){

                    document.form1.action = '{{ route('afiliaciones.update') }}';
                    document.form1.submit();
                }

                function eliminarAfiliacion(){
                    var opcion = confirm("¿Está seguro que desea eliminar la afiliación seleccionada?");
                    if(opcion){
                        var valor = document.getElementById('id').value;
                        document.form1.action = '{{ route('afiliaciones.delete') }}';    
                        document.form1.submit();
                    }
                    
                }

                function limpiarCampos(){
                            document.getElementById('id').value = "";
                            document.getElementById('cliente_id').value = "";
                            document.getElementById('servicio_id').value = "";
                            document.getElementById('nombreCliente').value = "";
                            document.getElementById('nombreServicio').value = "";
                            document.getElementById('registrar').disabled = false;
                        }

            </script>


        </div>
        </div>
        </div>
    </div>

    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Afiliaciones registradas</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                                  @if(!$afiliaciones->isEmpty())

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-name="my_table" data-page-length='5'>
                                    
                                            <thead>
                                              <tr>
                                                <th>Seleccionar</th>
                                                @foreach ($afiliaciones->get(0) as $key => $value) 
                                                    @if($key != 'Id empresa' && $key != "Id cliente" && $key != "Id servicio")
                                                    <th>{{$key}}</th>
                                                    @endif
                                                @endforeach
                                                
                                              </tr>       
                                            </thead>
                                            <tbody>
                                               @foreach($afiliaciones as $registro)
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
                                                            document.getElementById('cliente_id').value = {!!json_encode($registro->{'Id cliente'})!!};
                                                            document.getElementById('servicio_id').value = {!!json_encode($registro->{'Id servicio'})!!};
                                                            document.getElementById('nombreCliente').value = {!!json_encode($registro->{'Nombre cliente afiliado'})!!};
                                                            document.getElementById('nombreServicio').value = {!!json_encode($registro->{'Nombre servicio'})!!};
                                                            document.getElementById('empresa_id').value = {!!json_encode($registro->{'Id empresa'})!!};
                                                            document.getElementById('activo').checked = {!!json_encode($registro->{'Estado'})!!} == "Activo" ? true : false;

                                                        };
                                                        var input = document.getElementById({!!json_encode($registro->Id)!!});
                                                        input.addEventListener('click',cambiar);
                                                        
                                                    </script>
                                                    @foreach ($registro as $key => $value) 
                                                        @if($key != 'Id empresa' && $key != "Id cliente" && $key != "Id servicio")
                                                            @if($key == 'Estado')
                                                                @if($value == "Inactivo")
                                                                    <td style="color:#FF0000">{{$value}}</th>
                                                                @else
                                                                    <td style="color:#008f39">{{$value}}</th>
                                                                @endif
                                                            @else
                                                                <td>{{$value}}</th>
                                                            @endif
                                                        @endif
                                                        
                                                    @endforeach
                                                    
                                                </tr>

                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                <th>Seleccionar</th>
                                                @foreach ($afiliaciones[0] as $key => $value) 
                                                    @if($key != 'Id empresa' && $key != "Id cliente" && $key != "Id servicio")
                                                    <th>{{$key}}</th>
                                                    @endif
                                                    
                                                @endforeach
                                                
                                              </tr>
                                            </tfoot>
                                    
                                  </table>
                                  @else
                                      <h3 align="center">No hay afiliaciones disponibles, intentelo más tarde</h3>
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
