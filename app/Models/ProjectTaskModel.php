<?php

namespace App\Models;

use App\Models\BaseModel;

class TeamsModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'project_task';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'project_id',
        'task_id'
    ];

    public $hidden = [];

    public $rules = [
        'project_id' => 'sometimes|required',
        'task_id' => 'sometimes|required',
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
