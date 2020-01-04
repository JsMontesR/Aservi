<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Servicio;
use DB;

class ServiciosController extends Controller
{
    public $validationRules = [
            'nombre' => 'required',
            'periodicidad' => 'required',
        ];

    public $validationIdRule = ['id' => 'required|integer|min:0'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $servicios = DB::table('servicios')->select(
        DB::raw('id as Id'),
        DB::raw('nombre as Nombre'),
        DB::raw('periodicidad as Periodicidad'))
       ->get();

        return view('servicios',compact('servicios'));
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

        $servicio = new Servicio;
        $servicio->nombre = $request->nombre;
        $servicio->periodicidad = $request->periodicidad;
        $servicio->save();

        return redirect()->route('servicios')->with('success', 'Servicio registrado');
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
        
        $servicio = Servicio::findOrFail($request->id);
        $servicio->nombre = $request->nombre;
        $servicio->periodicidad = $request->periodicidad;
        $servicio->save();

        return back()->with('success', 'Servicio actualizado');
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
        
        Servicio::findOrFail($request->id)->delete();
        return redirect()->route('servicios')->with('success', 'Servicio eliminado');
    }
}
