@extends('material.layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="ms-3">
            <h3 class="mb-0 h4 font-weight-bolder">Users</h3>
            <p class="mb-4">
                Check the active, dormant and inactive users.
            </p>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">MRR</p>
                                <h4 class="mb-0">{{ formatCurrency($mrr) }}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">weekend</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than last week</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Active Users</p>
                                <h4 class="mb-0">{{$activeUsersCount}}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">person</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">MRR</p>
                                <h4 class="mb-0">{{ $slightlyDormantUsersCount }}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">weekend</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+55% </span>than last week</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">All Users</p>
                                <h4 class="mb-0">{{$moderatelyDormantUsersCount}}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">person</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>than last month</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <a href="{{ route('users.index', ['filter' => 'active']) }}" class="text-decoration-none">

                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Active Users</p>
                                <h4 class="mb-0">{{$highlyDormantUsersCount}}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">leaderboard</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-danger font-weight-bolder">-2% </span>than yesterday</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route('users.index', ['status' => 'verified', 'has_orders' => '0']) }}" class="text-decoration-none">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Total Dormant Users</p>
                                <h4 class="mb-0">{{$totalDormantUsers}}</h4>
                            </div>
                            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">weekend</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+5% </span>than yesterday</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

<script>
    window.addEventListener('load', function() {

    });
</script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>