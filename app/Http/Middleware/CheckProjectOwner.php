<?php

namespace CodeProject\Http\Middleware;

use CodeProject\Repositories\ProjectRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Closure;

class CheckProjectOwner
{

    public function __construct(
        ProjectRepository $repository
    ) {
        $this->repository = $repository;
    }   

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = Authorizer::getResourceOwnerId();
        $projectId = $request->project;

        if ($this->repository->isOwner($projectId, $userId) == false)
        {
            return response()->json([ 'error' => 'Access forbidden' ]);
        }

        return $next($request);
    }
}
