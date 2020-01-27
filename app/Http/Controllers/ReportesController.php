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
        $request = new Request(array('fechaInicio' => date("Y-m-d")));
        $ingresos = $this->consultarTotal($request,1,1);
        $morosos = $this->consultarTotalMorosos();
        return view('reportes',compact('ingresos','morosos'));
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

        $totales =  array("ingresos" => $this->consultarTotal($request,0,0), "utilidades" => $this->consultarTotal($request,1,0,0));
    
         return view('ingresos',["registros" => $this->consultarTabla('Ingresos',$request), "nombrereporte" => $nombrereporte, "rutapdf" => $rutapdf, "empresas" => $empresas , "totales" => $totales]);
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
        $totales =  array("ingresos" => $this->consultarTotal($request,0,0), "utilidades" => $this->consultarTotal($request,1,0));

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
                    DB::raw('servicios.costo AS "Costo servicio"'),
                    DB::raw('servicios.precio AS "Valor pagado"'),
                    DB::raw('servicios.precio - servicios.costo AS "Utilidad"')
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

    public function consultarTotal($request,$opcion,$tipo){

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

        if($request!=null){
            $this->filtrarEmpresa($consulta,$request);
            $this->filtrarFechasIngresos($consulta,$request);
        }
        


       

        if($opcion == 0){
            $valor = $consulta->select(DB::raw('SUM(precio) as Total'))->get()[0]->Total;
            if($valor != null && $valor > 0){
                $respuesta = "Total de ingresos $" . ReportesController::moneyFormat($valor,'COP') ;
            }else{
                $respuesta =  "No se registraron ingresos";
            }
        }elseif($opcion == 1){
            $valor = $consulta->select(DB::raw('SUM(precio) - SUM(costo) as Total'))->get()[0]->Total;
            if($valor != null && $valor > 0){
                $respuesta = "Total de utilidades $" . ReportesController::moneyFormat($valor,'COP') ;
            }else{
                $respuesta = "No se registraron utilidades";
            }
        }

        if($tipo == 1){
            return ReportesController::moneyFormat($valor,'COP');
        }

        return $respuesta;
        

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
            return "estado clientes " . $empresa->nombre;
        }else{
            return "estado clientes de todas las empresas";
        }
    }

    public function generarNombreReporteIngresos($request){
        $request->validate($this->reglasValidacionIngresos);

        $nombre =  "";

        if($request->empresa_id != null && $request->empresa_id != "todas"){
            $empresa = Empresa::find($request->empresa_id);
            $nombre .= "ingresos " . $empresa->nombre;
        }else{
            $nombre = "ingresos de todas las empresas";
        }

        if($request->fechaInicio != null){
            $nombre .= " desde " . $request->fechaInicio;
        }

        if($request->fechaFin != null){
            $nombre .= " hasta " . $request->fechaFin;
        }

        return $nombre;
    }

    public function consultarTotalMorosos(){
        $consulta = DB::table('clientes')
                ->select(
                    DB::raw('count(*) as Total'))
                ->join('afiliaciones','afiliaciones.cliente_id','=','clientes.id')
                ->join('servicios','servicios.id','=','afiliaciones.servicio_id')
                ->where('afiliaciones.activo',true)
                ->where('afiliaciones.fechaSiguientePago',"<",date("Y-m-d"));

        return $consulta->get()[0]->Total;

    }

    public static function moneyFormat($price,$curr) {
        $currencies['EUR'] = array(2, ',', '.');        // Euro
        $currencies['ESP'] = array(2, ',', '.');        // Euro
        $currencies['USD'] = array(2, '.', ',');        // US Dollar
        $currencies['COP'] = array(0, ',', '.');        // Colombian Peso
        $currencies['CLP'] = array(0,  '', '.');        // Chilean Peso

        return number_format($price, ...$currencies[$curr]);
}


}
