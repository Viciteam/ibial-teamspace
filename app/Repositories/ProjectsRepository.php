<?php


namespace App\Repositories;

use App\Models\ProjectsModel;
use App\Models\MembersModel;
use App\Models\TeamsModel;
use App\Models\TasksModel;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class ProjectsRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $projects_model;
    private $member;
    private $teams;
    private $task;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        ProjectsModel $projectsModel,
        TeamsModel $teamssModel,
        TasksModel $tasksModel,
        MembersModel $memberModel
    ){
        $this->projects_model = $projectsModel;
        $this->teams = $teamssModel;
        $this->member = $memberModel;
        $this->task = $tasksModel;
    }

    public function create($data)
    {

        $projects = $this->projects_model->init($data);

        if (!$projects->validate($data)) {
            $errors = $projects->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Projects.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion 
        if (!$projects->save()) {
            $errors = $projects->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Projects.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully saved the Projects.',
            'data' => [
                'project' => $projects->id,
            ],
        ];
    }
    
    public function edit($data)
    {
        $projects = $this->projects_model->find($data['project_id']);

        // if not found, return false
        if (!$projects) {
            return [
                'status' => 400,
                'message' => 'Project Details not found',
                'data' => [],
            ];
        }

        // unset id
        if (isset($data['project_id'])) {
            unset($data['project_id']);
        }

        $projects->fill($data);

        //region Data insertion
        if (!$projects->save()) {
            $errors = $projects->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully updated the Projects.',
            'data' => $data,
        ];
    }

    public function detele($id)
    {
        $projects = $this->projects_model->find($id);

        if (!$projects) {
            return [
                'status' => 400,
                'message' => 'Project Details not found',
                'data' => [],
            ];
        }
        //endregion Existence check

        //region Data deletion
        if (!$projects->delete()) {
            $errors = $projects->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully deleted the Projects.',
            'data' => [],
        ];
    }

    public function details($id)
    {
        $projects = $this->projects_model->find($id);

        if (!$projects) {
            return [
                'status' => 400,
                'message' => 'Project Details not found',
                'data' => [],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully deleted the Projects.',
            'data' => $projects->toArray(),
        ];
    }

    public function teams($data)
    {
        $id = $data['team_id'];

        // check if limit and page
        if(isset($data['limit']) || isset($data['page'])){
            if((!isset($data['limit']) || $data['limit'] == "") || (!isset($data['page']) || $data['page'] == "")){
                return [
                    'status' => 500,
                    'message' => 'Missing Limit or Page parameter',
                    'data' => [],
                ];
            }
        }

        // initialize model
        $project_info = $this->teams->where("bussines_id", "=", $id);

        if(isset($data['limit']) && isset($data['page'])){
            // for max pagination
            $for_pagination = $project_info->get()->count();

            // get max number of pages
            $max_pags = $for_pagination / $data['limit'];

            // get skip value
            $skip = ($data['page'] == "1" ? 0 : ($data['page'] == "2" ? $data['limit'] : $data['limit'] * ($data['page'] - 1)));
            $project_info = $project_info->skip($skip)->take($data['limit'])->get();
        } else {
            $project_info = $project_info->get();
        }

        // $project_info = $project_info->get();
        
        // get teams as per project
        $project_member_list = $this->returnToArray($project_info); 

        if(empty($project_member_list)){
            return [
                'status' => 400,
                'message' => 'no more teams',
                'data' => [],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully return teams from Projects.',
            'meta' => [
                'max_pages' => ceil($max_pags)
            ],
            'data' => $project_member_list,
        ];
    }
    
    public function task($data)
    {
        $id = $data['task_id'];

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
        $team_info = $this->task->where("task_project", "=", $id);

        // query data
        if(isset($data['limit']) && isset($data['page'])){
            // for max pagination
            $for_pagination = $team_info->get()->count();

            // get max number of pages
            $max_pags = $for_pagination / $data['limit'];

            // get skip value
            $skip = ($data['page'] == "1" ? 0 : ($data['page'] == "2" ? $data['limit'] : $data['limit'] * ($data['page'] - 1)));
            $team_info = $team_info->skip($skip)->take($data['limit'])->get();
        } else {
            $team_info = $team_info->get();
        }
        
        // convert to array
        $teams_list = $this->returnToArray($team_info);

        if(empty($teams_list)){
            return [
                'status' => 400,
                'message' => 'Project has no task yet',
                'data' => [],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully return teams from Projects.',
            'meta' => [
                'max_pages' => ceil($max_pags)
            ],
            'data' => $teams_list,
        ];
    }
    
}
