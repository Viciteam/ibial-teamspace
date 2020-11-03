<?php

namespace App\Http\Services\Teams;

use App\Repositories\MembersRepository;



use App\Http\Services\BaseService;

class RemoveMemberService extends BaseService
{   
    private $members;

    public function __construct(
        MembersRepository $membersRepo
    ){
        $this->members = $membersRepo;
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function handle($id)
    {   
        $injected_data = $this->members->detele($id);
        return $this->absorb($injected_data);
    }

}

