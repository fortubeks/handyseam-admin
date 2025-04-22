<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        //add where clause if $request has user_id
        if ($request->input('user_id')) {
            $orders = Order::where('user_id', $request->input('user_id'))->latest()->with('user.appSetting')->paginate(15)->appends($request->query());
        } else {
            $orders = Order::latest()->with('user.appSetting')->paginate(15);
        }
        $title = 'All Orders';
        return view('material.orders.index', compact('orders', 'title'));
    }
}
