<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\AmolatinaDataTrait as Amolatina;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::with([])
                    ->get();
    }

    public function topAgency($agencyId)
    {
        return Client::with([])
                    ->where('agency_id', $agencyId)
                    ->orderBy('profit', 'desc')
                    ->get();
    }


    public function detailClients()
    {
        set_time_limit ( 300 );

        $clients = Client::with(['agency:id,amolatina_id,token'])->whereIn('status_id',[ 6, 7 ])->whereNull('name')->limit(300)->get();
        
        $storeClients = [];
        $errorClients = [];

        foreach ($clients as $client) {
            
            $response = $this->getDetailClient($client->agency->token, $client->amolatina_id);

            if($response['ok'])
            {
                $clientDetail = $response['body'];

                $storeClients[$client->amolatina_id] = $this->setDataClient($client, $clientDetail);

                $update[$client->amolatina_id] = $client->update($storeClients[$client->amolatina_id]);
            }
            else{
                if($response['status'] == 410)
                {
                    $client->update(['status_id' => 9]);
                }
                
                $errorClients[$client->amolatina_id] = $response;
            }
        }

        return ['msj' => 'se actualizaron (' . count($storeClients) . ') clientes', 'update' => $storeClients, 'erros' => $errorClients ];
    }

    public function setDataClient($client, $clientDetail)
    {
        return   $data = [
            'name'     => $clientDetail['name'],
            'birthday' => (isset($clientDetail['birthday'])) ?  Carbon::parse($clientDetail['birthday'])->format('Y-m-d') : null,
            'age'      => (isset($clientDetail['birthday'])) ?  Carbon::parse($clientDetail['birthday'])->age : null,
            'photo'    => (isset($clientDetail['thumbnail'])) ? $clientDetail['thumbnail'] : null,
            'gender'   => (isset($clientDetail['gender'])) ? $clientDetail['gender'] : null,
            'country'  => (isset($clientDetail['country'])) ? $clientDetail['country'] : null,
            'city'     => (isset($clientDetail['city'])) ? $clientDetail['city'] : null,
        ];
    }

    public function getDetailClient($token, $amolatinaId)
    {
        $setup          = Amolatina::getSetup('detail-profile');
        $url            = $setup->url . '/' . $amolatinaId  ;
        return Amolatina::getDataUrl( $token, $url, [], [], false );
    }

    public function importClientPhoto()
    {
        set_time_limit ( 300 );

        $clients = Client::with(['agency:id,amolatina_id,token:'])
                          ->whereIn('status_id',[ 6, 7 ])
                          ->whereNotNull('photo')
                          ->whereNotIn('comments', ['has-photo', 'no-photo'])
                          ->orderBy('points', 'desc')
                          ->get();

        $stored = [];
        foreach ($clients as $client) {
            $stored[$client->amolatina_id] = $this->getPhotoClient($client);
            if($stored[$client->amolatina_id])
            {
                $client->update(['comments' => 'has-photo']);
            }else{
                $client->update(['comments' => 'no-photo']);
            }
        }

        return [ 'msj' => 'importadas'. count($stored), 'stored' => $stored] ;
    }

    public function getPhotoClient($client)
    {
        $token       = $client->agency->token;
        $response    = $this->getPhoto($token, $client);
         
        if($response['ok'])
        {
            $file = $response['body'];
            return  $this->storePhoto($file, "$client->photo.jpg", 'photo_client'); 
        }
        return false;
    }

    public function getPhoto($token, $client)
    {
       $photo    = "$client->photo.190x180.thumb-fd";
       $url      = "users/".$client->amolatina_id."/photos/$photo";
       return    Amolatina::getContentUrl($token, $url, 'https://api8.amolatina.com/', false);
    }

    public function storePhoto($fileContend, $fileName, $storage)
    {
        return Storage::disk($storage)->put( $fileName, $fileContend);
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
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'nullable|string|max:60',
			'birthday'          => 	'nullable|string|max:0',
			'age'               => 	'nullable|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'gender'            => 	'nullable|string|max:3',
			'preference'        => 	'nullable|string|max:3',
			'country'           => 	'nullable|string|max:3',
			'city'              => 	'nullable|string|max:100',
			'profit'            => 	'nullable|numeric|max:11',
			'crown'             => 	'nullable|integer|max:999999999',
			'contacted_at'      => 	'nullable|date',
			'last_contact'      => 	'nullable|date',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $client = client::create($request->all());

        return [ 'msj' => 'Client Agregado Correctamente', compact('client') ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $validate = request()->validate([
            'amolatina_id'      => 	'required|string|max:',
			'name'              => 	'nullable|string|max:60',
			'birthday'          => 	'nullable|string|max:0',
			'age'               => 	'nullable|integer|max:999999999',
			'photo'             => 	'nullable|string|max:200',
			'gender'            => 	'nullable|string|max:3',
			'preference'        => 	'nullable|string|max:3',
			'country'           => 	'nullable|string|max:3',
			'city'              => 	'nullable|string|max:100',
			'profit'            => 	'nullable|numeric|max:11',
			'crown'             => 	'nullable|integer|max:999999999',
			'contacted_at'      => 	'nullable|date',
			'last_contact'      => 	'nullable|date',
			'comments'          => 	'nullable|string|max:800',
			'status_id'         => 	'required|integer|max:999999999',
			'user_id'           => 	'required|integer|max:999999999',
        ]);

        $client = $client->update($request->all());

        return [ 'msj' => 'Client Editado' , compact('client')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client = $client->delete();
 
        return [ 'msj' => 'Client Eliminado' , compact('client')];
    }
}
