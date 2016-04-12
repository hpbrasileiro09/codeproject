<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ClientController extends Controller
{

    /**
    * @var ClientRepository
    */
    protected $repository;

    public function __construct(
        ClientRepository $repository
    ) {
        $this->repository = $repository;
    }    
    
    public function index() 
    {
    	return $this->repository->all();
    }
    
    public function store(Request $request)
    {
    	return $this->repository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->repository->find($id)->update($request->all());
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
