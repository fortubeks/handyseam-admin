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
                                {{ $user->last_login ? $user->last_login : 'N/A' }}
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
                            <a href="{{url('orders?user_id='.$user->id)}}" class="btn btn-outline-primary btn-sm mb-0">View All</a>
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
            @php
            $recentSubscriptionsCount = $lastFiveSubscriptions->count();
            @endphp
            <div class="card h-100 mb-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-start gap-3">
                        <div>
                            <div class="d-flex align-items-center mb-1">
                                <i class="material-symbols-rounded me-2 text-lg text-dark">workspace_premium</i>
                                <h6 class="mb-0">Recent Subscriptions</h6>
                            </div>
                            <p class="text-sm text-muted mb-0">Latest package activity for this user since {{$user->created_at->format('d F Y')}}</p>
                        </div>
                        <button class="btn btn-outline-dark btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal" data-subscription-action="create">
                            <i class="material-symbols-rounded text-sm align-middle">add</i>
                            <span class="ms-1">Add Subscription</span>
                        </button>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-1">Last 5 entries</h6>
                            <p class="text-xs text-muted mb-0">Use this list to spot expired plans and renew quickly.</p>
                        </div>
                        <span class="badge bg-gradient-light text-dark">{{$recentSubscriptionsCount}} recent</span>
                    </div>
                    <ul class="list-group">
                        @forelse($lastFiveSubscriptions as $subscription)
                        @php
                        $expiresAt = \Illuminate\Support\Carbon::parse($subscription->expires_at);
                        $isExpired = $expiresAt->isPast();
                        $daysLeft = now()->diffInDays($expiresAt, false);
                        $isExpiringSoon = !$isExpired && $daysLeft <= 7;
                            $statusClass=$isExpired ? 'bg-gradient-danger' : ($isExpiringSoon ? 'bg-gradient-warning' : 'bg-gradient-success' );
                            $statusIcon=$isExpired ? 'gpp_bad' : ($isExpiringSoon ? 'schedule' : 'verified' );
                            $statusText=$isExpired ? 'Expired' : ($isExpiringSoon ? 'Expiring soon' : 'Active' );
                            @endphp
                            <li class="list-group-item border-0 px-0 mb-3 border-radius-lg">
                            <div class="border border-radius-lg p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="icon icon-shape icon-sm shadow {{$statusClass}} text-center border-radius-md me-3">
                                            <i class="material-symbols-rounded opacity-10">{{$statusIcon}}</i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                                <h6 class="mb-0 text-sm">{{ $subscription->package->name }}</h6>
                                                <span class="badge {{$isExpired ? 'bg-gradient-danger' : ($isExpiringSoon ? 'bg-gradient-warning text-dark' : 'bg-gradient-success')}}">{{$statusText}}</span>
                                            </div>
                                            <p class="text-sm mb-0 text-dark font-weight-bold">{{ formatCurrency($subscription->package->amount) }}</p>
                                        </div>
                                    </div>
                                    @if($isExpired || $isExpiringSoon)
                                    <button
                                        class="btn btn-outline-dark btn-sm mb-0"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addSubscriptionModal"
                                        data-subscription-action="renew"
                                        data-package-id="{{ $subscription->package_id }}"
                                        data-package-name="{{ $subscription->package->name }}"
                                        data-expires-at="{{ $expiresAt->format('Y-m-d') }}">Renew</button>
                                    @endif
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="bg-gray-100 border-radius-md px-3 py-2 h-100">
                                            <span class="d-flex align-items-center text-xs text-muted mb-1">
                                                <i class="material-symbols-rounded text-sm me-1">calendar_today</i>
                                                Started
                                            </span>
                                            <p class="text-sm text-dark font-weight-bold mb-0">{{ $subscription->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="bg-gray-100 border-radius-md px-3 py-2 h-100">
                                            <span class="d-flex align-items-center text-xs text-muted mb-1">
                                                <i class="material-symbols-rounded text-sm me-1">event_available</i>
                                                Expires
                                            </span>
                                            <p class="text-sm text-dark font-weight-bold mb-0">{{ $expiresAt->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="text-xs text-muted">
                                        @if($isExpired)
                                        Expired {{ abs($daysLeft) }} day{{ abs($daysLeft) === 1 ? '' : 's' }} ago
                                        @elseif($daysLeft === 0)
                                        Expires today
                                        @else
                                        {{ $daysLeft }} day{{ $daysLeft === 1 ? '' : 's' }} remaining
                                        @endif
                                    </span>
                                    <span class="text-xs font-weight-bold {{$isExpired ? 'text-danger' : ($isExpiringSoon ? 'text-warning' : 'text-success')}}">{{$statusText}}</span>
                                </div>
                            </div>
                            </li>
                            @empty
                            <li class="list-group-item border-0 px-0">
                                <div class="border border-dashed border-radius-lg p-4 text-center">
                                    <div class="icon icon-shape icon-md bg-gray-100 shadow text-center border-radius-lg mx-auto mb-3">
                                        <i class="material-symbols-rounded opacity-10 text-dark">subscriptions</i>
                                    </div>
                                    <h6 class="text-sm mb-1">No subscriptions yet</h6>
                                    <p class="text-xs text-muted mb-3">Create the first subscription to start tracking package history for this user.</p>
                                    <button class="btn btn-outline-dark btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal" data-subscription-action="create">Add First Subscription</button>
                                </div>
                            </li>
                            @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addSubscriptionModal" tabindex="-1" aria-labelledby="addHotelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subscriptionModalTitle">Add new subscription for this user</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('subscriptions.store') }}" id="addSubscriptionForm">
                    @csrf
                    <p class="text-sm text-muted mb-3" id="subscriptionModalDescription">Choose a package and set the next expiry date for this user.</p>
                    <select class="form-select mb-3" name="subscription_package_id" id="subscriptionPackageSelect">
                        <option value="">Select Subscription</option>
                        @foreach(getModelList('packages') as $package)
                        <option value="{{ $package->id }}">{{ $package->name }} - {{ formatCurrency($package->amount) }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="expires_at" class="form-control mb-3" id="subscriptionExpiryInput" placeholder="Expiry" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <button type="submit" class="btn btn-primary" id="subscriptionSubmitButton">Create Subscription</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    window.addEventListener('load', function() {
        const subscriptionModal = document.getElementById('addSubscriptionModal');
        const subscriptionForm = document.getElementById('addSubscriptionForm');
        const modalTitle = document.getElementById('subscriptionModalTitle');
        const modalDescription = document.getElementById('subscriptionModalDescription');
        const packageSelect = document.getElementById('subscriptionPackageSelect');
        const expiryInput = document.getElementById('subscriptionExpiryInput');
        const submitButton = document.getElementById('subscriptionSubmitButton');

        if (!subscriptionModal || !subscriptionForm || !modalTitle || !modalDescription || !packageSelect || !expiryInput || !submitButton) {
            return;
        }

        const getNextExpiryDate = function(baseDate) {
            const nextDate = new Date(baseDate);
            nextDate.setMonth(nextDate.getMonth() + 1);

            if (Number.isNaN(nextDate.getTime())) {
                return '';
            }

            return nextDate.toISOString().split('T')[0];
        };

        subscriptionModal.addEventListener('show.bs.modal', function(event) {
            const trigger = event.relatedTarget;
            const action = trigger?.getAttribute('data-subscription-action') || 'create';
            const packageId = trigger?.getAttribute('data-package-id') || '';
            const packageName = trigger?.getAttribute('data-package-name') || 'this package';
            const expiresAt = trigger?.getAttribute('data-expires-at') || '';

            subscriptionForm.reset();
            packageSelect.value = '';
            expiryInput.value = '';
            modalTitle.textContent = 'Add new subscription for this user';
            modalDescription.textContent = 'Choose a package and set the next expiry date for this user.';
            submitButton.textContent = 'Create Subscription';

            if (action === 'renew') {
                packageSelect.value = packageId;
                expiryInput.value = getNextExpiryDate(expiresAt || new Date().toISOString().split('T')[0]);
                modalTitle.textContent = 'Renew subscription';
                modalDescription.textContent = 'Renew ' + packageName + ' and confirm the next expiry date for this user.';
                submitButton.textContent = 'Renew Subscription';
            }
        });
    });
</script>