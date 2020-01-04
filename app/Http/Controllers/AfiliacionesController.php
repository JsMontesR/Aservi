<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Afiliacion;

class AfiliacionesController extends Controller
{
    public $validationRules = [
            'cliente_id' => 'required|integer|min:0',
            'servicio_id' => 'required|integer|min:0',
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
        DB::raw('clientes.nombre as "Nombre cliente"'),
        DB::raw('cliente_id as "Id servicio"'),
        DB::raw('servicios.nombre as "Nombre servicio"'))
       ->join('clientes', 'clientes.id', '=', 'afiliaciones.cliente_id')
       ->join('servicios', 'servicios.id', '=', 'afiliaciones.servicio_id')
       ->get();

        $clientes = DB::table('clientes')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as "Nombre del cliente"'),
            DB::raw('di as Cedula'))->get();

        $servicios = DB::table('servicios')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as "Nombre del servicio"'))->get();
        

        return view('afiliaciones',compact('afiliaciones','clientes','servicios'));
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

        $cliente = new Cliente;
        $cliente->nombre = $request->name;
        $cliente->email = $request->email;
        $cliente->di = $request->cedula;
        $cliente->telefonocelular = $request->telefonocelular;
        $cliente->direccion = $request->direccion;
        $cliente->telefonofijo = $request->telefonofijo;
        $cliente->save();

        return redirect()->route('clientes')->with('success', 'Cliente registrado');
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
        
        $cliente = Cliente::findOrFail($request->id);
        $cliente->nombre = $request->name;
        $cliente->email = $request->email;
        $cliente->di = $request->cedula;
        $cliente->telefonocelular = $request->telefonocelular;
        $cliente->direccion = $request->direccion;
        $cliente->telefonofijo = $request->telefonofijo;
        $cliente->save();

        return back()->with('success', 'Cliente actualizado');
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
        
        Cliente::findOrFail($request->id)->delete();
        return redirect()->route('clientes')->with('success', 'Cliente eliminado');
    }
}
