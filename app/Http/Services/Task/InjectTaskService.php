<?php

namespace App\Http\Services\Task;

use App\Repositories\TasksRepository;



use App\Http\Services\BaseService;

class InjectTaskService extends BaseService
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
        $inject_tasks = $this->task->create($data);
        return $inject_tasks;
    }

}
