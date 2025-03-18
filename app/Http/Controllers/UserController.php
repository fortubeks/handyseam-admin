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
                }, '>', 5)->withCount('orders')->whereHas('appSetting')->paginate(15)->appends($request->query());
        } elseif ($request->input('filter') == 'churned') {
            $users = User::with('appSetting')->where('user_type', 'admin')
                ->whereDoesntHave('orders', function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subMonths(2));
                })
                ->withCount('orders') // Count orders first
                ->having('orders_count', '>', 1) // Filter users with more than 1 order
                ->whereHas('appSetting')
                ->orderByDesc('orders_count')
                ->paginate(15)
                ->appends($request->query());
        } elseif ($request->input('filter') == 'inactive') {
            $users = User::latest()->withCount('orders')->whereHas('appSetting')->where('status', 0)->paginate(15)->appends($request->query());
        } else {
            $users = User::latest()->withCount('orders')->whereHas('appSetting')->paginate(15)->appends($request->query());
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

    public function show(User $user)
    {
        $user = User::with([
            'orders',
            'appSetting',
            'subscriptions.package'
        ])->withCount('orders')->findOrFail($user->id);

        // Get all the user's paid subscriptions
        $paidSubscriptions = $user->subscriptions->where('package_id', 2);

        $ltv = $this->getUserLTV($paidSubscriptions);

        $averageOrdersPerMonth = $this->getUserAverageOrdersPerMonth($user);

        $totalOrdersAmount = $user->orders()->sum('total_amount');

        $latestOrder = $user->orders->sortByDesc('created_at')->first();

        $lastFiveSubscriptions = $user->subscriptions->sortByDesc('created_at')->take(5);

        $lastFiveOrders = $user->orders->sortByDesc('created_at')->take(5);

        return view('material.users.show', compact(
            'user',
            'latestOrder',
            'lastFiveOrders',
            'ltv',
            'lastFiveSubscriptions',
            'averageOrdersPerMonth',
            'totalOrdersAmount'
        ));
    }

    private function getUserLTV($paidSubscriptions)
    {
        // Calculate total revenue generated from this user
        $totalRevenue = $paidSubscriptions->sum(function ($subscription) {
            return $subscription->package->amount;
        });

        // Get first and last subscription date
        $firstSubscription = $paidSubscriptions->sortBy('created_at')->first();
        $lastSubscription = $paidSubscriptions->sortByDesc('created_at')->first();

        // Calculate Customer Lifetime (Months)
        $customerLifetime = 1; // Default 1 month if only one subscription exists
        if ($firstSubscription && $lastSubscription) {
            $customerLifetime = max(1, $firstSubscription->created_at->diffInMonths($lastSubscription->created_at));
        }

        // Calculate Average Revenue Per User (ARPU)
        $arpu = $customerLifetime > 0 ? ($totalRevenue / $customerLifetime) : 0;

        // Calculate Lifetime Value (LTV)
        $ltv = $arpu * $customerLifetime;

        return $ltv;
    }

    private function getUserAverageOrdersPerMonth($user)
    {
        $firstOrderDate = $user->orders()->oldest()->value('created_at');

        if (!$firstOrderDate) {
            return 0;
        }

        $monthsSinceFirstOrder = Carbon::parse($firstOrderDate)->diffInMonths(now()) ?: 1;

        return round($user->orders_count / $monthsSinceFirstOrder);
    }
}
