<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Foto;
use App\Models\TipoFoto;
use App\Models\Sede;
use App\Models\Enlace;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',  [] );
    }

    public function welcome()
    {
        return view('app', []);
    }


    public function getData()
    {
        $foto = Foto::select('nb_foto', 'tx_src','id_tipo_foto','id_origen','id_status')
                    ->with(['sede:id,nb_sede'])
                    ->activo()
                    ->orderBy('id_origen', 'asc')
                    ->get();

        $sede = Sede::select('id',
                             'nb_sede',
                             'tx_ubicacion',
                             'tx_mapa',
                             'tx_transmision',
                             'tx_foto',
                             'tx_telefono',
                             'tx_whatsapp',
                             'id_status')
                        ->with(['foto:nb_foto,tx_src,id_tipo_foto,id_origen'])
                        ->activo()
                        ->orderBy('id', 'asc')
                        ->get();

        $enlace = Enlace::select('nb_enlace',
                                 'id_tipo_enlace',
                                 'tx_url',
                                 'id_status')
                        ->activo()
                        ->get();

        return ['foto' => $foto, 'sede' => $sede, 'enlace' => $enlace];
    }



}
