<?php

namespace App\Models;

use App\Models\BaseModel;

class TeamsModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'teams';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'team_name',
        'team_desc'
    ];

    public $hidden = [];

    public $rules = [
        'team_name' => 'sometimes|required',
        'team_desc' => 'sometimes|required',
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
