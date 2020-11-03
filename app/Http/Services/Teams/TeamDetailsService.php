<?php

namespace App\Http\Services\Teams;

use App\Repositories\TeamsRepository;



use App\Http\Services\BaseService;

class TeamDetailsService extends BaseService
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
        $updated_teams = $this->teams->details($id);
        return $this->absorb($updated_teams);
    }

}
