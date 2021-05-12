<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\TipoFoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foto = Foto::with([])
                    ->get();
        
        return $foto;
    }

    public function fotoTipo( $idTipoFoto )
    {
        $foto = Foto::with(['tipoFoto:id,nb_tipo_foto,tx_origen,tx_base_path', 'sede:id,nb_sede'])
                          ->where('id_tipo_foto', $idTipoFoto)
                          ->get();
        
        return $foto;
    }

    public function fotoTipoOrigen( $idTipoFoto, $origenId )
    {
        $foto = Foto::with(['tipoFoto:id,nb_tipo_foto,tx_origen,tx_base_path'])
                          ->where('id_tipo_foto', $idTipoFoto)
                          ->where('id_origen', $origenId)
                          ->get();
        
        return $foto;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = request()->validate([
			'tx_src'       =>  'required|string',
			'id_tipo_foto' =>  'required|integer',
			'id_origen'    =>  'required|integer',
			'user_id'   =>  'required|integer',
        ]);

        $tipoFoto    = TipoFoto::where('id', $request->id_tipo_foto)->first();

        if($request->id_tipo_foto != 1)
        {
            $this->deleteFotosSede($request, $tipoFoto);
        }

        $sufix       = date('U');
        $imgName     = $tipoFoto->tx_origen . $sufix . '.jpg';
        $imgSource   = $request->tx_src;
        $storage     = $tipoFoto->tx_storage;
        $folder      = $tipoFoto->tx_origen;
        
        $stored      = $this->storeImage($imgSource, $storage, $imgName, $folder);

        $request->merge([
            'tx_src'       =>  $imgName,
            'nb_foto'      =>  "$tipoFoto->tx_origen $sufix",
            'status_id'    =>  1
        ]);

        $foto = foto::create($request->all());

        return [ 'msj' => 'Foto Agregada Correctamente', 'foto' => $foto, 'stored' => $stored ];
    }

    public function storeImage($imgSource, $storage, $imgName, $folder)
	{
        $imgSource = substr($imgSource, strpos($imgSource, 'base64,') + 7);
             
        $imgSource  = base64_decode($imgSource);
                                                    
        $stored = Storage::disk($storage)->put(  $folder . DIRECTORY_SEPARATOR . $imgName, $imgSource);

        return $stored;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function show(Foto $foto)
    {
        return $foto;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Foto $foto)
    {
        $validate = request()->validate([
            'nb_foto'           => 	'required|string|max:100',
			'tx_src'            => 	'required|string|max:100',
			'id_tipo_foto'      => 	'required|integer',
			'id_origen'        => 	'required|integer',
			'tx_observaciones'  => 	'nullable|string|max:100',
			'status_id'         => 	'required|integer',
			'user_id'        => 	'required|integer',
        ]);

        $foto = $foto->update($request->all());

        return [ 'msj' => 'Foto Editado' , compact('foto')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Foto  $foto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Foto $foto)
    {
        $tipoFoto = TipoFoto::where('id', $foto->id_tipo_foto)->first();

        $storage  = $tipoFoto->tx_storage;

        $folder   = $tipoFoto->tx_origen . DIRECTORY_SEPARATOR ;

        $path     = $folder . $foto->tx_src;

        if($this->deleteImage( $storage, $path ))
        {
            $foto = $foto->delete();

            return [ 'msj' => 'Foto Eliminada' , compact('foto')];

        }else
        {
            $foto = $foto->delete();
            return [ 'msj' => 'Foto Eliminada' , compact('foto')]; //TODO msj
        }
    }

    public function deleteFotosSede($request, $tipoFoto)
    {
        $storage  = $tipoFoto->tx_storage;

        $folder   = $tipoFoto->tx_origen . DIRECTORY_SEPARATOR ;

        $foto     = Foto::where(['id_origen' => $request->id_origen, 'id_tipo_foto' => $request->id_tipo_foto])->first();

        if($foto)
        {
            $path     = $folder . $foto->tx_src;
            $this->deleteImage( $storage, $path );
            $foto->delete();
        }
    }

    public function deleteImage( $storage, $path )
    {       
        return Storage::disk($storage)->delete($path);
    }
}
