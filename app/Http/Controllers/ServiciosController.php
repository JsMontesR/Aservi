<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Servicio;
use DB;

class ServiciosController extends Controller
{
    public $validationRules = [
            'nombre' => 'required',
            'periodicidad' => 'required',
            'costo' => 'required|integer|lt:precio',
            'precio' => 'required|integer|min:0',
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
        DB::raw('periodicidad as Periodicidad'),
        DB::raw('costo as Costo'),
        DB::raw('precio as Precio'),
        DB::raw('precio - costo as Utilidad')
    )
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
        $servicio->costo = $request->costo;
        $servicio->precio = $request->precio;
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
        $servicio->costo = $request->costo;
        $servicio->precio = $request->precio;
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
        try {
            Servicio::findOrFail($request->id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw ValidationException::withMessages(['id' => 'El servicio no puede ser eliminado ya que aún existen afiliaciones que hacen uso de él',]);
        }    
       
        return redirect()->route('servicios')->with('success', 'Servicio eliminado');
    }
}
