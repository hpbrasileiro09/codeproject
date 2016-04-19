<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use CodeProject\Http\Requests;

class ProjectController extends Controller
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
    	return $this->repository->with(['client','owner'])->all();
    }
    
    public function store(Request $request)
    {
    	return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
        try {
            return $this->service->update($request->all(), $id);
        } catch (\Exception $e) {
            return ['error'=>true, 'Projeto não encontrado.'];
        }

    }
    
    public function show($id)
    {
        try {
            return $this->repository->with(['client','owner'])->find($id);
        } catch (\Exception $e) {
            return ['error'=>true, 'Projeto não encontrado.'];
        }        
    }
    
    public function destroy($id)
    {
        try {
            $this->repository->find($id)->delete();
            return ['success'=>true, 'Projeto deletado com sucesso!'];
        } catch (QueryException $e) {
            return ['error'=>true, 'Projeto não pode ser apagado pois existe um ou mais clientes vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Projeto não encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao excluir o projeto.'];
        }        
	}

}
