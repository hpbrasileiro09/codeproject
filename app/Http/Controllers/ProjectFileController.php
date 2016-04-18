<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectFileController extends Controller
{

    /**
    * @var ProjectRepository
    */
    protected $repository;

    /**
    * @var ProjectService
    */
    protected $service;

    public function __construct(
        ProjectRepository $repository,
        ProjectService $service
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }    
    
    public function index() 
    {
    	return $this->repository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
    }
    
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['project_id'] = $request->project_id;
        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;

        $this->service->createFile($data);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkProjectPermissions($id) == false)
        {
            return response()->json([ 'error' => 'Access forbidden' ]);
        }

        return $this->service->update($request->all(), $id);
    }
    
    public function show($id)
    {
        if ($this->checkProjectPermissions($id) == false)
        {
            return response()->json([ 'error' => 'Access forbidden' ]);
        }

    	return $this->repository->find($id);
    }
    
    public function destroy($id)
    {
        if ($this->checkProjectPermissions($id) == false)
        {
            return response()->json([ 'error' => 'Access forbidden' ]);
        }

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

    private function checkProjectOwner($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) == true or 
            $this->checkProjectMember($projectId) == true)
        {
            return true;
        }
        return false;
    }
}
