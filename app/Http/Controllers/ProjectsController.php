<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Projects\InjectProjectsService;
use App\Http\Services\Projects\EditProjectsService;
use App\Http\Services\Projects\DeleteProjectsService;
use App\Http\Services\Projects\GetTeamsService;

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

    // delete team details
    public function teams(
        GetTeamsService $project,
        $id
    )
    {
        return $project->handle($id);
    }

}
