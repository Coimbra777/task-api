<?php

namespace App\Http\Controllers;

use App\Logs\LogService;
use App\Helpers\ApiResponse;
use Laravel\Lumen\Routing\Controller;

class LogController extends Controller
{
    private LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index(?string $id = null)
    {
        $logs = $this->logService->getLogs($id);

        return ApiResponse::success($logs);
    }
}
