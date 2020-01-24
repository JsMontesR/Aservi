@extends('layouts.app')

@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
    </div>
        <div class="card-body">
            <form id="form1" name="form1" method="GET" action="{{route('reporteEstado')}}">

	        <div class="form-group row">
	            <label class="col-md-4 col-form-label text-md-left">Empresa:</label>

	            <div class="col-md-8">
	                <select id="empresa_id" name="empresa_id" class="form-control @error('empresa_id') is-invalid @enderror" style="text-transform: capitalize">
	                    @foreach($empresas as $empresa)
	                        <option id={{$empresa->Id}} value={{$empresa->Id}}>{{$empresa->Nombre}}</option>
	                    @endforeach
	                    
	                </select>
	                @error('empresa_id')
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $message }}</strong>
	                </span>
	                @enderror
	            </div>
	        </div>

	        <div align="center">
                           
            <br>
            <div class="btn-group col-md">
           
            
            <input type="button" value="Filtrar" class="btn btn-info" onclick= "filtrar()" />
            </div>
                 <script type="text/javascript">
                    
               
                    function filtrar(){
                        	var valor = document.getElementById("empresa_id").value;
                            document.form1.submit();
                            document.getElementById(valor).selected = true;
                        
                    }

                    

                </script>


            </div>

           </form>  
    </div>
</div>

@include('pdf.reporte')

@if(!$registros->isEmpty())

    <div align="center">
        <a href="{{ route($rutapdf) }}" class="btn btn-sm btn-primary btndiag">
                Ver impresión
        </a>
        
    </div>
    <br>

@endif
@endsection

