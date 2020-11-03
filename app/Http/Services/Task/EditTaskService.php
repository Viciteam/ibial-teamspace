<?php

namespace App\Http\Services\Task;

use App\Repositories\TasksRepository;



use App\Http\Services\BaseService;

class EditTaskService extends BaseService
{   
    private $task;

    public function __construct(
        TasksRepository $tasksRepo
    ){
        $this->task = $tasksRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        $updated_task = $this->task->edit($data);
        return $this->absorb($updated_task);
    }

}
