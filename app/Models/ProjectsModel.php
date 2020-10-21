<?php

namespace App\Models;

use App\Models\BaseModel;

class ProjectsModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'project';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'project_name',
        'project_desc',
        'project_focus'
    ];

    public $hidden = [];

    public $rules = [
        'project_name' => 'sometimes|required',
        'project_desc' => 'sometimes|required',
        'project_focus' => 'sometimes|required',
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
