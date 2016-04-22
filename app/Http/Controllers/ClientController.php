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
        try {
            return $this->service->update($request->all(), $id);
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível atualizar o cliente'];
        }        
    }
    
    public function show($id)
    {
        try {
            return $this->repository->find($id);
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível exibir o cliente'];
        }        
    }
    
    public function destroy($id)
    {
        try {
            $this->repository->find($id)->delete();
            return ['status' => true, 'message' => 'Cliente excluído com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir o cliente'];
        }        
	}

}
