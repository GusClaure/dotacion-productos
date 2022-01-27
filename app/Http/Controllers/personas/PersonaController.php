<?php

namespace App\Http\Controllers\personas;

use File;
use ZipArchive;
use App\Models\Persona;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\EntregaProducto;
use App\Models\RegistroEntrega;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use EntregasProductos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PersonaController extends Controller{


    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['saveNewRegister']]);
    }



    public function getAllRegisterPerson(){

		$productos = Producto::select('id', 'nombre_producto')
				     ->where(['status' => 1])->get();
        return view('personas.personas', ['data_count' => Persona::getAllCountData(), 'productos' =>$productos]);
    }


	public function personFilter(Request $request){
	//$request->criterio
	$registro = '';
	if($request->criterio == 'total'){
		$registro = Persona::select('ci','descripcion','distrito','expedido',
							'nombre','nombre_rubro',
							'nro_cel','nro_formulario','observacion','observacion','segundo_ap',
							'sindicato','sub_central','tipo', 'ubicacion', 'registros_entregas.status')
							->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
							->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
							->get();
	
	}else if($request->criterio == 'entregados'){
		$registro = Persona::select('ci','descripcion','distrito','expedido',
							'nombre','nombre_rubro',
							'nro_cel','nro_formulario','observacion','observacion','segundo_ap',
							'sindicato','sub_central','tipo', 'ubicacion', 'registros_entregas.status')
							->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
							->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
							->where(['registros_entregas.status' => 'ENTREGADO'])
							->get();
	}else if($request->criterio == 'pendientes'){

		$registro = Persona::select('ci','descripcion','distrito','expedido',
							'nombre','nombre_rubro',
							'nro_cel','nro_formulario','observacion','observacion','segundo_ap',
							'sindicato','sub_central','tipo', 'ubicacion', 'registros_entregas.status')
							->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
							->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
							->whereNull('registros_entregas.status')
							->get();

	}else if($request->criterio == 'pendientes_productos'){
		$registro = Persona::select('ci','descripcion','distrito','expedido',
							'nombre','nombre_rubro',
							'nro_cel','nro_formulario','observacion','observacion','segundo_ap',
							'sindicato','sub_central','tipo', 'ubicacion', 'registros_entregas.status')
							->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
							->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
							->where(['registros_entregas.status' => 'PENDIENTE-PRODUCTO'])
							->get();
	}
	
	
	
	return response([
		'status'=> true,
		'response'=> $registro
	 ],200);


	}

    public function GetAllRegisterDatatable(Request $request){

        
        $registros = Persona::select('personas.*', 'registros_entregas.status')
		->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
        ->where(DB::raw('nro_formulario::text'), 'like', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->orWhere(DB::raw('nro_cel::text'), 'like', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('nombre', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('primer_ap', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('segundo_ap', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('expedido', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('distrito', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('sub_central', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('sindicato', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('tipo', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->skip($request->start)
        ->take($request->length)
        ->orderBy('nombre', 'asc')
        ->get();

        $count = Persona::leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		->where(DB::raw('nro_formulario::text'), 'like', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->orWhere(DB::raw('nro_cel::text'), 'like', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('nombre', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('primer_ap', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('segundo_ap', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('expedido', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('distrito', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('sub_central', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('sindicato', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
		->orWhere('tipo', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->count();



        $draw = $request->draw;
        return response([
                     'draw' =>  $draw,
                     'recordsTotal' => $count,
                     'recordsFiltered' => $count,
                     'data' => $registros
                 ],200);

    }



	public function getDetalleEntrega(Request $request){

		$registro = Persona::select()
					->leftJoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
					->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		            ->where(['personas.id' => $request->id])
					->first();

		$productos = Producto::select('id','nombre_producto')
					->where(['status' => 1])->get();

		if($registro){

			return response([
				'status'=> true,
				'response'=> $registro,
				'productos' => $productos
			 ],200);

		}else{
			return response([
				'status'=> false,
				'message'=> 'No se encontro resultados!'
			 ],404);
		}
	}




	public function updateEntregaProducto(Request $request){
		$this->validate($request, [
			'id_persona' => 'required'
		], [
			'required' => ':attribute es requerido!'
		]);		

		return 'dwada';
	}


	public function exporCsv(){

		     $fileName_csv_registro_entradas = 'export_user_'.Auth::id().'_table_registro_entregas_'.date('Y_m_d').'.csv';
			 $fileName_csv_entregas_producto = 'export_user_'.Auth::id().'_table_entregas_producto_'.date('Y_m_d').'.csv';
			 $fileName_zip = 'export_user_'.Auth::id().'_'.date('Y_m_d').'.zip';
			

			 if($this->generateCSVTableRegistroEntradas($fileName_csv_registro_entradas) && $this->generateCSVTableEntregasProducto($fileName_csv_entregas_producto)){
				return 'si';
			 }else{
				return 'no';
			 }


	    //codigo para generar .zip con password
		$zip = new ZipArchive;
        if ($zip->open(public_path('export/').$fileName_zip, ZipArchive::CREATE) === TRUE)
        {
            $files = File::files(public_path('archives_csv'));
			//public_path('export/')
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
				$zip->addFromString($relativeNameInZipFile, 'file content goes here'); //Add your file name
			    $zip->setEncryptionName($relativeNameInZipFile, ZipArchive::EM_AES_256, 'admin123'); //Add file name and password dynamically
                $zip->addFile($value, $relativeNameInZipFile);
            }
			
            $zip->close();
        }
        return response()->download(public_path('export/').$fileName_zip);
    	 
	}



	private function generateCSVTableRegistroEntradas($fileName_csv){

		$registro_entregas = RegistroEntrega::all();
		$columns = ['id', 'uuid', 'id_persona', 'observacion', 'fecha_registro', 'status'];
		$delimiter = ';';
		$callback = function() use($registro_entregas, $columns, $fileName_csv, $delimiter) {
			$file = fopen(public_path('archives_csv/').$fileName_csv, 'w');
			//$file = fopen('php://temp', 'r+');
			fputcsv($file, $columns);

			foreach ($registro_entregas as $value) {
				$row['id']  = $value->id;
			    $row['uuid'] = $value->uuid;
			    $row['id_persona'] = $value->id_persona;
			    $row['observacion'] = $value->observacion;
			    $row['fecha_registro'] = $value->fecha_registro;
				$row['status'] = $value->status;
				fputcsv($file, $row, $delimiter);
			}
			fclose($file);
		};
		
	  return (new StreamedResponse($callback))->sendContent();
	   
	}


	private function generateCSVTableEntregasProducto($fileName_csv){
		$registro_entregas = EntregaProducto::all();
		$columns = ['id', 'id_usuario', 'id_registro', 'id_producto', 'fecha_entrega', 'fecha_anulacion', 'usuario_anulo', 'status'];
		$delimiter = ';';
		$callback = function() use($registro_entregas, $columns, $fileName_csv, $delimiter) {
			$file = fopen(public_path('archives_csv/').$fileName_csv, 'w');
			//$file = fopen('php://temp', 'r+');
			fputcsv($file, $columns);

			foreach ($registro_entregas as $value) {
				$row['id']  = $value->id;
			    $row['id_usuario'] = $value->id_usuario;
			    $row['id_registro'] = $value->id_registro;
			    $row['id_producto'] = $value->id_producto;
			    $row['fecha_entrega'] = $value->fecha_entrega;
				$row['fecha_anulacion'] = $value->fecha_anulacion;
				$row['usuario_anulo'] = $value->fecha_anulacion;
				$row['status'] = $value->status;
				fputcsv($file, $row, $delimiter);
			}
			fclose($file);
		};
		
	  return (new StreamedResponse($callback))->sendContent();
	}



    public function saveNewRegister(Request $request){

        // return response([
        //     'status'=> false,
        //     'message'=> 'Error 401 (Unauthorized)'
        //  ],401);

        //return $this->utm2ll(798223,8071262,19,false);


        $valid = Validator::make($request->all(), [
            'num_formulario' => 'required',
            'nombres' => 'required',
            'primer_ap' => 'required',
            'carnet' => 'required',
            'expedido' => 'required',
            'distrito' => 'required',
            'sud_central' => 'required',
            'sindicato' => 'required',
            'x_coord' => 'required',
            'y_coord' => 'required'
        ]);
        
        if ($valid->fails()) {
            return response()->json(
                ['error' => $valid->errors()],
                422
            );
        }

        $person = Persona::where(['ci' => trim($request->carnet)])->first();
        
        if($person){
         return response([
            'status'=> false,
            'message'=> 'El ciudadano con el CI: '.$person->ci.' ya se encuentra registrado!'
         ],422);
        }

        $categoria = '';
        $type = '';
        if(trim($request->ganaderia) != '' || trim($request->ganaderia) != null){
           $id = DB::table('rubros')->select('id')->where('nombre_rubro', 'ilike', '%Ganaderia%')->first();
           $categoria = $id->id;
           $type = trim($request->ganaderia);
        }else if(trim($request->flores) != '' || trim($request->flores) != null){
            $id = DB::table('rubros')->select('id')->where('nombre_rubro', 'ilike', '%Flores%')->first();
            $categoria = $id->id;
            $type = trim($request->flores);
        }else if(trim($request->hortalizas) != '' || trim($request->hortalizas) != null){
            $id = DB::table('rubros')->select('id')->where('nombre_rubro', 'ilike', '%Hortalizas%')->first();
            $categoria = $id->id;
            $type = trim($request->hortalizas);
        }else if(trim($request->animales) != '' || trim($request->animales) != null){
            $id = DB::table('rubros')->select('id')->where('nombre_rubro', 'ilike', '%Animales Menores%')->first();
            $categoria = $id->id;
            $type = trim($request->animales);
        }else if(trim($request->forraje) != '' || trim($request->forraje) != null){
            $id = DB::table('rubros')->select('id')->where('nombre_rubro', 'ilike', '%Forraje%')->first();
            $categoria = $id->id;
            $type = trim($request->forraje);
        }else{
            return response([
                'status'=> false,
                'message'=> 'El registro no tiene ningun dato en rubros'
             ],422);
        }

        $num_cel = 0;
        if(is_numeric(trim($request->num_cel))){
            $num_cel = trim($request->num_cel);
        }

       $ubicacion = $this->utm2ll(trim($request->x_coord),trim($request->y_coord),19,false);
        
        $people = new Persona;
        $people->nro_formulario = trim($request->num_formulario);
        $people->nro_cel = $num_cel;
        $people->nombre = trim($request->nombres);
        $people->primer_ap = trim($request->primer_ap);
        $people->segundo_ap = trim($request->segundo_ap);
        $people->ci = trim($request->carnet);
        $people->expedido = trim($request->expedido);
        $people->distrito = trim($request->distrito);
        $people->sub_central = trim($request->sud_central);
        $people->sindicato = trim($request->sindicato);
        $people->rubro_id = $categoria;
        $people->tipo = $type;
        $people->ubicacion = $ubicacion;

        if($people->save()){
            return response([
                'status'=> true,
                'message'=> 'Registro realizado con exito!'
             ],201);
        }else{
            return response([
                'status'=> false,
                'message'=> 'Ocurrio un error al registrar los datos!'
             ],500);
        }

    }

    //fuction convert UTM to Lat and Long
	function utm2ll($x,$y,$zone,$aboveEquator){
		if(!is_numeric($x) or !is_numeric($y) or !is_numeric($zone)){
			return json_encode(array('success'=>false,'msg'=>"Wrong input parameters"));
		}
		$southhemi = false;
		if($aboveEquator!=true){
			$southhemi = true;
		}
		$latlon = $this->UTMXYToLatLon ($x, $y, $zone, $southhemi);

        return  $this->radian2degree($latlon[0]).','. $this->radian2degree($latlon[1]);
		//return json_encode(array('success'=>true,'attr'=>array('lat'=>$this->radian2degree($latlon[0]),'lon'=> $this->radian2degree($latlon[1]))));
	}

	function ll2utm($lat,$lon){
		if(!is_numeric($lon)){
			return json_encode(array('success'=>false,'msg'=>"Wrong longitude value"));
		}
		if($lon<-180.0 or $lon>=180.0){
			return json_encode(array('success'=>false,'msg'=>"The longitude is out of range"));
		}
		if(!is_numeric($lat)){
			return json_encode(array('success'=>false,'msg'=>"Wrong latitude value"));
		}
		if($lat<-90.0 or $lat>90.0){
			return json_encode(array('success'=>false,'msg'=>"The longitude is out of range"));
		}
		$zone = floor(($lon + 180.0) / 6) + 1;
		//compute values
		$result = $this->LatLonToUTMXY($this->degree2radian($lat),$this->degree2radian($lon),$zone);
		$aboveEquator = false;
		if($lat >0){
			$aboveEquator = true;
		}
		return json_encode(array('success'=>true,'attr'=>array('x'=>$result[0],'y'=>$result[1],'zone'=>$zone,'aboveEquator'=>$aboveEquator)));
	}

	function radian2degree($rad){
		$pi = 3.14159265358979;	
        	return ($rad / $pi * 180.0);
	}

	function degree2radian($deg){
		$pi = 3.14159265358979;
		return ($deg/180.0*$pi);
	}

	function UTMCentralMeridian($zone){
		$cmeridian = $this->degree2radian(-183.0 + ($zone * 6.0));
		return $cmeridian;
	}
	function LatLonToUTMXY ($lat, $lon, $zone){
	        $xy = $this->MapLatLonToXY ($lat, $lon, $this->UTMCentralMeridian($zone));
		/* Adjust easting and northing for UTM system. */
		$UTMScaleFactor = 0.9996;
	        $xy[0] = $xy[0] * $UTMScaleFactor + 500000.0;
	        $xy[1] = $xy[1] * $UTMScaleFactor;
	        if ($xy[1] < 0.0)
        	    $xy[1] = $xy[1] + 10000000.0;
	        return $xy;
	}
	function UTMXYToLatLon ($x, $y, $zone, $southhemi){
		$latlon = array();
		$UTMScaleFactor = 0.9996;
        	$x -= 500000.0;
	        $x /= $UTMScaleFactor;
        	/* If in southern hemisphere, adjust y accordingly. */
	        if ($southhemi)
        		$y -= 10000000.0;
        	$y /= $UTMScaleFactor;
	        $cmeridian = $this->UTMCentralMeridian ($zone);
        	$latlon = $this->MapXYToLatLon ($x, $y, $cmeridian);	
        	return $latlon;
	}
	function MapXYToLatLon ($x, $y, $lambda0){
		$philambda = array();
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
	        $phif = $this->FootpointLatitude ($y);
	        $ep2 = (pow ($sm_a, 2.0) - pow ($sm_b, 2.0)) / pow ($sm_b, 2.0);
	        $cf = cos ($phif);
	        $nuf2 = $ep2 * pow ($cf, 2.0);
	        $Nf = pow ($sm_a, 2.0) / ($sm_b * sqrt (1 + $nuf2));
        	$Nfpow = $Nf;
	        $tf = tan ($phif);
	        $tf2 = $tf * $tf;
	        $tf4 = $tf2 * $tf2;
        	$x1frac = 1.0 / ($Nfpow * $cf);
	        $Nfpow *= $Nf;   
        	$x2frac = $tf / (2.0 * $Nfpow);
	        $Nfpow *= $Nf;   
        	$x3frac = 1.0 / (6.0 * $Nfpow * $cf);
	        $Nfpow *= $Nf;   
        	$x4frac = $tf / (24.0 * $Nfpow);
	        $Nfpow *= $Nf;   
        	$x5frac = 1.0 / (120.0 * $Nfpow * $cf);
	        $Nfpow *= $Nf;   
	        $x6frac = $tf / (720.0 * $Nfpow);
        	$Nfpow *= $Nf;   
	        $x7frac = 1.0 / (5040.0 * $Nfpow * $cf);
        	$Nfpow *= $Nf;   
	        $x8frac = $tf / (40320.0 * $Nfpow);
        	$x2poly = -1.0 - $nuf2;
	        $x3poly = -1.0 - 2 * $tf2 - $nuf2;
        	$x4poly = 5.0 + 3.0 * $tf2 + 6.0 * $nuf2 - 6.0 * $tf2 * $nuf2- 3.0 * ($nuf2 *$nuf2) - 9.0 * $tf2 * ($nuf2 * $nuf2);
	        $x5poly = 5.0 + 28.0 * $tf2 + 24.0 * $tf4 + 6.0 * $nuf2 + 8.0 * $tf2 * $nuf2;
	        $x6poly = -61.0 - 90.0 * $tf2 - 45.0 * $tf4 - 107.0 * $nuf2	+ 162.0 * $tf2 * $nuf2;
	        $x7poly = -61.0 - 662.0 * $tf2 - 1320.0 * $tf4 - 720.0 * ($tf4 * $tf2);
	        $x8poly = 1385.0 + 3633.0 * $tf2 + 4095.0 * $tf4 + 1575 * ($tf4 * $tf2);
        	$philambda[0] = $phif + $x2frac * $x2poly * ($x * $x)
        		+ $x4frac * $x4poly * pow ($x, 4.0)
	        	+ $x6frac * $x6poly * pow ($x, 6.0)
        		+ $x8frac * $x8poly * pow ($x, 8.0);
        	
	        $philambda[1] = $lambda0 + $x1frac * $x
        		+ $x3frac * $x3poly * pow ($x, 3.0)
        		+ $x5frac * $x5poly * pow ($x, 5.0)
	        	+ $x7frac * $x7poly * pow ($x, 7.0);
        	
        	return $philambda;
	}

	function FootpointLatitude ($y){
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
	        $n = ($sm_a - $sm_b) / ($sm_a + $sm_b);
        	$alpha_ = (($sm_a + $sm_b) / 2.0)* (1 + (pow ($n, 2.0) / 4) + (pow ($n, 4.0) / 64));
	        $y_ = $y / $alpha_;
        	$beta_ = (3.0 * $n / 2.0) + (-27.0 * pow ($n, 3.0) / 32.0)+ (269.0 * pow ($n, 5.0) / 512.0);
	        $gamma_ = (21.0 * pow ($n, 2.0) / 16.0)+ (-55.0 * pow ($n, 4.0) / 32.0);
	        $delta_ = (151.0 * pow ($n, 3.0) / 96.0)+ (-417.0 * pow ($n, 5.0) / 128.0);
        	$epsilon_ = (1097.0 * pow ($n, 4.0) / 512.0);
	        $result = $y_ + ($beta_ * sin (2.0 * $y_))
        	    + ($gamma_ * sin (4.0 * $y_))
	            + ($delta_ * sin (6.0 * $y_))
	            + ($epsilon_ * sin (8.0 * $y_));
        	return $result;
	}
	function MapLatLonToXY ($phi, $lambda, $lambda0){
		$xy=array();
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
		$ep2 = (pow ($sm_a, 2.0) - pow ($sm_b, 2.0)) / pow ($sm_b, 2.0);
		$nu2 = $ep2 * pow (cos ($phi), 2.0);
		$N = pow ($sm_a, 2.0) / ($sm_b * sqrt (1 + $nu2));
		$t = tan ($phi);
		$t2 = $t * $t;
		$tmp = ($t2 * $t2 * $t2) - pow ($t, 6.0);
		$l = $lambda - $lambda0;
		$l3coef = 1.0 - $t2 + $nu2;
		$l4coef = 5.0 - $t2 + 9 * $nu2 + 4.0 * ($nu2 * $nu2);
		$l5coef = 5.0 - 18.0 * $t2 + ($t2 * $t2) + 14.0 * $nu2- 58.0 * $t2 * $nu2;
		$l6coef = 61.0 - 58.0 * $t2 + ($t2 * $t2) + 270.0 * $nu2- 330.0 * $t2 * $nu2;
		$l7coef = 61.0 - 479.0 * $t2 + 179.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$l8coef = 1385.0 - 3111.0 * $t2 + 543.0 * ($t2 * $t2) - ($t2 * $t2 * $t2);
		$xy[0] = $N * cos ($phi) * $l
            	+ ($N / 6.0 * pow (cos ($phi), 3.0) * $l3coef * pow ($l, 3.0))
            	+ ($N / 120.0 * pow (cos ($phi), 5.0) * $l5coef * pow ($l, 5.0))
            	+ ($N / 5040.0 * pow (cos ($phi), 7.0) * $l7coef * pow ($l, 7.0));
		$xy[1] = $this->ArcLengthOfMeridian ($phi)
            	+ ($t / 2.0 * $N * pow (cos ($phi), 2.0) * pow ($l, 2.0))
            	+ ($t / 24.0 * $N * pow (cos ($phi), 4.0) * $l4coef * pow ($l, 4.0))
            	+ ($t / 720.0 * $N * pow (cos ($phi), 6.0) * $l6coef * pow ($l, 6.0))
            	+ ($t / 40320.0 * $N * pow (cos ($phi), 8.0) * $l8coef * pow ($l, 8.0));
		return $xy;
	}
	function ArcLengthOfMeridian($phi){
		$sm_b = 6356752.314;
		$sm_a = 6378137.0;
		$UTMScaleFactor = 0.9996;
		$sm_EccSquared = .00669437999013;
		$n = ($sm_a - $sm_b) / ($sm_a + $sm_b);
		$alpha = (($sm_a + $sm_b) / 2.0)
			* (1.0 + (pow ($n, 2.0) / 4.0) + (pow ($n, 4.0) / 64.0));
		$beta = (-3.0 * $n / 2.0) + (9.0 * pow ($n, 3.0) / 16.0)
	           + (-3.0 * pow ($n, 5.0) / 32.0);
		$gamma = (15.0 * pow ($n, 2.0) / 16.0)
	            + (-15.0 * pow ($n, 4.0) / 32.0);
		$delta = (-35.0 * pow ($n, 3.0) / 48.0)
	            + (105.0 * pow ($n, 5.0) / 256.0);
		$epsilon = (315.0 * pow ($n, 4.0) / 512.0);
		$result = $alpha* ($phi + ($beta * sin (2.0 * $phi))
	            + ($gamma * sin (4.0 * $phi))
        	    + ($delta * sin (6.0 * $phi))
		    + ($epsilon * sin (8.0 * $phi)));
		return $result;
	}

}