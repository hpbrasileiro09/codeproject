<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Services\ProjectMemberService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

class ProjectMemberController extends Controller
{

    /**
    * @var ProjectMemberRepository
    */
    protected $repository;

    /**
    * @var ProjectMemberService
    */
    protected $service;

    public function __construct(
        ProjectMemberRepository $repository,
        ProjectMemberService $service
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

    public function update(Request $request, $id, $memberId)
    {
        try {
            return $this->service->update($request->all(), $memberId);
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível atualizar o membro'];
        }
    }
    
    public function show($id, $memberId)
    {
        try {
            return $this->repository->findWhere(['project_id' => $id, 'id' => $memberId]);
        } catch (Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível exibir o membro'];
        }
    }
    
    public function destroy($id, $memberId)
    {
        try {
            $this->repository->find($memberId)->delete();
            return ['status' => true, 'message' => 'Membro excluído com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir o membro'];
        }        
	}

}
