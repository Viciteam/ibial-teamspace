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

    public function teamMembers($data)
    {
        $team_id = $data['team_id'];

        // limit must be paired with page
        if(isset($data['limit']) || isset($data['page'])){
            if((!isset($data['limit']) || $data['limit'] == "") || (!isset($data['page']) || $data['page'] == "")){
                return [
                    'status' => 500,
                    'message' => 'Missing Limit or Page parameter',
                    'data' => [],
                ];
            }
        }

        // init model
        $team_members = $this->members->where("team_id", "=", $team_id);

        
        
        // query data
        if(isset($data['limit']) && isset($data['page'])){
            // for max pagination
            $for_pagination = $team_members->get()->count();

            // get max number of pages
            $max_pags = $for_pagination / $data['limit'];

            // get skip value
            $skip = ($data['page'] == "1" ? 0 : ($data['page'] == "2" ? $data['limit'] : $data['limit'] * ($data['page'] - 1)));
            $team_members = $team_members->skip($skip)->take($data['limit'])->get();

            
            
        } else {
            $team_members = $team_members->get();
        }
        
        $getMember = $this->returnToArray($team_members);

        return [
            'status' => 200,
            'message' => 'Successfully fetched the Member.',
            'meta' => [
                'max_pages' => ceil($max_pags)
            ],
            'data' => $getMember,
        ];
    }
    
    public function inviteByEmail($data)
    {
        foreach ($data['emails'] as $key => $value) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://mail.ibial.com/api/sendemail");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                "hasattachment" => "no",
                "email_body" => 'Good Day!<br /><br />You have been invited to participate in a team collaboration.<br /><a href="https://dev.ibial.com/invite/?team='.$data['team_id'].'&email='.$value.'">Click here</a> to particiapte<br /><br />Cheers!',
                "recipientemail" => $value,
                "recipientname" => "Arphie Balboa",
                "senderemail" => "teams@ibial.email",
                "sendername" => "Ibial Team",
                "subject" => "Team Invitation",
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);

        }

        return [
            'status' => 200,
            'message' => 'Successfully sent the invitations.',
            'data' => [],
        ];
    }
    
}
