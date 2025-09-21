<?php

namespace App\Http\Controllers;

use App\Logs\LogService;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class LogController extends Controller
{
    protected $logService;

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
