<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use DB;
use App\Empresa;

class ReportesController extends Controller
{

    public $reglasValidacionEstado = [
            'empresa_id' => 'nullable',
        ];

    public $reglasValidacionIngresos = [
        'empresa_id' => 'nullable',
        'fechaInicio' => 'nullable',
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
        
        
        $nombrereporte = $this->generarNombreReporteEstado($request);
        $rutapdf = 'reporteEstado.pdf';

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
    
         return view('estados',["registros" => $this->consultarTabla('Estado clientes',$request), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas, "totales" => null]);
    }

    //////////////////////////

     public function reporteIngresos(Request $request){
                
        $this->validarFecha($request);
        $nombrereporte = $this->generarNombreReporteIngresos($request);

        $rutapdf = 'reporteIngresos.pdf';

        $empresas = DB::table('empresas')->select(
            DB::raw('id as Id'),
            DB::raw('nombre as Nombre'))->get();
    
         return view('ingresos',["registros" => $this->consultarTabla('Ingresos',$request), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas , "totales" => $this->consultarTotal($request)]);
    }

    /*
      Reportes PDF
    */

    public function reporteEstadoPdf(Request $request){
		$nombrereporte = $this->generarNombreReporteEstado($request);
        $registros = $this->consultarTabla('Estado clientes',$request);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function reporteIngresosPdf(Request $request){
        $nombrereporte = $this->generarNombreReporteIngresos($request);
        $registros = $this->consultarTabla('Ingresos',$request);

        $pdf = \PDF::loadView('pdf.reporte',compact('registros','nombrereporte'));
        return $pdf->stream('reporte.pdf');
    }

    public function consultarTabla($tipo, $request){

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
                ->join('empresas','empresas.id','=','afiliaciones.empresa_id')->where('afiliaciones.activo',true);

            
            return $this->filtrarEmpresa($consulta,$request)->get();
    

        }elseif(!strcmp($tipo,"Ingresos")){
            $consulta = DB::table('pagos')
                ->select(
                    DB::raw('pagos.id AS "Id de pago"'),
                    DB::raw('clientes.nombre AS "Nombre del cliente"'),
                    DB::raw('servicios.nombre AS "Nombre del servicio"'),
                    DB::raw('empresas.nombre AS "Empresa"'),
                    DB::raw('pagos.created_at AS "Fecha de pago"'),
                    DB::raw('servicios.precio AS "Valor pagado"')
                    )
                ->join('afiliaciones','afiliaciones.id','=','pagos.afiliacion_id')
                ->join('servicios','servicios.id','=','afiliaciones.servicio_id')
                ->join('empresas','empresas.id','=','afiliaciones.empresa_id')
                ->join('clientes','clientes.id','=','afiliaciones.cliente_id')->where('pagos.externo',false);

               
                $this->filtrarEmpresa($consulta,$request);
                return $this->filtrarFechasIngresos($consulta,$request)->get();
            
        }

    }

    public function filtrarFechasIngresos($consulta,$request){
        if($request->fechaInicio != null){
            $consulta = $consulta->where(DB::raw('DATE(pagos.created_at)'),">=",date("Y-m-d",strtotime($request->fechaInicio)));
        }

        if($request->fechaFin !=null){
            $consulta = $consulta->where(DB::raw('DATE(pagos.created_at)'),"<=",date("Y-m-d",strtotime($request->fechaFin)));
        }

        return $consulta;
    }

    public function filtrarEmpresa($consulta,$request){

          if($request->empresa_id != null && $request->empresa_id != "todas"){
            return $consulta->where('afiliaciones.empresa_id',$request->empresa_id);
          }

          return $consulta;

    }

    public function consultarTotal($request){

        $consulta = DB::table('pagos')
        ->select(
                    DB::raw('pagos.id AS "Id de pago"'),
                    DB::raw('pagos.externo AS "Pago externo"'),
                    DB::raw('pagos.created_at AS "Fecha de pago"'),
                    DB::raw('servicios.precio AS "Valor pagado"')
                    )
                ->join('afiliaciones','afiliaciones.id','=','pagos.afiliacion_id')
                ->join('servicios','servicios.id','=','afiliaciones.servicio_id')
                ->where('pagos.externo',0);

        $this->filtrarFechasIngresos($consulta,$request);

        

        return "Total de ingresos $" . $consulta->select(DB::raw('SUM(precio) as Total'))->get()[0]->Total;

    }

    public function validarFecha($request){
        if($request->fechaFin != null && (date("Y-m-d H:i:s",strtotime($request->fechaInicio)) > date("Y-m-d H:i:s",strtotime($request->fechaFin)))){
            throw ValidationException::withMessages(['fechaInicio' => 'La fecha de inicio debe ser anterior a la fecha de fin.']);
        }
    }

    //// Concatenador nombre reportes


    public function generarNombreReporteEstado($request){
        if($request->empresa_id != null && $request->empresa_id != "todas"){
            $request->validate($this->reglasValidacionEstado);
            $empresa = Empresa::find($request->empresa_id);
            return "Estado clientes " . $empresa->nombre;
        }else{
            return "Estado clientes de todas las empresas";
        }
    }

    public function generarNombreReporteIngresos($request){
        $request->validate($this->reglasValidacionIngresos);

        $nombre =  "";

        if($request->empresa_id != null && $request->empresa_id != "todas"){
            $empresa = Empresa::find($request->empresa_id);
            $nombre .= "Ingresos " . $empresa->nombre;
        }else{
            $nombre = "Ingresos de todas las empresas";
        }

        if($request->fechaInicio != null){
            $nombre .= " desde " . $request->fechaInicio;
        }

        if($request->fechaFin != null){
            $nombre .= " hasta " . $request->fechaFin;
        }

        return $nombre;
    }


}
