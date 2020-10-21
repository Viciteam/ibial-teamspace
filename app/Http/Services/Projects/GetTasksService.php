<?php

namespace App\Http\Services\Projects;

use App\Repositories\ProjectsRepository;



use App\Http\Services\BaseService;

class GetTasksService extends BaseService
{   
    private $projects;

    public function __construct(
        ProjectsRepository $projectsRepo
    ){
        $this->projects = $projectsRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($id)
    {   
        $updated_project = $this->projects->task($id);
        return $updated_project;
    }

}
