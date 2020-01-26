<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Afiliacion;

class AfiliacionesController extends Controller
{
    public $validationRules = [
            'cliente_id' => 'required|integer|min:0',
            'servicio_id' => 'required|integer|min:0',
            'empresa_id' => 'required|integer|min:0',
        ];

    public $validationIdRule = ['id' => 'required|integer|min:0'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $afiliaciones = DB::table('afiliaciones')->select(
        DB::raw('afiliaciones.id as Id'),
        DB::raw('cliente_id as "Id cliente"'),
        DB::raw('clientes.di as "Cedula cliente afiliado"'),
        DB::raw('clientes.nombre as "Nombre cliente afiliado"'),
        DB::raw('cliente_id as "Id servicio"'),
        DB::raw('servicios.nombre as "Nombre servicio"'),
        DB::raw('empresas.id as "Id empresa"'),
        DB::raw('empresas.nombre as "Empresa"'),
        DB::raw('servicios.precio as "Tarifa"'),
        DB::raw('IF(afiliaciones.activo,"Activo","Inactivo") as "Estado"'),
        DB::raw('afiliaciones.fechaSiguientePago as "Fecha de siguiente pago"'))
       ->join('clientes', 'clientes.id', '=', 'afiliaciones.cliente_id')
       ->join('servicios', 'servicios.id', '=', 'afiliaciones.servicio_id')
       ->join('empresas', 'empresas.id', '=', 'afiliaciones.empresa_id')
       ->get();

        $clientes = DB::table('clientes')->select(
            DB::raw('id as Id'),
            DB::raw('di as Cedula'),
            DB::raw('nombre as "Nombre del cliente"')
            )->get();

        $servicios = DB::table('servicios')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as "Nombre del servicio"'))->get();

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
        

        return view('afiliaciones',compact('afiliaciones','clientes','servicios','empresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate($this->validationRules);

        $afiliacion = new Afiliacion;
        $afiliacion->cliente_id = $request->cliente_id;
        $afiliacion->servicio_id = $request->servicio_id;
        $afiliacion->empresa_id = $request->empresa_id;
        $afiliacion->activo = $request->has('activo');
        $afiliacion->save();

        return back()->with('success', 'Afiliación creada');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate($this->validationIdRule);
        $request->validate($this->validationRules);

        $afiliacion = Afiliacion::findOrFail($request->id);
        $afiliacion->cliente_id = $request->cliente_id;
        $afiliacion->servicio_id = $request->servicio_id;
        $afiliacion->empresa_id = $request->empresa_id;
        $afiliacion->activo = $request->has('activo');
        $afiliacion->save();

        return back()->with('success', 'Afiliación actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request->validate($this->validationIdRule);
        try {
            Afiliacion::findOrFail($request->id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw ValidationException::withMessages(['id' => 'La afiliación no puede ser eliminada ya que existen pagos a su nombre',]);
        }    
        
        return back()->with('success', 'Afiliación eliminada');
    }
}
