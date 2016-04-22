<?php

namespace CodeProject\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator {

	protected $rules = [
		'project_id' => 'required|integer',
		'name' => 'required',
		'due_date' => 'required|date',
		'start_date' => 'required|date',
		'status' => 'required',
	];
}