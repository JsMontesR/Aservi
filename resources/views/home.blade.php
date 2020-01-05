@extends('layouts.app')

@section('content')
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-secondary py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <a href="{{route('clientes')}}" class="font-weight-bold text-secondary">Clientes</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-friends fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-primary py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-gray-800">
                <a href="{{route('servicios')}}">Servicios</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-mail-bulk fa-2x text-gray-300"></i>
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
              <div class="h5 mb-0 font-weight-bold text-yellow-800">
                <a href="{{route('afiliaciones')}}" class="font-weight-bold text-success">Afiliaciones</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-file-contract fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-3">
      <div class="card border-left-warning py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="h5 mb-0 font-weight-bold text-yellow-800">
                <a href="{{route('pagos')}}" class="font-weight-bold text-warning">Pagos</a>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
