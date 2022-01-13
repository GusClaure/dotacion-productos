<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
        //return redirect('personas.personas');
        //return view('dashboard');

        $entregados = DB::table('personas')->where(['status' => 'ENTREGADO'])->count();
        $pendientes = DB::table('personas')->where(['status' => 'PENDIENTE'])->count();
        $observado = DB::table('personas')->where(['status' => 'OBSERVADO'])->count();

        return view('personas.personas', ['entregados' => $entregados, 'pendientes' => $pendientes, 'observado' => $observado]);
    }
}
