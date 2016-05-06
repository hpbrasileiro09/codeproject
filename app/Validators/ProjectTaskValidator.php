<?php

namespace CodeProject\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator {

	protected $rules = [
		'project_id' => 'required|integer',
		'title' => 'required',
		'note' => 'required',
	];
}