<?php

namespace App\Http\Services\Teams;

use App\Repositories\TeamsRepository;



use App\Http\Services\BaseService;

class DeleteTeamsService extends BaseService
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
    public function handle($id)
    {   
        $delete_teams = $this->teams->detele($id);
        return $delete_teams;
    }

}
