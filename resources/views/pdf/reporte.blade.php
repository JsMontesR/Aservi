



<style>
    @page { size: 279.4mm 216mm }
     table {
      border: #b2b2b2 1px solid;
    }
    td {
      border: black 1px solid;
    }
    th {
      border: black 1px solid;
    }
</style>

<div class="card-header py-3">
        <h1 align="center" class="m-0 font-weight-bold text-primary">Reporte {{$nombrereporte}}</h6>
</div>
<br>

<div class="card mb-3" style="font-size: 13px">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" data-name="my_table" width="100%" cellspacing="0">
            @if(!$registros->isEmpty())
                    <thead>
                      <tr>
                         @foreach ($registros->get(0) as $key => $value) 
                            <th align="center">{{$key}}</th>
                        @endforeach
                      </tr>       
                    </thead>
                    <tbody>
                       @foreach($registros as $registro)
                       <tr>
                          @foreach($registro as $key => $value)
                            
                                  @if($key == "Estado")
                                    @if($value == "Al dia")
                                      <td align="center" style="color:#008f39">{{ $value }}</td>
                                    @else
                                      @if($value == "Sin pagos registrados")
                                        <td align="center">{{ $value }}</td>
                                      @else
                                        <td align="center" style="color:#FF0000">{{ $value }}</td>
                                      @endif
                                    @endif

                                  @else
                                    <td align="center">{{ $value }}</td>
                                  @endif                            
                            
                          @endforeach
                          </tr>
                        @endforeach
                    </tbody>
            @else
              <h3 align="center">No hay registros disponibles, intentelo más tarde</h3>
            @endif
      </table>
      
      <script type="text/javascript" src="{{asset('js/spanishtable.js')}}"></script>
      <script type="text/javascript" src="{{asset('js/spanish.js')}}"></script>

    </div>
  </div>
</div> 
@if($pieDePg != null)
  <div class="card-header py-3">
        <h5 align="center" class="m-0 font-weight-bold text-primary">

           @foreach($pieDePg as $key => $value)
           {{$value}} 
           @endforeach
        </h5>
    
  </div>
@endif
<br>
 <h5 align="center">Fecha y hora actual del reporte {{(new DateTime())->format('d/m/yy h:i:s')}}</h5>
 <br>
 <br>
 



