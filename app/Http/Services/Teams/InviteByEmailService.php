<?php

namespace App\Http\Services\Teams;

use App\Repositories\MembersRepository;



use App\Http\Services\BaseService;

class InviteByEmailService extends BaseService
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
    public function handle(array $data)
    {   
        $updated_teams = $this->teams->inviteByEmail($data);
        return $this->absorb($updated_teams);
    }

}