<?php

namespace App\Http\Services\Teams;

use App\Repositories\TeamsRepository;



use App\Http\Services\BaseService;

class InjectTeamsService extends BaseService
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
        $injected_data = $this->teams->create($data);
        return $this->absorb($injected_data);
    }

}
