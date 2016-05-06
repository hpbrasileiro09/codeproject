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
        try {
            return $this->service->update($request->all(), $noteId);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível atualizar a nota'];
        }
    }
    
    public function show($id, $noteId)
    {
        try {
            return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível exibir a nota'];
        }
    }
    
    public function destroy($id, $noteId)
    {
        try {
            $this->repository->find($noteId)->delete();
            return ['status' => true, 'message' => 'Nota excluída com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir a nota'];
        }        
    }

}
