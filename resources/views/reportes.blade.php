@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-secondary py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <a href="{{route('reporteEstado')}}" class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Estado de clientes</a>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$morosos}} cliente(s) en mora</div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-info-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-success py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <a href="{{route('reporteIngresos')}}" class="text-xs font-weight-bold text-success text-uppercase mb-1">Ingresos</a>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$ingresos}} hoy</div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-money-bill-alt fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
