<?php

namespace App\Http\Services\Teams;

use App\Repositories\MembersRepository;



use App\Http\Services\BaseService;

class GetMembersService extends BaseService
{   
    private $teams;

    public function __construct(
        MembersRepository $teamRepo
    ){
        $this->teams = $teamRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($team_id)
    {   
        $updated_teams = $this->teams->teamMembers($team_id);
        return $updated_teams;
    }

}