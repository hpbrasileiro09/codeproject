<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
	public function transform(User $member)
	{
		return [
			'member_id' => $member->id,
			'member_name' => $member->name,
		];
	}
}