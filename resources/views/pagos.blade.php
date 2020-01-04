@extends('layouts.app')

@section('content')
<h1 align="center">Clientes</h1>
<br>

 @if(session()->has('success'))

    <div class="alert alert-success" role="alert">{{session('success')}}</div>

@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md">
            <div class="card" >
                <div class="card-header" style="font-size:20px" align="center">Detalle Cliente</div>

                <div class="card-body">

                    <form id="form1" name="form1" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Id:</label>

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
                            <label class="col-md-4 col-form-label text-md-left">Nombre:</label>

                            <div class="col-md-8">
                                <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name" required autocomplete="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Cédula</label>

                            <div class="col-md-8">
                                <input  id="cedula" class="form-control @error('cedula') is-invalid @enderror" value="{{old('cedula')}}" name="cedula" required autocomplete>
                                @error('cedula')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Teléfono Celular:</label>

                            <div class="col-md-8">
                                <input id="telefonocelular" class="form-control @error('telefonocelular') is-invalid @enderror" value="{{old('telefonocelular')}}" name="telefonocelular" required autocomplete>
                                @error('telefonocelular')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Teléfono fijo:</label>

                            <div class="col-md-8">
                                <input id="telefonofijo" class="form-control @error('telefonofijo') is-invalid @enderror" value="{{old('telefonofijo')}}" name="telefonofijo" required autocomplete>
                                @error('telefonofijo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Correo electrónico:</label>

                            <div class="col-md-8">
                                <input id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" name="email" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-left">Dirección:</label>

                            <div class="col-md-8">
                                <input  id="direccion" class="form-control " name="direccion" value="{{old('direccion')}}" required autocomplete>
                            </div>
                        </div>

                </div>

                </div>

                <div align="center">
                           
                            <br>
                            <div class="btn-group col-md">
                            <input id="registrar" type="button" value="Registrar" class="btn btn-primary" onclick= "registrarUsuario()" />

                            <input type="button" value="Modificar" class="btn btn-warning" onclick= "modificarUsuario()" />

                            </div>
                            <br>
                            <div class="btn-group col-md">
                            <input type="button" value="Limpiar" class="btn btn-secondary" onclick= "limpiarCampos()" />
                            
                            <input type="button" value="Eliminar" class="btn btn-danger" onclick= "eliminarUsuario()" />
                            </div>
                             <script type="text/javascript">
                                
                            
                                function registrarUsuario(){

                                    document.form1.action = '{{ route('clientes.store') }}';
                                    document.form1.submit();
                                }

                                function modificarUsuario(){

                                    document.form1.action = '{{ route('clientes.update') }}';
                                    document.form1.submit();
                                }

                                function eliminarUsuario(){
                                    var opcion = confirm("¿Está seguro que desea eliminar el cliente seleccionado?");
                                    if(opcion){
                                        var valor = document.getElementById('id').value;
                                        document.form1.action = '{{ route('clientes.delete') }}';    
                                        document.form1.submit();
                                    }
                                    
                                }

                                function limpiarCampos(){
                                            document.getElementById('id').value = "";
                                            document.getElementById('name').value = "";
                                            document.getElementById('email').value = "";
                                            document.getElementById('cedula').value = "";
                                            document.getElementById('telefonocelular').value = "";
                                            document.getElementById('telefonofijo').value = "";
                                            document.getElementById('direccion').value = "";
                                            document.getElementById('registrar').disabled = false;
                                        }

                            </script>

                        </form>


                        </div>

                        <br>
                    
                </div>
            </div>
        </div>

       
        <br>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="card">
                        <div class="card-header" style="font-size:20px" align="center">Clientes registrados</div>
                            <div class="card mb-3">     
                              <div class="card-body">
                                <div class="table-responsive">
                                  @if(!$clientes->isEmpty())
                                  <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0">
                                    
                                            <thead>
                                              <tr>
                                                <th>Seleccionar</th>
                                                @foreach ($clientes->get(0) as $key => $value) 
                                                   
                                                    <th>{{$key}}</th>
                                                    
                                                @endforeach
                                                
                                              </tr>       
                                            </thead>
                                            <tbody>
                                               @foreach($clientes as $registro)
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
                                                            document.getElementById('name').value = {!!json_encode($registro->Nombre)!!};
                                                            document.getElementById('cedula').value = {!!json_encode($registro->Cedula)!!};
                                                            document.getElementById('email').value = {!!json_encode($registro->Email)!!};
                                                            document.getElementById('telefonofijo').value = {!!json_encode($registro->{'Telefono Fijo'})!!};
                                                            document.getElementById('telefonocelular').value = {!!json_encode($registro->{'Telefono Celular'})!!};
                                                            document.getElementById('direccion').value = {!!json_encode($registro->Direccion)!!};

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
                                                @foreach ($clientes[0] as $key => $value) 
                                                    
                                                    <th>{{$key}}</th>
                                                    
                                                @endforeach
                                                
                                              </tr>
                                            </tfoot>
                                    
                                  </table>
                                  @else
                                      <h3 align="center">No hay clientes disponibles, intentelo más tarde</h3>
                                  @endif
                                  <script type="text/javascript" src="{{asset('js/spanishtable.js')}}"></script>
                                  <script type="text/javascript" src="{{asset('js/spanish.js')}}"></script>

                                </div>
                              </div>
                            </div> 

                </div>
            </div>
        </div>
    </div> 

    </div>
</div>
@endsection
