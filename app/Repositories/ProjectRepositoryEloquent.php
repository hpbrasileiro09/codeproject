<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;
use CodeProject\Validators\ProjectValidator;;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return ProjectValidator::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function isOwner($projectId, $userId) 
    {
        if (count($this->findWhere(['id' => $projectId, 'owner_id' => $userId])))
        {   
            return true;
        }
        return false;
    }

    public function isOwner_($projectId, $userId) 
    {
        $resp = $this->findWhere(['id' => $projectId, 'owner_id' => $userId]);
        if ($resp == '[]')
        {   
            return false;
        }
        return true;
    }

    public function hasMember($projectId, $memberId)
    {
        $project = $this->find($projectId);

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