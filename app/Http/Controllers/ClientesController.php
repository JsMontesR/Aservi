<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public $validationRules = [
            'name' => 'required',
            'email' => 'required_if:rol,administrador|nullable|email',
            'cedula' => 'nullable|integer|min:0',
            'telefono' => 'nullable|integer|min:0',
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
        DB::raw('email as "Email"'),
        DB::raw('nombre as Nombre'),
        DB::raw('telefonocelular as Telefono'),
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

        $usuario = new User;
        $usuario->name = $request->name;
        if($request->email != null && DB::table('users')->where('email', '=', $request->email)->exists()){
            throw ValidationException::withMessages(['email' => 'El email ingresado ya existe',]);
        }
        $usuario->email = $request->email;
        $usuario->cedula = $request->cedula;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $this->validarYGuardarNIT($request,$usuario);
        if($request->password != null){
            $usuario->password = Hash::make($request->password);
        }
        $usuario->rol = $request->rol;
        $usuario->save();

        return redirect()->route('usuarios')->with('success', 'Usuario registrado');
    }

    public function validarYGuardarNIT(Request $request, User $usuario){
        $NITvalidator = Validator::make($request->all(), ['NIT' => 'nullable|regex:/(?<![\w\d])[0-9]+-[0-9]+(?![\w\d])/']);
        
        if ($NITvalidator->fails()) {
            throw ValidationException::withMessages(['NIT' => 'El NIT ingresado es incorrecto',]);
        }else{       
            $usuario->NIT = $request->NIT;
        }
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
        
        $usuario = User::findOrFail($request->id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->cedula = $request->cedula;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $this->validarYGuardarNIT($request,$usuario);
        if($request->password != null){
            $usuario->password = Hash::make($request->password);
        }
        $usuario->rol = $request->rol;
        $usuario->save();

        return back()->with('success', 'Usuario actualizado');
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
        
        User::findOrFail($request->id)->delete();
        return redirect()->route('usuarios')->with('success', 'Usuario eliminado');
    }
}
