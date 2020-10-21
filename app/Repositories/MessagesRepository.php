<?php


namespace App\Repositories;

use App\Models\MessageHistoryModel;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;

/**
 * Class FundRepository
 *
 * @package App\Data\Repositories\Users
 */
class MessagesRepository extends BaseRepository
{
    /**
     * Declaration of Variables
     */
    private $history;

    /**
     * PropertyRepository constructor.
     * @param Fund 
     */
    public function __construct(
        MessageHistoryModel $messageHistory
    ){
        $this->history = $messageHistory;
    }

    public function create($data)
    {

        $message  = $this->history->init($data);

        if (!$message ->validate($data)) {
            $errors = $message ->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while validating the Message History.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        //region Data insertion 
        if (!$message ->save()) {
            $errors = $message ->getErrors();
            return [
                'status' => 500,
                'message' => 'An error has occurred while saving the Message History.',
                'data' => [
                    'errors' => $errors,
                ],
            ];
        }

        return [
            'status' => 200,
            'message' => 'Successfully saved the Message History.',
            'data' => [
                'message' => $message ->id,
            ],
        ];
    }
    
    
}
