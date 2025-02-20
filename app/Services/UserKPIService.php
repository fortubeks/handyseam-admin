<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserKPIService
{
    private $now;
    private $oneWeekAgo;
    private $oneMonthAgo;
    private $threeMonthsAgo;

    public function __construct()
    {
        $this->now = Carbon::now();
        $this->oneWeekAgo = Carbon::now()->subWeek();
        $this->oneMonthAgo = Carbon::now()->subMonth();
        $this->threeMonthsAgo = Carbon::now()->subMonths(3);
    }

    public function getAllUsersCount()
    {
        return User::where('user_type', 'admin')->count();
    }

    public function getUnverifiedUsersCount()
    {
        return User::whereNull('email_verified_at')->where('user_type', 'admin')->count();
    }

    public function getActiveUsersCount()
    {
        return User::whereNotNull('email_verified_at')
            ->where('user_type', 'admin')
            ->whereHas('orders', function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subMonth());
            }, '>', 5)
            ->count();
    }

    public function getMrr()
    {
        // $mrr = Subscription::join('packages', 'subscriptions.package_id', '=', 'packages.id')
        //     ->where('subscriptions.package_id', 2)
        //     ->where('subscriptions.expires_at', '>', Carbon::now())
        //     ->sum('packages.amount');
        $mrr = DB::table('subscriptions as s')
            ->join('packages as p', 's.package_id', '=', 'p.id')
            ->where('s.package_id', 2)
            ->where('s.expires_at', '>', now())
            ->select(DB::raw('SUM(p.amount) AS MRR'))
            ->value('MRR');
        return $mrr;
    }

    public function getVerifiedUsersWithoutOrdersCount()
    {
        //getVerifiedUsersWithoutOrdersCount
        return User::whereNotNull('email_verified_at')
            ->where('user_type', 'admin')
            ->whereDoesntHave('orders')
            ->count();
    }

    public function getOneTimeUsersCount()
    {
        return User::whereNotNull('email_verified_at')
            ->where('user_type', 'admin')
            ->whereHas('orders', function ($query) {
                $query->havingRaw('COUNT(*) = 1');
            }, '=', 1)
            ->count();
    }

    public function getSlightlyDormantUsersCount()
    {
        $_oneWeekAgo = $this->oneWeekAgo;
        // 1. Slightly Dormant (No orders in 1-4 weeks)
        return User::whereDoesntHave('orders', function ($query) use ($_oneWeekAgo) {
            $query->where('created_at', '>=', $_oneWeekAgo);
        })->whereHas('orders', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })->count();
    }

    public function getModeratelyDormantUsersCount()
    {
        $_oneMonthAgo = $this->oneMonthAgo;
        // 2. Moderately Dormant (No orders in 1-4 months)
        return User::whereDoesntHave('orders', function ($query) use ($_oneMonthAgo) {
            $query->where('created_at', '>=', $_oneMonthAgo);
        })->whereHas('orders', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })->count();
    }

    public function getHighlyDormantUsersCount()
    {
        $_threeMonthsAgo = $this->threeMonthsAgo;
        // 3. Highly Dormant (No orders in 4+ months)
        return User::whereDoesntHave('orders', function ($query) use ($_threeMonthsAgo) {
            $query->where('created_at', '>=', $_threeMonthsAgo);
        })->whereHas('orders', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })->count();
    }

    public function getChurnedDormantUsers()
    {
        //these users have created more than 1 order but havent created any in the last 2 months
        return User::where('user_type', 'admin')->whereDoesntHave('orders', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subMonths(2));
        })->whereHas('orders', function ($query) {
            $query->havingRaw('COUNT(*) > 1');
        })->count();
    }

    public function getInactiveDormantUsers()
    {
        //these users have created only 1 order and have not created any after that
        return User::where('user_type', 'admin')
            ->whereHas('orders', function ($query) {
                $query->havingRaw('COUNT(*) = 1');
            }, '=', 1)
            ->count();
    }
}
