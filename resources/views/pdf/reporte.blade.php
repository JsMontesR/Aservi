

<!-- Page level plugin CSS-->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

<link href="{{asset('css/styles.css')}}" rel="stylesheet">

<div class="card-header py-3">
        <h1 align="center" class="m-0 font-weight-bold text-primary">{{$nombrereporte}}</h6>
</div>
<br>

<div class="card mb-3">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0">
            @if(!$registros->isEmpty())
                    <thead>
                      <tr>
                         @foreach ($registros->get(0) as $key => $value) 
                            <th>{{$key}}</th>
                        @endforeach
                      </tr>       
                    </thead>
                    <tbody>
                       @foreach($registros as $registro)
                        <tr>
                            @foreach ($registros[0] as $key => $value) 
                                <td>{{ $registro->{$key} }}</td>
                            @endforeach
                            
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                         @foreach ($registros[0] as $key => $value) 
                            <th>{{$key}}</th>
                        @endforeach
                      </tr>
                    </tfoot>
            @else
              <h3 align="center">No hay registros disponibles, intentelo más tarde</h3>
            @endif
      </table>
      
      <script type="text/javascript" src="{{asset('js/spanishtable.js')}}"></script>
      <script type="text/javascript" src="{{asset('js/spanish.js')}}"></script>

    </div>
  </div>
</div>    
 <h5 align="center">Fecha y hora actual del reporte {{(new DateTime())->format('d/m/yy')}}</h5>
 <br>



