<?php

namespace App\Models;

use App\Models\BaseModel;

class MembersModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'team_members';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'team_id',
        'project_id'
    ];

    public $hidden = [];

    public $rules = [
        'user_id' => 'sometimes|required',
        'team_id' => 'sometimes|required',
        'project_id' => 'sometimes|required'
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
