<?php

namespace App\Models;

use App\Models\BaseModel;

class MessageHistoryModel extends BaseModel
{

    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'message_history';

    public $casts = [
        'id' => 'int'
    ];

    protected $fillable = [
        'message_sender',
        'message_reciever',
        'message_mode',
        'message_content'
    ];

    public $hidden = [];

    public $rules = [
        'message_sender' => 'sometimes|required',
        'message_reciever' => 'sometimes|required',
        'message_mode' => 'sometimes|required',
        'message_content' => 'sometimes|required'
    ];

    public function transactions()
     {
         return $this->morphMany();
     }
}
