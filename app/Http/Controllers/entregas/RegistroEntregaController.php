<?php

namespace App\Http\Controllers\entregas;



use PDF;
use App\Models\Persona;
use App\Models\Producto;
//use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\EntregaProducto;
use App\Models\RegistroEntrega;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class RegistroEntregaController extends Controller{


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
					$producto->id_producto = $value;
					$producto->save();
				}

				$data = Persona::getAllCountData();
				return response([
					'status'=> true,
					'response'=> 'Registro exitoso!',
					'entregados' => $data->total_entregados,
					'pendientes' => $data->total_pendientes,
					'pendientes_producto' => $data->total_pendientes_producto,
					'observado' => $data->total_observados
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
				->where('registros_entregas.id_persona', $request->id_persona)
				->get();

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
			$total = EntregaProducto::where('id_registro', $registro_entrega->id)->count() + count($request->producto); 
			
			if($total == 5){
				
				foreach($request->producto as $value){
					$producto = new EntregaProducto();
					$producto->id_usuario = Auth::id();
					$producto->id_registro = $registro_entrega->id;
					$producto->id_producto = $value;
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
						'pendientes_producto' => $data->total_pendientes_producto,
						'observado' => $data->total_observados
							 ],200);

			}else{

				foreach($request->producto as $value){
					$producto = new EntregaProducto();
					$producto->id_usuario = Auth::id();
					$producto->id_registro = $registro_entrega->id;
					$producto->id_producto = $value;
					$producto->save();
				}

				$data = Persona::getAllCountData();
				return response([
						'status'=> true,
						'response'=> 'Registro exitoso!',
						'entregados' => $data->total_entregados,
						'pendientes' => $data->total_pendientes,
						'pendientes_producto' => $data->total_pendientes_producto,
						'observado' => $data->total_observados
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
		->where('registros_entregas.id_persona', $id_persona)
		->get();
	
		$image = base64_encode(file_get_contents(public_path('argon/img/logogamc.png')));
		$qr_image = QrCode::size(250)->format('svg')
					//->backgroundColor(255,255,204)
					->errorCorrection('H')
					->generate('https://innova.cochabamba.bo/api/cheking-document/'.$find_data[0]->uuid);

						$pdf = PDF::loadView('detallePdf', [
							'image' => $image,
							'title' => 'FORMULARIO DE ENTREGA DE INSUMOS AGROPECUARIOS NRO '.$find_data[0]->nro_formulario,
							'data_person' => $find_data,
							'name_person' => mb_strtoupper(trim($find_data[0]->nombre.' '.$find_data[0]->primer_ap.' '.$find_data[0]->segundo_ap)),
							'qr_image' => base64_encode($qr_image)
							])
							->setPaper('a4', 'letter')
							->setWarnings(false);
					
	return $pdf->stream('FORMULARIO_'.$find_data[0]->nro_formulario.'.pdf');
	
	}


}