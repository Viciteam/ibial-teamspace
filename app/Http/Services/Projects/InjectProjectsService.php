<?php

namespace App\Http\Services\Projects;

use App\Repositories\ProjectsRepository;



use App\Http\Services\BaseService;

class InjectProjectsService extends BaseService
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
    public function handle(array $data)
    {   
        $inject_project = $this->projects->create($data);
        return $this->absorb($inject_project);
    }

}
