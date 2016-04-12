<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ClientController extends Controller
{

    /**
    * @var ClientRepository
    */
    protected $repository;

    /**
    * @var ClientService
    */
    protected $service;

    public function __construct(
        ClientRepository $repository,
        ClientService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }    
    
    public function index() 
    {
    	return $this->repository->all();
    }
    
    public function store(Request $request)
    {
    	return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }
    
    public function show($id)
    {
    	return $this->repository->find($id);
    }
    
    public function destroy($id)
    {
		try
	    {
	    	$this->repository->find($id)->delete();
	        return response()->json(['OK']);
	    }
	    catch (\Exception $e)
	    {
	        return response()->json(['NOK' => $e->getMessage()]);
	    }    	
	}

}
