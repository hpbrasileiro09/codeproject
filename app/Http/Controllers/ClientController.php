<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;

class ClientController extends Controller
{
    
    public function index() 
    {
    	return \CodeProject\Client::all();
    }
    
    public function store(Request $request)
    {
    	return \CodeProject\Client::create($request->all());
    }

    public function update(Request $request, $id)
    {
        return response()->json(\CodeProject\Client::find($id)->update($request->all()));
    }
    
    public function show($id)
    {
    	return \CodeProject\Client::find($id);
    }
    
    public function destroy($id)
    {
		try
	    {
	    	\CodeProject\Client::find($id)->delete();
	        return response()->json(['OK']);
	    }
	    catch (\Exception $e)
	    {
	        return response()->json(['NOK' => $e->getMessage()]);
	    }    	
	}

}
