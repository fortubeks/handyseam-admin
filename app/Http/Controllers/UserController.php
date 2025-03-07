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

        $activeUserCount = $userKPIService->getActiveUsersCount(); // active users

        $churnedDormantUsersCount = $userKPIService->getChurnedDormantUsers(); // 
        $inactiveDormantUsersCount = $userKPIService->getInactiveDormantUsers(); // dormant users
        $totalDormantUsersCount = $churnedDormantUsersCount + $inactiveDormantUsersCount;

        $unverifiedUsersCount = $userKPIService->getUnverifiedUsersCount(); // unverified users

        $inactiveUsersCount = $userKPIService->getVerifiedUsersWithoutOrdersCount(); // inactive users

        $totalUsersCount = $totalDormantUsersCount + $activeUserCount + $unverifiedUsersCount + $inactiveUsersCount;

        return view('material.users.dashboard', [
            'allUsersCount' => $userKPIService->getAllUsersCount(), //all users
            'unverifiedUsersCount' => $userKPIService->getUnverifiedUsersCount(),
            'churnedDormantUsersCount' => $churnedDormantUsersCount,
            'inactiveDormantUsersCount' => $inactiveDormantUsersCount,
            'totalDormantUsersCount' => $totalDormantUsersCount,
            'activeUsersCount' => $activeUserCount,
            'inactiveUsersCount' => $inactiveUsersCount,
            'totalUsersCount' => $totalUsersCount,
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
