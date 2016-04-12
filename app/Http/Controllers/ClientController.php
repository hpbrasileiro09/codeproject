<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Entities\Client;

use CodeProject\Repositories\ClientRepository;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ClientController extends Controller
{

    protected $clientRepository;

    public function __construct(
        ClientRepository $clientRepository
    ) {
        $this->clientRepository = $clientRepository;
    }    
    
    public function index() 
    {
    	return $this->clientRepository->all();
    }
    
    public function store(Request $request)
    {
    	return Client::create($request->all());
    }
    
    public function show($id)
    {
    	return Client::find($id);
    }
    
    public function destroy($id)
    {
		try
	    {
	    	Client::find($id)->delete();
	        return response()->json(['OK']);
	    }
	    catch (\Exception $e)
	    {
	        return response()->json(['NOK' => $e->getMessage()]);
	    }    	
	}

}
