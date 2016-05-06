<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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
    	return $this->repository->findWhere(['owner_id' => Authorizer::getResourceOwnerId()]);
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
            return ['status' => false, 'message' => 'Não foi possível atualizar o projeto'];
        }
    }
    
    public function show($id)
    {
        try {
            return $this->repository->with(['client','owner'])->find($id);
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível exibir o projeto'];
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->repository->find($id)->delete();
            return ['status' => true, 'message' => 'Projeto excluído com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Não foi possível excluir o projeto'];
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

    public function addMember($id, $userId)
    {
        return $this->service->addMember($id, $userId);
    }

    public function removeMember($id, $memberId)
    {
        return $this->service->removeMember($id, $memberId);
    }

    public function isMember($id, $userId)
    {
        if ($this->service->isMember($id, $userId) == true) {
            return ['status' => true, 'message' => 'Usuário é membro do projeto'];
        }
        return ['status' => false, 'message' => 'Usuário não é membro deste projeto'];
    }

}
