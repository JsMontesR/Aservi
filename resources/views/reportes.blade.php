@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-secondary py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <a href="{{route('reporteEstado')}}" class="font-weight-bold text-secondary">Estado de clientes</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-info-circle fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
