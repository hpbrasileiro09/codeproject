<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectFileRepository;
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
    * @var ProjectFile
    */
    protected $repositoryFile;

    /**
    * @var ProjectService
    */
    protected $service;

    public function __construct(
        ProjectRepository $repository,
        ProjectFileRepository $repositoryFile,
        ProjectService $service
    ) {
        $this->repository = $repository;
        $this->repositoryFile = $repositoryFile;
        $this->service = $service;
    }    
    
    public function index($project_id) 
    {
    	return $this->repositoryFile->findWhere(['project_id' => $project_id]);
    }
    
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['project_id'] = $request->project_id;
        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['description'] = $request->description;

        return $this->service->createFile($data);
    }

   
    public function destroy($id, $fileId)
    {
        try {
            $file = $this->repositoryFile->find($fileId);
            $file->delete();
            $this->service->removeFile($file->id, $file->extension);
            return ['status' => true, 'message' => 'Arquivo excluído com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir o arquivo'];
        }        
    }

}
