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

    public function teams($id)
    {
        // get teams as per project
        $project_member_list = $this->returnToArray($this->member->where("project_id", "=", $id)->get());

        if(empty($project_member_list)){
            return [
                'status' => 400,
                'message' => 'Project has no teams yet',
                'data' => [],
            ];
        }

        // get teams from members list
        $teams = [];
        foreach ($project_member_list as $pmlkey => $pmlvalue) {
            array_push($teams, $pmlvalue['team_id']);
        }
        $teams = array_unique($teams);


        // get team details
        $team_details = [];
        foreach ($teams as $tkey => $tvalue) {
            $team_detail = $this->returnToArray($this->teams->where("id", "=", $tvalue)->first());
            array_push($team_details, $team_detail);
        }

        return [
            'status' => 200,
            'message' => 'Successfully return teams from Projects.',
            'data' => $team_details,
        ];
    }
    
    public function task($id)
    {
        $teams_list = $this->returnToArray($this->task->where("task_project", "=", $id)->get());

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
            'data' => $teams_list,
        ];
    }
    
}
