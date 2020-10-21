<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\Messages\InjectMessageHistoryService;

class MessageHistoryController extends Controller
{
    // insert team
    public function inject(
        Request $request,
        InjectMessageHistoryService $message
    )
    {
        $data = $request->all();
        return $message->handle($data);
    }

}
