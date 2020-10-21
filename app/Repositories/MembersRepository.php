<?php


namespace App\Repositories;

use App\Models\MembersModel;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class MembersRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $members;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        MembersModel $membersRepo
    ){
        $this->members = $membersRepo;
    }

    /**
     * Insert Member on a Team
     *
     * @param   array  $data  user_id, team_id, project_id
     *
     * @return  json         return
     */
    public function create($data)
    {

        $member  = $this->members->init($data);

        if (!$member->validate($data)) {
            $errors = $member->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Member Details.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion 
        if (!$member->save()) {
            $errors = $member->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Member Details.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully saved the Member Details.',
            'data' => [
                'member_id' => $member->id,
            ],
        ];
    }

    /**
     * Delete Member 
     *
     * @param   int  $id  member id
     *
     * @return  json       return
     */
    public function detele($id)
    {
        $member = $this->members->find($id);

        if (!$member) {
            return [
                'status' => 400,
                'message' => 'Team Details not found',
                'data' => [],
            ];
        }
        //endregion Existence check

        //region Data deletion
        if (!$member->delete()) {
            $errors = $member->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully removed the Member.',
            'data' => [],
        ];
    }

    public function ifUserExist($data)
    {
        $getMember = $this->members->where([
            ['user_id', "=", $data['user_id']],
            ['team_id', "=", $data['team_id']],
            ['project_id', "=", $data['project_id']]
        ])->get();
        $getMember = $this->returnToArray($getMember);
        
        // if user id is found
        if(!empty($getMember)){
            return $getMember;
        } 

        return [];
    }
    
    
}
