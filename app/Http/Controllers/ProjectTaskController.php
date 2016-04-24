<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ProjectTaskController extends Controller
{

    /**
    * @var ProjectTaskRepository
    */
    protected $repository;

    /**
    * @var ProjectTaskService
    */
    protected $service;

    public function __construct(
        ProjectTaskRepository $repository,
        ProjectTaskService $service
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

    public function update(Request $request, $id, $taskId)
    {
        try {
            return $this->service->update($request->all(), $taskId);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível atualizar a tarefa'];
        }
    }
    
    public function show($id, $taskId)
    {
        try {
            return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível exibir a tarefa'];
        }
    }
    
    public function destroy($id, $taskId)
    {
        try {
            $this->repository->find($taskId)->delete();
            return ['status' => true, 'message' => 'Tarefa excluída com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir a tarefa'];
        }        
	}

}
