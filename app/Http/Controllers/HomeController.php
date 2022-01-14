<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
            
            $entregados = DB::table('personas')->where(['status' => 'ENTREGADO'])->count();
            $pendientes = DB::table('personas')->where(['status' => 'PENDIENTE'])->count();
            $observado = DB::table('personas')->where(['status' => 'OBSERVADO'])->count();
            return view('dashboard', ['entregados' => $entregados, 'pendientes' => $pendientes, 'observado' => $observado]);
        }else{
            $entregados = DB::table('personas')->where(['status' => 'ENTREGADO'])->count();
            $pendientes = DB::table('personas')->where(['status' => 'PENDIENTE'])->count();
            $observado = DB::table('personas')->where(['status' => 'OBSERVADO'])->count();
            return view('personas.personas', ['entregados' => $entregados, 'pendientes' => $pendientes, 'observado' => $observado]);
        } 
    }
}
