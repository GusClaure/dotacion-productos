<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        if(Auth::user()->role == 'ADMIN'){
           
            //dd(Persona::getAllPersonWith('Maica Sud', 'ENTREGADO'));
            return view('dashboard', [
                'data_count' => Persona::getAllCountData(),
                'data_persons' => Persona::getAllPersonWith('Maica Sud', 'ENTREGADO')
            ]);
        }else{
            // $entregados = DB::table('personas')->where(['status' => 'ENTREGADO'])->count();
            // $pendientes = DB::table('personas')->where(['status' => 'PENDIENTE'])->count();
            // $observado = DB::table('personas')->where(['status' => 'OBSERVADO'])->count();
            // return view('personas.personas', ['entregados' => $entregados, 'pendientes' => $pendientes, 'observado' => $observado]);
        } 
    }
}
