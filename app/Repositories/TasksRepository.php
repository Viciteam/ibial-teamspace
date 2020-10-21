<?php


namespace App\Repositories;

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
class TasksRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $tasks_model;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        TasksModel $tasksModel
    ){
        $this->tasks_model = $tasksModel;
    }

    public function create($data)
    {

        $tasks = $this->tasks_model->init($data);

        if (!$tasks->validate($data)) {
            $errors = $tasks->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Task.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion 
        if (!$tasks->save()) {
            $errors = $tasks->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Task.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully saved the Task.',
            'data' => [
                'task' => $tasks->id,
            ],
        ];
    }
    
    public function edit($data)
    {
        $tasks = $this->tasks_model->find($data['task_id']);

        // if not found, return false
        if (!$tasks) {
            return [
                'status' => 400,
                'message' => 'Task Details not found',
                'data' => [],
            ];
        }

        // unset id
        if (isset($data['task_id'])) {
            unset($data['task_id']);
        }

        $tasks->fill($data);

        //region Data insertion
        if (!$tasks->save()) {
            $errors = $tasks->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully updated the Task.',
            'data' => $data,
        ];
    }

    public function detele($id)
    {
        $tasks = $this->tasks_model->find($id);

        if (!$tasks) {
            return [
                'status' => 400,
                'message' => 'Task Details not found',
                'data' => [],
            ];
        }
        //endregion Existence check

        //region Data deletion
        if (!$tasks->delete()) {
            $errors = $tasks->getErrors();
            return [
                'status' => 500,
                'message' => 'Something went wrong.',
                'data' => $errors,
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully deleted the Task.',
            'data' => [],
        ];
    }

    public function details($id)
    {
        $tasks = $this->tasks_model->find($id);

        if (!$tasks) {
            return [
                'status' => 400,
                'message' => 'Task Details not found',
                'data' => [],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully pulled the Task.',
            'data' => $tasks->toArray(),
        ];
    }
    
    
}
