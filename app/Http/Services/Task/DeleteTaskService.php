<?php

namespace App\Http\Services\Task;

use App\Repositories\TasksRepository;



use App\Http\Services\BaseService;

class DeleteTaskService extends BaseService
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
        $delete_task = $this->task->detele($id);
        return $delete_task;
    }

}
