<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use DB;
use App\Empresa;

class ReportesController extends Controller
{

    public $validationRules = [
            'empresa_id' => 'required|integer|min:0',
        ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes');
    }

    public function reporteEstado(Request $request){

        $request->session()->reflash();
                
        $nombrereporte = $this->nombreReporte($request);
        $rutapdf = 'reporteEstado.pdf';

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
        
        $request->session()->flash('',$request->empresa_id);
    
         return view('reporteweb',["registros" => $this->consultar('Estado clientes',$request->empresa_id), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas]);
    }

    public function nombreReporte($request){
        if($request->empresa_id != null){
            $request->validate($this->validationRules);
            $empresa = Empresa::find($request->empresa_id);
             return "Estado clientes " . $empresa->nombre;
        }else{
            return "Estado clientes";
        }
    }

    public function reporteEstadoPdf(Request $request){
		$nombrereporte = $this->nombreReporte($request);
        $registros = $this->consultar('Estado clientes',$request->empresa_id);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function consultar($tipo, $filtro){

        if(!strcmp($tipo,"Estado clientes")){
            $consulta = DB::table('clientes')
                ->select(
                    DB::raw('clientes.di AS Cédula'),
                    DB::raw('clientes.nombre AS "Nombre del cliente"'),
                    DB::raw('servicios.nombre AS "Nombre del servicio"'),
                    DB::raw('empresas.nombre AS "Empresa"'),
                    DB::raw('afiliaciones.fechaSiguientePago AS "Fecha límite de pago"'),
                    DB::raw('IF(afiliaciones.fechaSiguientePago IS NULL,
                    "Sin pagos registrados",
                    IF((DATE_FORMAT(afiliaciones.fechaSiguientePago,"%Y-%m-%d 00:00:00") < DATE_FORMAT(NOW(),"%Y-%m-%d 00:00:00")),
                    CONCAT("En mora por ", DATEDIFF(CURDATE(), afiliaciones.fechaSiguientePago), " días"),"Al día")) AS Estado'))
                ->join('afiliaciones','afiliaciones.cliente_id','=','clientes.id')
                ->join('servicios','servicios.id','=','afiliaciones.servicio_id')
                ->join('empresas','empresas.id','=','afiliaciones.empresa_id');
            if($filtro != null){
                return $consulta->where('afiliaciones.empresa_id',$filtro)->get();
            }else{
                return $consulta->get();
            }
         

        }

    }


}
