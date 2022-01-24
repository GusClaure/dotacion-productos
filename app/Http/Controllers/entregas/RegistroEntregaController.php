<?php

namespace App\Http\Controllers\entregas;


use App\Models\Persona;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Models\RegistroEntrega;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\EntregaProducto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

}