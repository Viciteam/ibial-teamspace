<?php

namespace App\Http\Services\Teams;

use App\Repositories\TeamsRepository;



use App\Http\Services\BaseService;

class EditTeamsService extends BaseService
{   
    private $teams;

    public function __construct(
        TeamsRepository $teamRepo
    ){
        $this->teams = $teamRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle(array $data)
    {   
        $updated_teams = $this->teams->edit($data);
        return $updated_teams;
    }

}
