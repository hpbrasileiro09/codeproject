<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
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

    public function update(Request $request, $id)
    {
        try {
            return $this->service->update($request->all(), $id);
        } catch (\Exception $e) {
            return ['error'=>true, 'Cliente não encontrado.'];
        }        
    }
    
    public function store(Request $request)
    {
    	return $this->service->create($request->all());
    }
    
    public function show($id)
    {
        try {
        	return $this->repository->find($id);
        } catch (\Exception $e) {
            return ['error'=>true, 'Cliente não encontrado.'];
        }        
    }
    
    public function destroy($id)
    {
        try {
            $this->repository->find($id)->delete();
            return ['success'=>true, 'Cliente deletado com sucesso!'];
        } catch (QueryException $e) {
            return ['error'=>true, 'Cliente não pode ser apagado pois existe um ou mais projetos vinculados a ele.'];
        } catch (ModelNotFoundException $e) {
            return ['error'=>true, 'Cliente não encontrado.'];
        } catch (\Exception $e) {
            return ['error'=>true, 'Ocorreu algum erro ao excluir o cliente.'];
        }
	}

}
