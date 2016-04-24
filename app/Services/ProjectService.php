<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

use \Prettus\Validator\Exceptions\ValidatorException;

class ProjectService 
{

	/**
	* @var ProjectRepository
	*/
	protected $repository;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	public function __construct(
		ProjectRepository $repository,
		ProjectValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
	}
	
	public function create(array $data)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			$this->repository->create($data);
		} catch(ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			$this->repository->update($data, $id);
		} catch(ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function addMember($id, $memberId)
	{
		$data = [
			'project_id' => $id,
			'member_id' => $memberId,
		];
		try {
			$project = $this->repository->skipPresenter()->find($id);
			$project->members()->create($data);
		} catch(ValidatorException $e) {
			return ['status' => false, 'message' => 'Problema ao criar novo membro'];
		}
		return ['status' => true, 'message' => 'Membro adicionado com sucesso'];
	}

	public function removeMember($id, $memberId)
	{
        $project = $this->repository->find($id);

        foreach($project->members as $member) 
        {
            if ($member->id == $memberId)
            {
				try {
					$member->delete();
				} catch(ValidatorException $e) {
			        return ['status' => false, 'message' => 'Problema ao remover membro'];
				}
                return ['status' => true, 'message' => 'Membro excluído com sucesso'];
            }
        }

        return ['status' => false, 'message' => 'Membro não encontrado'];
	}

    public function isMember($id, $memberId)
    {
        $project = $this->repository->find($id);

        foreach($project->members as $member) 
        {
            if ($member->id == $memberId)
            {
                return true;
            }
        }
        return false;
    }

}