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
            'allUsersCount' => $this->userKPIService->getAllUsersCount(), //all users
            //'unverifiedUsersCount' => $this->userKPIService->getUnverifiedUsersCount(),
            'verifiedWithoutOrdersCount' => $this->userKPIService->getVerifiedUsersWithoutOrdersCount(), //inactive
            //'oneTimeUsersCount' => $this->userKPIService->getOneTimeUsersCount(),
            'verifiedWithOrdersCount' => $this->userKPIService->getActiveUsersCount(), //active users
            'mrr' => $this->userKPIService->getMrr(), //MRR
            //ARR
        ]);
    }
}
