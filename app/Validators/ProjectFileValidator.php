<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'required',
        'file' => 'required|mimes:jpeg,bmp,png,pdf,docx,doc,xls,xlsx',
        'description' => 'required|max:255'
    ];
}