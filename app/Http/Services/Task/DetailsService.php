<?php

namespace App\Http\Services\Task;

use App\Repositories\TasksRepository;



use App\Http\Services\BaseService;

class DetailsService extends BaseService
{   
    private $task;

    public function __construct(
        TasksRepository $takssRepo
    ){
        $this->task = $takssRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($id)
    {   
        $delete_task = $this->task->details($id);
        return $this->absorb($delete_task);
    }

}
