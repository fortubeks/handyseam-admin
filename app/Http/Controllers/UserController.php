<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserKPIService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //this returns all the registered users sorted by the latest, get only the users that have a foreign key record in settings table
        $users = [];
        if ($request->input('filter') == 'all') {
            $users = User::latest()->withCount('orders')->whereHas('appSetting')->paginate(15);
        } elseif ($request->input('filter') == 'active') {
            $users = User::whereNotNull('email_verified_at')
                ->where('user_type', 'admin')
                ->whereHas('orders', function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subMonth());
                }, '>', 5)->withCount('orders')->whereHas('appSetting')->paginate(15);
        } elseif ($request->input('filter') == 'inactive') {
            $users = User::latest()->withCount('orders')->whereHas('appSetting')->where('status', 0)->paginate(15);
        } else {
            $users = User::latest()->withCount('orders')->whereHas('appSetting')->paginate(15);
        }
        $title = 'All Users';
        return view('material.users.index', compact('users', 'title'));
    }

    public function dashboard()
    {
        $userKPIService = new UserKPIService();

        $slightlyDormantUsersCount = $userKPIService->getSlightlyDormantUsersCount();
        $moderatelyDormantUsersCount = $userKPIService->getModeratelyDormantUsersCount();
        $highlyDormantUsersCount = $userKPIService->getHighlyDormantUsersCount();
        $totalDormantUsers = $slightlyDormantUsersCount + $moderatelyDormantUsersCount + $highlyDormantUsersCount;

        return view('material.users.dashboard', [
            'allUsersCount' => $userKPIService->getAllUsersCount(), //all users
            'unverifiedUsersCount' => $userKPIService->getUnverifiedUsersCount(),
            'slightlyDormantUsersCount' => $slightlyDormantUsersCount, //inactive
            'moderatelyDormantUsersCount' => $moderatelyDormantUsersCount,
            'highlyDormantUsersCount' => $highlyDormantUsersCount,
            'totalDormantUsers' => $totalDormantUsers,
            'activeUsersCount' => $userKPIService->getActiveUsersCount(), //active users
            'getOneTimeUsersCount' => $userKPIService->getOneTimeUsersCount(),
            'getVerifiedUsersWithoutOrdersCount' => $userKPIService->getVerifiedUsersWithoutOrdersCount(),
            'mrr' => $userKPIService->getMrr(),
        ]);
    }

    public function search(Request $request)
    {
        //this returns all the registered users sorted by the latest, get only the users that have a foreign key record in settings table
        $users = User::where('email', 'like', '%' . request('email') . '%')
            ->withCount('orders')
            ->whereHas('appSetting')
            ->paginate(15);
        $title = 'All Users';
        return view('material.users.index', compact('users', 'title'));
    }
}
