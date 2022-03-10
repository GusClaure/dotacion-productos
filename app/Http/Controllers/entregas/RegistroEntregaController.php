<?php

namespace App\Http\Controllers\entregas;



use PDF;
use App\Models\Persona;
use App\Models\Producto;
//use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\EntregaProducto;
use App\Models\RegistroEntrega;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;


class RegistroEntregaController extends Controller{


	public function listaProductosEntregados(){
		return view('personas.listaProductosEntregados', [
			'data_count' => Persona::getAllCountData(),
			'data_persons' => Persona::getAllPersonWith()
		]);
	}


	public function listaProductosPendientes(){
		return view('personas.listaProductosPendientes', [
			'data_count' => Persona::getAllCountData(),
			'data_persons' => Persona::getAllPersonWith()
		]);
	}


	public function GetAllRegisterDatatableEntregados(Request $request){
        
        $registros = Persona::select('personas.*', 'registros_entregas.status')
		->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		->whereIn('registros_entregas.status', ['ENTREGADO'])
		->where('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->skip($request->start)
        ->take($request->length)
        ->orderBy('nombre', 'asc')
        ->get();

        $count = Persona::leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		->whereIn('registros_entregas.status', ['ENTREGADO'])
		->where('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->count();



        $draw = $request->draw;
        return response([
                     'draw' =>  $draw,
                     'recordsTotal' => $count,
                     'recordsFiltered' => $count,
                     'data' => $registros
                 ],200);

    }


	public function GetAllRegisterDatatablePendiente(Request $request){
		 
        $registros = Persona::select('personas.*', 'registros_entregas.status')
		->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		->whereIn('registros_entregas.status', ['PENDIENTE-PRODUCTO'])
		->where('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->skip($request->start)
        ->take($request->length)
        ->orderBy('nombre', 'asc')
        ->get();

        $count = Persona::leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
		->whereIn('registros_entregas.status', ['PENDIENTE-PRODUCTO'])
		->where('ci', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
        ->count();



        $draw = $request->draw;
        return response([
                     'draw' =>  $draw,
                     'recordsTotal' => $count,
                     'recordsFiltered' => $count,
                     'data' => $registros
                 ],200);
	}

    public function RegistroEntregaProducto(Request $request){
	
		$this->validate($request, [
			'id_persona' => 'required',
			'productos' => 'required'
		]);

		$check_person = Persona::select()
					->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
					->where(['personas.id' => $request->id_persona, 'personas.status' => 'ACTIVO'])
					->first();
		

		if($check_person){

			if($check_person->status == null){
				$status = '';
				if(count($request->productos) < 5){
					$status = 'PENDIENTE-PRODUCTO';
				}else{
					$status = 'ENTREGADO';
				}
	
				$registro = new RegistroEntrega();
				$registro->id_persona = $request->id_persona;
				$registro->observacion = trim($request->observacion);
				$registro->status = $status;
				$registro->save();
				
				
				foreach($request->productos as $value){
					$producto = new EntregaProducto();
					$producto->id_usuario = Auth::id();
					$producto->id_registro = $registro->id;
					$producto->uuid_registro = $registro->uuid;
					$producto->id_producto = $value;
					
					if($value == 2){
						$producto->cantidad_producto_entregado = 4;
					}else if($value == 3){
						$producto->cantidad_producto_entregado = 2;
					}
					 
					$producto->save();
				}

				$data = Persona::getAllCountData();
				return response([
					'status'=> true,
					'response'=> 'Registro exitoso!',
					'entregados' => $data->total_entregados,
					'pendientes' => $data->total_pendientes,
					'pendientes_producto' => $data->total_pendientes_producto
				 ],200);
			}else{
				return response([
					'status'=> false,
					'message'=> 'No se pudo guardar recargue la pagina'
				 ],200);
			}

		}else{
			return response([
				'status'=> false,
				'message'=> 'No se encontro ningun resultado resultado o el registro fue anulado'
			 ],200);
		}
	}


	public function getDetalleEntregaCompl(Request $request){
	
		$value = RegistroEntrega::select()
		        ->leftjoin('entregas_productos', 'entregas_productos.id_registro', '=', 'registros_entregas.id')
				->leftjoin('personas', 'personas.id', '=', 'registros_entregas.id_persona')
				->leftjoin('productos', 'productos.id', '=', 'entregas_productos.id_producto')
				->leftjoin('rubros', 'rubros.id', '=', 'personas.rubro_id')
				->where(['registros_entregas.id_persona' => $request->id_persona, 'entregas_productos.status' => 'ENTREGADO' ])
				->get();

		if(isset($value[0]->id)){
			$id_producto = [];		
		foreach($value as $index){
			array_push($id_producto,$index->id_producto);
		}

		$productos = Producto::select('id', 'nombre_producto')
				->whereNotIn('id', $id_producto)
				->where(['status' => 1])
				->get();

		return response([
					'status'=> true,
					'response'=> $value,
					'productos' => $productos
				 ],200);
		}else{

			$value = RegistroEntrega::select()
		        ->leftjoin('entregas_productos', 'entregas_productos.id_registro', '=', 'registros_entregas.id')
				->leftjoin('personas', 'personas.id', '=', 'registros_entregas.id_persona')
				->leftjoin('productos', 'productos.id', '=', 'entregas_productos.id_producto')
				->leftjoin('rubros', 'rubros.id', '=', 'personas.rubro_id')
				->where(['registros_entregas.id_persona' => $request->id_persona, 'entregas_productos.status' => 'ANULADO' ])
				->get();

				$productos = Producto::select('id', 'nombre_producto')
				->where(['status' => 1])
				->get();

		return response([
					'status'=> true,
					'response'=> $value,
					'productos' => $productos
				 ],200);
		}
		
	}


	public function updateEntregaProductoComplemento(Request $request){
		$this->validate($request, [
			'id_persona' => 'required',
			'producto' => 'required'
		],[
			'required' => ':attribute es requerido!'
		]);

	
		$registro_entrega = RegistroEntrega::select()
							->where(['id_persona' => $request->id_persona])
							->first();
		
		
		if($registro_entrega){
			$total = EntregaProducto::where(['id_registro' => $registro_entrega->id, 'status' => 'ENTREGADO'])->count() + count($request->producto); 
			
			if($total == 5){
				
				foreach($request->producto as $value){
					$producto = new EntregaProducto();
					$producto->id_usuario = Auth::id();
					$producto->id_registro = $registro_entrega->id;
					$producto->id_producto = $value;
					$producto->uuid_registro = $registro_entrega->uuid;
					if($value == 2){
						$producto->cantidad_producto_entregado = 4;
					}else if($value == 3){
						$producto->cantidad_producto_entregado = 2;
					}
					$producto->save();
				}

				if(isset($request->observacion)){
					RegistroEntrega::where(['id' => $registro_entrega->id])
					->update([
						'status' => 'ENTREGADO',
						'observacion' => trim($request->observacion)
						//'observacion' => trim($registro_entrega->observacion. ' && '.$request->observacion )
					]);
				}else{
					RegistroEntrega::where(['id' => $registro_entrega->id])
					->update(['status' => 'ENTREGADO']);
				}
			
				$data = Persona::getAllCountData();
				return response([
						'status'=> true,
						'response'=> 'Registro exitoso!',
						'entregados' => $data->total_entregados,
						'pendientes' => $data->total_pendientes,
						'pendientes_producto' => $data->total_pendientes_producto
							 ],200);

			}else{

				foreach($request->producto as $value){
					$producto = new EntregaProducto();
					$producto->id_usuario = Auth::id();
					$producto->id_registro = $registro_entrega->id;
					$producto->id_producto = $value;
					if($value == 2){
						$producto->cantidad_producto_entregado = 4;
					}else if($value == 3){
						$producto->cantidad_producto_entregado = 2;
					}
					$producto->save();
				}


				if($registro_entrega->status == 'ANULADO'){
					RegistroEntrega::where(['id' => $registro_entrega->id])
					->update(['status' => 'PENDIENTE-PRODUCTO']);
				}


				$data = Persona::getAllCountData();
				return response([
						'status'=> true,
						'response'=> 'Registro exitoso!',
						'entregados' => $data->total_entregados,
						'pendientes' => $data->total_pendientes,
						'pendientes_producto' => $data->total_pendientes_producto
							 ],200);

			}
	
		}else{
			return response([
				'status'=> false,
				'message'=> 'El registro no existe por favor recargue la pagina'
			 ],200);
		}

	}

	public function generatePdfDetalleEntrega($id_persona){

		$find_data = RegistroEntrega::select()
		->leftjoin('entregas_productos', 'entregas_productos.id_registro', '=', 'registros_entregas.id')
		->leftjoin('personas', 'personas.id', '=', 'registros_entregas.id_persona')
		->leftjoin('productos', 'productos.id', '=', 'entregas_productos.id_producto')
		->leftjoin('rubros', 'rubros.id', '=', 'personas.rubro_id')
		->where(['registros_entregas.id_persona' => $id_persona, 'entregas_productos.status' => 'ENTREGADO'])
		->get();
	
		
		$mes = '';
		if(date('m') == '01'){
			$mes = 'Enero';
		}else if(date('m') == '02'){
			$mes = 'Febrero';
		}else if(date('m') == '03'){
			$mes = 'Marzo';
		}else if(date('m') == '04'){
			$mes = 'Abril';
		}else if(date('m') == '05'){
			$mes = 'Mayo';
		}else if(date('m') == '06'){
			$mes = 'Junio';
		}else if(date('m') == '07'){
			$mes = 'Julio';
		}else if(date('m') == '08'){
			$mes = 'Agosto';
		}else if(date('m') == '09'){
			$mes = 'Septiembre';
		}else if(date('m') == '10'){
			$mes = 'Octubre';
		}else if(date('m') == '11'){
			$mes = 'Noviembre';
		}else if(date('m') == '12'){
			$mes = 'Diciembre';
		}
		

		$image = base64_encode(file_get_contents(public_path('argon/img/logogamc.png')));
		$qr_image = QrCode::size(250)->format('svg')
					->errorCorrection('H')
					->generate('https://innova.cochabamba.bo/api/cheking-document/'.$find_data[0]->uuid);

						$pdf = PDF::loadView('detallePdf', [
							'image' => $image,
							'title' => 'FORMULARIO DE ENTREGA DE INSUMOS AGROPECUARIOS NRO '.$find_data[0]->nro_formulario,
							'data_person' => $find_data,
							'name_person' => mb_strtoupper(trim($find_data[0]->nombre.' '.$find_data[0]->primer_ap.' '.$find_data[0]->segundo_ap)),
							'qr_image' => base64_encode($qr_image),
							'mes' => $mes,
							'url' => 'https://innova.cochabamba.bo/api/cheking-document/'.$find_data[0]->uuid
							])
							->setPaper('a4', 'letter')
							->setWarnings(false);
					

	return $pdf->stream('FORMULARIO_'.$find_data[0]->nro_formulario.'.pdf');
	
	}



	public function anularEntregaProducto(Request $request){

		$find_entrega = RegistroEntrega::select()
						->where('id_persona', $request->id_persona)
						->first();

		if($find_entrega){

			RegistroEntrega::where('id_persona', $request->id_persona)
							->update([
								'status' => 'ANULADO'
							]);

			EntregaProducto::where(['id_registro' => $find_entrega->id])
					->update([
						'status' => 'ANULADO',
						'fecha_anulacion' => date('Y-m-d H:i:s'),
						'usuario_anulo' => Auth::id()
					]);

					
					return response([
						'status'=> true,
						'response'=> 'Se anulo el registro Nro. '
					 ],200);

		}else{
			return response([
				'status'=> false,
				'message'=> 'El registro no existe por favor recargue la pagina'
			 ],200);
		}

	}


	public function llenadoDatosRegistrosEntregas(Request $request){
		
		$valid = Validator::make($request->all(), [
            'uuid' => 'required',
            'id_persona' => 'required',
            'fecha_registro' => 'required',
            'status' => 'required'
        ]);
        
        if ($valid->fails()) {
            return response()->json(
                ['error' => $valid->errors()],
                422
            );
        }

         
		$person = RegistroEntrega::select()
					->where(['id_persona' => $request->id_persona])
					->first();

		if(!$person){
			$data = new RegistroEntrega();
			$data->uuid = $request->uuid;
			$data->id_persona = $request->id_persona;
			$data->observacion = $request->observacion;
			$data->fecha_registro = $request->fecha_registro;
			$data->status = $request->status;
			$data->save();

			return response([
				'status'=> true,
				'response'=> 'registro '.$request->id_persona
			 ],201);
		}else{
			return response([
				'status'=> false,
				'message'=> 'la persona con el id_persona '.$request->id_persona. ' ya fue registrado'
			 ],401);
		}


	}


	public function llenadoDatosEntregaProductos(Request $request){
		
		$valid = Validator::make($request->all(), [
            'id_usuario' => 'required',
            'id_registro' => 'required',
            'id_producto' => 'required',
            'fecha_entrega' => 'required',
			'status' => 'required',
			'uuid_registro' => 'required'
        ]);
        
        if ($valid->fails()) {
            return response()->json(
                ['error' => $valid->errors()],
                422
            );
        }

	
			$RegistroEntrega = RegistroEntrega::select()
			->where(['uuid' => $request->uuid_registro])
			->first();
			
		 
					
		if($RegistroEntrega){
			$data = new EntregaProducto();
			$data->id_usuario = $request->id_usuario;
			$data->id_registro = $RegistroEntrega->id;
			$data->id_producto = $request->id_producto;
			if($request->id_producto == 2){
				$data->cantidad_producto_entregado = 4;
			}else if($request->id_producto == 3){
				$data->cantidad_producto_entregado = 2;
			}
			$data->fecha_entrega = $request->fecha_entrega;
			$data->fecha_anulacion = $request->fecha_anulacion;
			$data->usuario_anulo = $request->usuario_anulo;
			$data->status = $request->status;
			$data->uuid_registro = $RegistroEntrega->uuid;
			$data->save();

		
			return response([
				'status'=> true,
				'response'=> 'registrado'
			 ],201);
		}else{
			return response([
				'status'=> false,
				'message'=> 'la persona con el uuid '.$request->uuid_registro. ' no se encuentra registrado'
			 ],401);
		}


	}

	//funcion para actualizar mis datos
	public function updateTableProduct(){
		
		$registro = RegistroEntrega::all();

		foreach($registro as $value){
			
			EntregaProducto::where(['id_registro' => $value->id])
			->update(['uuid_registro' => $value->uuid]);
			
		}
		
		return 'echo';

	}



	public function searchPerson(Request $request){

		
		$person = Persona::select()
		->where(['ci' => trim($request->ci)])
		->first();

		if($person){


			return response([
				'status'=> true,
				'response'=> $person
			 ],200);

		}else{
			DB::table('lista')->insert([
				'ci' => $request->ci,
				'nombre' => trim($request->nombre)
			]);

			return response([
				'status'=> false,
				'message'=> 'La persona con el ci: '. $ci. ' no existe o no encotro'
			 ],404);
		}

	}


	public function checkQrEntrega($uuid){

		if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
			return response([
				'status'=> false,
				'message'=> 'El uuid '. $uuid. ' no existe en nuentra base de datos'
			 ],200);
		}

		$find_data = RegistroEntrega::select()
		->leftjoin('entregas_productos', 'entregas_productos.id_registro', '=', 'registros_entregas.id')
		->leftjoin('personas', 'personas.id', '=', 'registros_entregas.id_persona')
		->leftjoin('productos', 'productos.id', '=', 'entregas_productos.id_producto')
		->leftjoin('rubros', 'rubros.id', '=', 'personas.rubro_id')
		->where(['registros_entregas.uuid' => $uuid, 'entregas_productos.status' => 'ENTREGADO'])
		->get();
	
	
		
		$mes = '';
		if(date('m') == '01'){
			$mes = 'Enero';
		}else if(date('m') == '02'){
			$mes = 'Febrero';
		}else if(date('m') == '03'){
			$mes = 'Marzo';
		}else if(date('m') == '04'){
			$mes = 'Abril';
		}else if(date('m') == '05'){
			$mes = 'Mayo';
		}else if(date('m') == '06'){
			$mes = 'Junio';
		}else if(date('m') == '07'){
			$mes = 'Julio';
		}else if(date('m') == '08'){
			$mes = 'Agosto';
		}else if(date('m') == '09'){
			$mes = 'Septiembre';
		}else if(date('m') == '10'){
			$mes = 'Octubre';
		}else if(date('m') == '11'){
			$mes = 'Noviembre';
		}else if(date('m') == '12'){
			$mes = 'Diciembre';
		}

		try {

			$find_data[0]->id;
		  
			return response([
				'status'=> true,
				'mes' => $mes,
				'response'=> $find_data
			 ],200);

		  } catch (\Exception $e) {
		  
			return response([
				'status'=> false,
				'message'=> 'No existe ningun dato'
			 ],200);
		  }	
	}




}