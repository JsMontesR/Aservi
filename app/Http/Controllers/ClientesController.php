<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Cliente;

class ClientesController extends Controller
{
    public $validationRules = [
            'name' => 'required',
            'email' => 'required_if:rol,administrador|nullable|email',
            'cedula' => 'required|integer|min:0',
            'telefonocelular' => 'nullable|integer|min:0',
            'telefonofijo' => 'nullable|integer|min:0',
        ];

    public $validationIdRule = ['id' => 'required|integer|min:0'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $clientes = DB::table('clientes')->select(
        DB::raw('id as Id'),
        DB::raw('di as Cedula'),
        DB::raw('nombre as Nombre'),
        DB::raw('email as "Email"'),
        DB::raw('telefonocelular as "Telefono Celular"'),
        DB::raw('telefonofijo as "Telefono Fijo"'),
        DB::raw('direccion as Direccion'))
       ->get();

        return view('clientes',compact('clientes'));
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
        try {
            Cliente::findOrFail($request->id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            throw ValidationException::withMessages(['id' => 'El cliente no puede ser eliminado ya que existen afiliaciones a su nombre',]);
        }    
        return redirect()->route('clientes')->with('success', 'Cliente eliminado');
    }
}
