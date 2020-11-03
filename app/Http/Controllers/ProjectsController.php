<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Projects\InjectProjectsService;
use App\Http\Services\Projects\EditProjectsService;
use App\Http\Services\Projects\DeleteProjectsService;
use App\Http\Services\Projects\DetailsService;
use App\Http\Services\Projects\GetTeamsService;
use App\Http\Services\Projects\GetTasksService;

class ProjectsController extends Controller
{
    // insert team
    public function inject(
        Request $request,
        InjectProjectsService $project
    )
    {
        $data = $request->all();
        return $project->handle($data);
    }

    // update team details as per id
    public function edit(
        Request $request,
        EditProjectsService $project,
        $id
    )
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $project->handle($data);
    }

    // delete team details
    public function delete(
        DeleteProjectsService $project,
        $id
    )
    {
        return $project->handle($id);
    }

    public function details(
        DetailsService $details,
        $id
    )
    {
        return $details->handle($id);
    }

    // 
    public function teams(
        GetTeamsService $teams,
        $id,
        Request $request
    )
    {
        $data = $request->all();
        $data['team_id'] = $id;
        return $teams->handle($data);
    }

    // 
    public function task(
        GetTasksService $tasks,
        $id,
        Request $request
    )
    {
        $data = $request->all();
        $data['task_id'] = $id;
        return $tasks->handle($data);
    }

}
