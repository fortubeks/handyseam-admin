<?php

namespace App\Http\Controllers;

use App\Services\UserKPIService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userKPIService;

    public function __construct(UserKPIService $userKPIService)
    {
        $this->userKPIService = $userKPIService;
    }

    public function index()
    {
        return view('material.dashboard', [
            'verifiedUsersCount' => $this->userKPIService->getVerifiedUsersCount(),
            'churnedUsersCount' => $this->userKPIService->getChurnedDormantUsers(), //inactive
            'activeUsersCount' => $this->userKPIService->getActiveUsersCount(), //active users
            'mrr' => $this->userKPIService->getMrr(), //MRR
        ]);
    }
}
