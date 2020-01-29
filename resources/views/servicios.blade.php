@extends('layouts.app')

@section('content')

    <div class="card-header py-3">
        <h1 align="center" class="m-0 font-weight-bold text-primary">Servicios</h6>
    </div>
    <br>

 @if(session()->has('success'))
    <div class="alert alert-success" role="alert">{{session('success')}}</div>
@endif
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detalle servicio</h6>
    </div>
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
                <label class="col-md-4 col-form-label text-md-left">Nombre del servicio:</label>

                <div class="col-md-8">
                    <input id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{old('nombre')}}" name="nombre" required autocomplete="nombre">
                    @error('nombre')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-left">Periodicidad:</label>

                <div class="col-md-8">
                    <select id="periodicidad" name="periodicidad" class="form-control @error('periodicidad') is-invalid @enderror" style="text-transform: capitalize" value="{{old('periodicidad')}}">
                     
                            <option value="Mensual" selected="">Mensual</option>
                            <option value="Trimestral">Trimestral</option>
                            <option value="Semestral">Semestral</option>
                            <option value="Anual">Anual</option>

                        <script type="text/javascript">
                            var value = {!!json_encode(old('periodicidad'))!!};
                            if(value != null){
                                document.getElementById("periodicidad").value = {!!json_encode(old('periodicidad'))!!}
                            }
                        </script>
                    </select>
                    @error('periodicidad')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-left">Costo:</label>

                <div class="col-md-8">
                    <input id="costo" type="number" class="form-control @error('costo') is-invalid @enderror" value="{{old('costo')}}" name="costo" required autocomplete="costo">
                    @error('costo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-left">Precio:</label>

                <div class="col-md-8">
                    <input id="precio" type="number" class="form-control @error('precio') is-invalid @enderror" value="{{old('precio')}}" name="precio" required autocomplete="precio">
                    @error('precio')
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
                            <input id="registrar" type="button" value="Registrar" class="btn btn-primary" onclick= "registrarUsuario()" />
                            <input type="button" value="Limpiar" class="btn btn-secondary" onclick= "limpiarCampos()" />
                        </div>
                            <br>

                        <div class="btn-group col-md">
                            <input type="button" value="Modificar" class="btn btn-warning" onclick= "modificarUsuario()" />
                            <input type="button" value="Eliminar" class="btn btn-danger" onclick= "eliminarUsuario()" />
                        </div>
                             <script type="text/javascript">
                                
                                function registrarUsuario(){

                                    document.form1.action = '{{ route('servicios.store') }}';
                                    document.form1.submit();
                                }

                                function modificarUsuario(){

                                    document.form1.action = '{{ route('servicios.update') }}';
                                    document.form1.submit();
                                }

                                function eliminarUsuario(){
                                    var opcion = confirm("¿Está seguro que desea eliminar el servicio seleccionado?");
                                    if(opcion){
                                        var valor = document.getElementById('id').value;
                                        document.form1.action = '{{ route('servicios.delete') }}';    
                                        document.form1.submit();
                                    }
                                    
                                }

                                function limpiarCampos(){
                                            document.getElementById('id').value = "";
                                            document.getElementById('nombre').value = "";
                                            document.getElementById('periodicidad').value = "";
                                            document.getElementById('costo').value = "";
                                            document.getElementById('precio').value = "";
                                            document.getElementById('registrar').disabled = false;
                                        }

                            </script>

                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Servicios registrados</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                                  @if(!$servicios->isEmpty())

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" data-name="my_table">
                                    
                                            <thead>
                                              <tr>
                                                <th>Seleccionar</th>
                                                @foreach ($servicios->get(0) as $key => $value) 
                                                   
                                                    <th>{{$key}}</th>
                                                    
                                                @endforeach
                                                
                                              </tr>       
                                            </thead>
                                            <tbody>
                                               @foreach($servicios as $registro)
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
                                                            document.getElementById('nombre').value = {!!json_encode($registro->Nombre)!!};
                                                            document.getElementById('periodicidad').value = {!!json_encode($registro->Periodicidad)!!};
                                                            document.getElementById('costo').value = {!!json_encode($registro->Costo)!!};
                                                            document.getElementById('precio').value = {!!json_encode($registro->Precio)!!};


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
                                                @foreach ($servicios[0] as $key => $value) 
                                                    
                                                    <th>{{$key}}</th>
                                                    
                                                @endforeach
                                                
                                              </tr>
                                            </tfoot>
                                    
                                  </table>
                                  @else
                                      <h3 align="center">No hay servicios disponibles, intentelo más tarde</h3>
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
