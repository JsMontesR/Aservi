<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use DB;
use App\Empresa;

class ReportesController extends Controller
{

    public $reglasValidacionEstado = [
            'empresa_id' => 'required|integer|min:0',
        ];

    public $reglasValidacionIngresos = [
        'empresa_id' => 'required|integer|min:0',
        'fechaInicio' => 'required',
        'fechaFin' => 'nullable|before_or_equal:today',
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

    /*
      Reportes Web
    */

    public function reporteEstado(Request $request){
        

        
        $nombrereporte = generarNombreReporteEstado($request);
        $rutapdf = 'reporteEstado.pdf';

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
    
         return view('estados',["registros" => $this->consultarTabla('Estado clientes',$request->empresa_id), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas]);
    }

    //////////////

     public function reporteIngresos(Request $request){
                
        $this->validarFecha($request);
        $nombrereporte = generarNombreReporteIngresos($request);

        $rutapdf = 'reporteIngresos.pdf';

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
    
         return view('ingresos',["registros" => $this->consultarTabla('Ingresos',array("fechaInicio" => $request->fechaInicio, "fechaFin" => $request->fechaFin,)), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas]);
    }

    /*
      Reportes PDF
    */

    public function reporteEstadoPdf(Request $request){
		$nombrereporte = generarNombreReporteEstado($request);
        $registros = $this->consultarTabla('Estado clientes',$request->empresa_id);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function reporteIngresosPdf(Request $request){
        $nombrereporte = generarNombreReporteIngresos($request);
        $registros = $this->consultarTabla('Estado clientes',$request->empresa_id);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function consultarTabla($tipo, $filtro){

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
         

        }elseif(!strcmp($tipo,"Ingresos")){
            $consulta = DB::table('pagos')
                ->select(
                    DB::raw('pagos.id AS "Id de pago"'),
                    DB::raw('clientes.nombre AS "Nombre del cliente"'),
                    DB::raw('servicios.nombre AS "Nombre del servicio"'),
                    DB::raw('empresas.nombre AS "Empresa"'),
                    DB::raw('pagos.created_at AS "Fecha de pago"'),
                    DB::raw('pagos.monto AS "Valor pagado"')
                    )
                ->join('afiliaciones','afiliaciones.id','=','pagos.afiliacion_id')
                ->join('servicios','servicios.id','=','afiliaciones.servicio_id')
                ->join('empresas','empresas.id','=','afiliaciones.empresa_id')
                ->join('clientes','clientes.id','=','afiliaciones.cliente_id');
            if($filtro != null){

                if($filtro["fechaInicio"]!=null){
                    $consulta = $consulta->where('pagos.created_at',">=",date("Y-m-d H:i:s",$filtro["fechaInicio"]));
                }

                elseif($filtro["fechaFin"]!=null){

                    $consulta = $consulta->where('pagos.created_at',"<=",date("Y-m-d H:i:s",$filtro["fechaFin"]))->get();

                }
                
            }
                return $consulta->get();
            
        }

    }

    public function consultarTotal($request){
        
    }

    public function validarFecha($request){
        if($request->fechaFin != null && (date("Y-m-d H:i:s",$request->fechaInicio) > date("Y-m-d H:i:s",$request->fechaFin))){
            throw ValidationException::withMessages(['fechaInicio' => 'La fecha de inicio debe ser anterior a la fecha de fin.']);
        }
    }

    //// Concatenador nombre reportes


    public function generarNombreReporteEstado($request){
        if($request->empresa_id != null){
            $request->validate($this->reglasValidacionEstado);
            $empresa = Empresa::find($request->empresa_id);
            return "Estado clientes " . $empresa->nombre;
        }else{
            return "Estado clientes";
        }
    }

    public function generarNombreReporteIngresos($request){
        if($request->empresa_id != null){
            $request->validate($this->reglasValidacionEstado);
            $empresa = Empresa::find($request->empresa_id);
            return "Ingresos " . $empresa->nombre;
        }else{
            return "Ingresos";
        }
    }


}
