<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ProjectNoteController extends Controller
{

    /**
    * @var ProjectNoteRepository
    */
    protected $repository;

    /**
    * @var ProjectNoteService
    */
    protected $service;

    public function __construct(
        ProjectNoteRepository $repository,
        ProjectNoteService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }    
    
    public function index($id) 
    {
    	return $this->repository->findWhere(['project_id' => $id]);
    }
    
    public function store(Request $request)
    {
    	return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $noteId)
    {
        return $this->service->update($request->all(), $noteId);
    }
    
    public function show($id, $noteId)
    {
        return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
    }
    
    public function destroy($id, $noteId)
    {
		try
	    {
	    	$this->repository->find($noteId)->delete();
	        return response()->json(['OK']);
	    }
	    catch (\Exception $e)
	    {
	        return response()->json(['NOK' => $e->getMessage()]);
	    }    	
	}

}
