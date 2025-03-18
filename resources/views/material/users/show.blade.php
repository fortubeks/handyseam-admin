@extends('material.layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xl-6 mb-xl-0 mb-4">
                    <div class="card shadow-xl pb-0 p-3">
                        <div class="row gx-4 mb-2">
                            <div class="col-auto">
                                <div class="avatar avatar-xl position-relative">
                                    <img src="https://app.handyseam.com/storage/logo_images/{{$user->appSetting->business_logo}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{$user->name}}
                                    </h5>
                                    <p class="mb-0 font-weight-normal text-sm">
                                        {{$user->email}}
                                    </p>
                                </div>
                                <hr class="horizontal gray-light my-4">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Business Name:</strong> &nbsp; {{$user->appSetting->business_name}}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Currency:</strong> &nbsp; {{$user->appSetting->business_currency}}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Phone:</strong> &nbsp; {{$user->phone}}</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Location:</strong> &nbsp; {{$user->appSetting->business_address}}</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-md-4 col-4">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">account_balance</i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h6 class="text-center mb-0">Orders</h6>
                                    <span class="text-xs">Belong Interactive</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">{{$user->orders->count()}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-4">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">account_balance_wallet</i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h6 class="text-center mb-0">Lifetime Value</h6>
                                    <span class="text-xs">Freelance Payment</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">{{formatCurrency($ltv)}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-4">
                            <div class="card">
                                <div class="card-header mx-4 p-3 text-center">
                                    <div class="icon icon-shape icon-lg bg-gradient-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">account_balance_wallet</i>
                                    </div>
                                </div>
                                <div class="card-body pt-0 p-3 text-center">
                                    <h6 class="text-center mb-0">Customers</h6>
                                    <span class="text-xs">Freelance Payment</span>
                                    <hr class="horizontal dark my-3">
                                    <h5 class="mb-0">{{$user->customers->count()}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">User Metrics</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pb-0">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Average Orders Monthly</h6>
                                <span class="text-xs">#MS-415646</span>
                            </div>
                            <div class="d-flex align-items-center font-weight-bold text-sm">
                                {{$averageOrdersPerMonth}}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Last Order Date</h6>
                                <span class="text-xs">#MS-415646</span>
                            </div>
                            <div class="d-flex align-items-center font-weight-bold text-sm">
                                {{$latestOrder ? $latestOrder->created_at->format('d F Y') : 'N/A' }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Last Login Date</h6>
                                <span class="text-xs">#MS-415646</span>
                            </div>
                            <div class="d-flex align-items-center font-weight-bold text-sm">
                                {{ $user->last_login ? $user->last_login : $latestOrder->created_at->format('d F Y') }}
                            </div>
                        </li>
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">Total Orders Amount</h6>
                                <span class="text-xs">#MS-415646</span>
                            </div>
                            <div class="d-flex align-items-center font-weight-bold text-sm">
                                {{$user->appSetting->business_currency}}{{number_format($totalOrdersAmount,2)}}
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Last 5 Orders</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pb-0">
                    <ul class="list-group">
                        @foreach($lastFiveOrders as $order)
                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$order->created_at->format('d F Y')}}</h6>
                                <span class="text-xs">{{$order->order_type}}</span>
                            </div>
                            <div class="d-flex align-items-center text-sm">
                                {{$user->appSetting->business_currency}}{{number_format($order->total_amount,2)}}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-0">Subscriptions</h6>
                        </div>
                        <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                            <i class="material-symbols-rounded me-2 text-lg">date_range</i>
                            <small>since {{$user->created_at->format('d F Y')}}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
                    <ul class="list-group">
                        @foreach($lastFiveSubscriptions as $subscription)

                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-symbols-rounded text-lg">expand_less</i></button>
                                <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark text-sm">{{ $subscription->package->name }}</h6>
                                    <span class="text-xs">{{ $subscription->created_at->format('d F Y, \a\t h:i A') }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                + {{formatCurrency($subscription->package->amount)}}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    window.addEventListener('load', function() {

    });
</script>