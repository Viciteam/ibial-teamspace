<?php

namespace App\Models;

use App\Models\BaseModel;

class TasksModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'task';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'task_name',
        'task_desc',
        'task_status',
        'task_due',
        'task_priority',
        'task_owner',
        'task_assignee',
        'task_project'
    ];

    public $hidden = [];

    public $rules = [
        'task_name' => 'sometimes|required',
        'task_desc' => 'sometimes|required',
        'task_status' => 'sometimes|required',
        'task_due' => 'sometimes|required',
        'task_priority' => 'sometimes|required',
        'task_owner' => 'sometimes|required',
        'task_assignee' => 'sometimes|required',
        'task_project' => 'sometimes|required'
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
