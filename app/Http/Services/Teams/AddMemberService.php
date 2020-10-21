<?php

namespace App\Http\Services\Teams;

use App\Repositories\MembersRepository;



use App\Http\Services\BaseService;

class AddMemberService extends BaseService
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
    public function handle(array $data)
    {   
        // check if user is already a member
        $ifExist = $this->members->ifUserExist($data);

        if(!empty($ifExist)){
            return [
                'status' => 500,
                'message' => 'User is already a Member of the team',
                'data' => $ifExist,
            ];
        }

        $injected_data = $this->members->create($data);
        return $injected_data;
    }

}

