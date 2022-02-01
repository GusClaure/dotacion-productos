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
        
            
            return view('dashboard', [
                'data_count' => Persona::getAllCountData(),
                'sindicatos' => Persona::getAllSindicatos()
            ]);
            
        }else{
            
            return view('personas.personas', [
                'data_count' => Persona::getAllCountData(),
                'data_persons' => Persona::getAllPersonWith()
            ]);
        } 
    }
}
