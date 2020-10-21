<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Task\InjectTaskService;
use App\Http\Services\Task\EditTaskService;
use App\Http\Services\Task\DeleteTaskService;
use App\Http\Services\Task\DetailsService;

class TaskController extends Controller
{
    // insert team
    public function inject(
        Request $request,
        InjectTaskService $task
    )
    {
        $data = $request->all();
        return $task->handle($data);
    }

    // update team details as per id
    public function edit(
        Request $request,
        EditTaskService $task,
        $id
    )
    {
        $data = $request->all();
        $data['task_id'] = $id;
        return $task->handle($data);
    }

    // delete team details
    public function delete(
        DeleteTaskService $task,
        $id
    )
    {
        return $task->handle($id);
    }

    public function details(
        DetailsService $task,
        $id
    )
    {
        return $task->handle($id);
    }

}
