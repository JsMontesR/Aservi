<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Pago;
use DB;
use \Datetime;

class PagosController extends Controller
{
    public $validationRules = [
            'afiliacion_id' => 'required|integer|min:0',
            'tipoPago' => 'required',

        ];

    public $validationIdRule = ['id' => 'required|integer|min:0'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $pagos = DB::table('pagos')->select(
        DB::raw('pagos.id as Id'),
        DB::raw('afiliaciones.id as "Id afiliacion"'),
        DB::raw('clientes.nombre as "Nombre cliente"'),
        DB::raw('clientes.di as Cedula'),
        DB::raw('servicios.nombre as "Nombre servicio"'),
        DB::raw('pagos.tipoPago as "Medio pago"'),
        DB::raw('IF(pagos.externo = 1,"Si", "No") as "Pago externo"'),
        DB::raw('IF(pagos.externo = 1, 0, servicios.precio) as "Valor pagado"'),
        DB::raw('servicios.precio as "Precio"'),
        DB::raw('pagos.created_at as "Fecha de pago"'),
        DB::raw('pagos.fechaValidez as "Pago valido hasta"')
    )
       ->join('afiliaciones','afiliaciones.id','=','pagos.afiliacion_id')
       ->join('clientes', 'clientes.id', '=', 'afiliaciones.cliente_id')
       ->join('servicios', 'servicios.id', '=', 'afiliaciones.servicio_id')
       ->get();

        $afiliaciones = DB::table('afiliaciones')->select(
            DB::raw('afiliaciones.id as Id'),
            DB::raw('clientes.nombre as "Nombre del cliente"'),
            DB::raw('clientes.di as Cedula'),
            DB::raw('servicios.id as "Id del servicio"'),
            DB::raw('servicios.nombre as "Nombre del servicio"'),
            DB::raw('afiliaciones.fechaSiguientePago as "Fecha de siguiente pago"'),
            DB::raw('servicios.precio as "Valor a pagar"'))
        ->join('clientes', 'clientes.id', '=', 'afiliaciones.cliente_id')
        ->join('servicios', 'servicios.id', '=', 'afiliaciones.servicio_id')->where('afiliaciones.activo',1)
        ->get();
        

        return view('pagos',compact('pagos','afiliaciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $opcion = null)
    {   

        $request->validate($this->validationRules);

        $pago = new Pago;
        $pago->afiliacion_id = $request->afiliacion_id;
        $pago->tipoPago = $request->tipoPago;
        $pago->user_id = auth()->id();
        $pago->externo = $request->has('externo'); 
        
        $this->calcularProximoPago($pago->afiliacion);
        $pago->fechaValidez = $pago->afiliacion->fechaSiguientePago;
        $pago->save();
        if($opcion == null){
            return back()->with('success', 'Pago registrado'); 
        }else{
            $request["id"] = $pago->id;
            return $request;
        }
    }

    public function storeAndPrint(Request $request){
        return $this->print($this->store($request,"storeprint"));
    }

    public function calcularProximoPago($afiliacion){
        $nuevaFechaProximoPago = null;
        $diasPlazoPago = 5;
        $fecha = $afiliacion->fechaSiguientePago;

        if($fecha == null){
            $fecha = (new DateTime())->format('Y-m-d H:i:s');
        }

        $fecha = (new DateTime())->setDate(date("Y",strtotime($fecha)), date("m",strtotime($fecha)), $diasPlazoPago);

        $periodicidad = $afiliacion->servicio->periodicidad;
        if($periodicidad === "Mensual"){
            $nuevaFechaProximoPago = date("Y-m-d H:i:s",strtotime($fecha->format('Y-m-d')."+ 1 month"));
        }
        elseif($periodicidad === "Trimestral"){
            $nuevaFechaProximoPago = date("Y-m-d H:i:s",strtotime($fecha->format('Y-m-d')."+ 3 month"));
        }
        elseif($periodicidad === "Semestral"){
            $nuevaFechaProximoPago = date("Y-m-d H:i:s",strtotime($fecha->format('Y-m-d')."+ 6 month"));
        }
        elseif($periodicidad === "Anual"){
            $nuevaFechaProximoPago = date("Y-m-d H:i:s",strtotime($fecha->format('Y-m-d')."+ 12 month"));
        }

        $afiliacion->fechaSiguientePago = (new DateTime())->setDate(date("Y",strtotime($nuevaFechaProximoPago)), date("m",strtotime($nuevaFechaProximoPago)), $diasPlazoPago);
        $afiliacion->save();
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

        $pago = Pago::findOrFail($request->id);
        $pago->afiliacion_id = $request->afiliacion_id;
        $pago->tipoPago = $request->tipoPago;
        $pago->externo = $request->has('externo');
        $pago->save();

        return back()->with('success', 'Pago actualizado');
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
        
        Pago::findOrFail($request->id)->delete();
        return back()->with('success', 'Pago eliminado');
    }

    /**
     * Imprime un recibo
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request){
        $request->validate($this->validationIdRule);
        $nombre = "Asesoría en seguridad social";
        $fijo = "Teléfono: 2190753";
        $celular = "Celular: 310 544 9295";
        $fechaActual = (new DateTime())->format('d-m-Y');
        $horaActual = (new DateTime())->format('h:i:s');

        $pago = Pago::find($request->id);

        $numeroRecibo = $pago->id;
        $usuario = $pago->user->name;
        $tipoPago = $pago->tipoPago;
        $cc = $pago->afiliacion->cliente->di;
        $nombreCliente = $pago->afiliacion->cliente->nombre;
        $direccion = $pago->afiliacion->cliente->direccion;
        $telefono = $pago->afiliacion->cliente->telefonocelular;
        $email = $pago->afiliacion->cliente->email;
        $producto = $pago->afiliacion->servicio->nombre;
        $valor = $pago->afiliacion->servicio->precio;
        $fechaValidez =  $pago->fechaValidez;

        
        $pdf = \PDF::loadView('pdf.recibo',compact('nombre','fijo','celular','fechaActual','horaActual','numeroRecibo','usuario','tipoPago','cc','nombreCliente','direccion','telefono','email','producto','valor','fechaValidez'));
        return $pdf->stream('recibo.pdf');
    }
}
