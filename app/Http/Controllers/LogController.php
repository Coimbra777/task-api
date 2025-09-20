<?php

namespace App\Http\Controllers;

use App\Logs\LogService;
use App\Helpers\ApiResponse;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{
    private LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index(Request $request)
    {
        $id = $request->query('id');
        $logs = $this->logService->getLogs($id);

        return ApiResponse::success($logs);
    }
}
