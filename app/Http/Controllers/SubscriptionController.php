<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {
    public function store( Request $request ) {
        $request->validate( [
            'subscription_package_id' => 'required|exists:packages,id',
            'expires_at' => 'required',
            'user_id' => 'required|exists:users,id',
        ] );

        $package = Package::findOrFail( $request->subscription_package_id );

        //create subscription
        Subscription::create( [
            'user_id' => $request->user_id,
            'package_id' => $request->subscription_package_id,
            'expires_at' => $request->expires_at,
            'amount' => $package->amount,
            'status' => 'active',
        ] );

        return redirect()->back()->with( 'success', 'User subscription added successfully.' );
    }
}
