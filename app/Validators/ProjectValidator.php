<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator 
{

	protected $rules = [
		'name' => 'required|max:255',
		'responsible' => 'required|max:255',
		'email' => 'required|email',
		'phone' => 'required',
		'address' => 'required',
	];

}