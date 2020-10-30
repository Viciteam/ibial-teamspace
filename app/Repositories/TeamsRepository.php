<?php


namespace App\Repositories;

use App\Models\TeamsModel;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class TeamsRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $teams_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        TeamsModel $teamsModel
    ){
        $this->teams_model = $teamsModel;
    }

    public function create($data)
    {

        $teams = $this->teams_model->init($data);

        if (!$teams->validate($data)) {
            $errors = $teams->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Team Space.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion 
        if (!$teams->save()) {
            $errors = $teams->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Team Space.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully saved the Team Space.',
            'data' => [
                'teams' => $teams->id,
            ],
        ];
    }
    
    public function edit($data)
    {
        $teams = $this->teams_model->find($data['teams_id']);

        // if not found, return false
        if (!$teams) {
            return [
                'status' => 400,
                'message' => 'Team Details not found',
                'data' => [],
            ];
        }

        // unset id
        if (isset($data['teams_id'])) {
            unset($data['teams_id']);
        }

        $teams->fill($data);

        //region Data insertion
        if (!$teams->save()) {
            $errors = $teams->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully updated the Team Space.',
            'data' => $data,
        ];
    }

    public function detele($id)
    {
        $teams = $this->teams_model->find($id);

        if (!$teams) {
            return [
                'status' => 400,
                'message' => 'Team Details not found',
                'data' => [],
            ];
        }
        //endregion Existence check

        //region Data deletion
        if (!$teams->delete()) {
            $errors = $teams->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully deleted the Team Space.',
            'data' => [],
        ];
    }
    
    public function details($id)
    {
        $teams = $this->returnToArray($this->teams_model->find($id));

        if(empty($teams)){
            return [
                'status' => 400,
                'message' => 'Team Details not found',
                'data' => [],
            ];
        }
        
        return [
            'status' => 200,
            'message' => 'Successfully fetched the team details.',
            'data' => $teams,
        ];
    }

    
    
}
