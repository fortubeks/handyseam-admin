<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserKPIService
{
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
}
