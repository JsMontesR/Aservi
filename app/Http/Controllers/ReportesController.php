<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use DB;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reportes');
    }

    public function reporteEstado(){
    	$nombrereporte = "Estado clientes";
        $rutapdf = 'reporteEstado.pdf';

         return view('reporteweb',["registros" => $this->consultar($nombrereporte), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf]);
    }

    public function reporteEstadoPdf(){
		$nombrereporte = "Estado clientes";
        $registros = $this->consultar($nombrereporte);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function consultar($tipo){

        if(!strcmp($tipo,"Estado clientes")){
            
         return DB::table('clientes')
                    ->select(
                    	DB::raw('clientes.di AS Cédula'),
                    	DB::raw('clientes.nombre AS "Nombre del cliente"'),
						DB::raw('servicios.nombre AS "Nombre del servicio"'),
						DB::raw('afiliaciones.fechaSiguientePago AS "Fecha límite de pago"'),
						DB::raw('IF(afiliaciones.fechaSiguientePago IS NULL,
						"Sin pagos registrados",
						IF((DATE_FORMAT(afiliaciones.fechaSiguientePago,"%Y-%m-%d 00:00:00") < DATE_FORMAT(NOW(),"%Y-%m-%d 00:00:00")),
						CONCAT("En mora por ", DATEDIFF(CURDATE(), afiliaciones.fechaSiguientePago), " días"),"Al día")) AS Estado'))
                    ->join('afiliaciones','afiliaciones.cliente_id','=','clientes.id')
                    ->join('servicios','servicios.id','=','afiliaciones.servicio_id')->get();

        }

    }


}
