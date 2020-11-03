<?php

namespace App\Http\Services\Messages;

use App\Repositories\MessagesRepository;



use App\Http\Services\BaseService;

class InjectMessageHistoryService extends BaseService
{   
    private $history;

    public function __construct(
        MessagesRepository $messageHisto
    ){
        $this->history = $messageHisto;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        $inject_message_history = $this->history->create($data);
        return $this->absorb($inject_message_history);
    }

}
