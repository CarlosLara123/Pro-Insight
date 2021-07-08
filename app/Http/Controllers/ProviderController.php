<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Provider;

class ProviderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        setlocale(LC_TIME, config('app.locale'));

    }

    /**
     * Rediret to list of providers.
     *
     * @return void
     */
    public function index(){
        $providers = Provider::paginate(10);
        return view('providers.list_providers')
        ->with('providers', $providers);
    }

    /**
     * Create a new provider
     *
     * @return void
     */
    public function store(Request $request){
        $http_response = array("message" => "Error", "response" => false);

        if($request->has("provider") && !is_null($request->provider)){
            $provider = new Provider();
            $provider->name = $request->provider;
            $provider->creation_date = date("Y-m-d H:i:s");
            $provider->update_date = date("Y-m-d H:i:s");
            $provider->save();

            $http_response["message"] = "El proveedor fue agragado";
            $http_response["response"] = true;
        }else{
            $http_response["message"] = "Algo salio mal, ¿estas seguro de haber ingresado el nombre del proveedor?";
        }

        return response()->json($http_response);
    }

    /**
     * Get all providers.
     *
     * @return void
     */
    public function get_providers(){
        $providers = Provider::all();
        return response()->json($providers);
    }


}
