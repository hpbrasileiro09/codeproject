<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Validators\ProjectValidator;

use \Prettus\Validator\Exceptions\ValidatorException;

class ProjectService 
{

	/**
	* @var ProjectRepository
	*/
	protected $repository;

	/**
	* @var ProjectMemberRepository
	*/
	protected $member;

	/**
	* @var ProjectValidator
	*/
	protected $validator;

	public function __construct(
		ProjectRepository $repository,
		ProjectMemberRepository $member,
		ProjectValidator $validator)
	{
		$this->repository = $repository;
		$this->member = $member;
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

	public function addMember($id, $userId)
	{
		$data = [
			'project_id' => $id,
			'member_id' => $userId,
		];
		try {
			$this->member->create($data);
		} catch(\Exception $e) {
			return ['status' => false, 'message' => 'Problema ao criar novo membro'];
		}
		return ['status' => true, 'message' => 'Membro adicionado com sucesso'];
	}

	public function removeMember($id, $memberId)
	{
 		try {
            $this->member->find($memberId)->delete();
        	return ['status' => true, 'message' => 'Membro excluído com sucesso'];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Problema ao remover membro'];
        }
	}

    public function isMember($id, $userId)
    {
 		try {
            if (count($this->member->findWhere(['project_id' => $id, 'member_id' => $userId]))) {
            	return true;
        	}
        } catch (\Exception $e) {
            return false;
        }
        return false;
    }

}