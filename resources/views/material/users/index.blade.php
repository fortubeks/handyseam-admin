@extends('material.layouts.app')
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">{{$title ?? 'Users '}} table</h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="col-4 ms-md-auto pe-md-3 d-flex align-items-center">
                        <form id="userSearchForm" action="{{ route('user.search') }}" method="GET">
                            <div class="input-group input-group-outline">
                                <label class="form-label">Search by email here...</label>
                                <input name="email" type="email" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" id="userSearchInput">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Business</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Country</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Orders</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Login</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="https://app.handyseam.com/storage/logo_images/{{$user->appSetting->business_logo}}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$user->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$user->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0" data-toggle="tooltip" title="{{$user->appSetting->business_address}}">{{$user->appSetting->business_name}}</p>
                                    </td>
                                    <td class=" text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$user->appSetting->business_currency}}</p>
                                    </td>
                                    <td class=" text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$user->orders_count}}</p>
                                    </td>
                                    <td class=" text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{$user->phone}}</p>
                                    </td>
                                    <td class=" text-sm">
                                        @if($user->status == 'Active')
                                        <span class="badge badge-sm bg-gradient-success">{{$user->status}}</span>
                                        @elseif($user->status == 'Unverified')
                                        <span class="badge badge-sm bg-gradient-warning">{{$user->status}}</span>
                                        @elseif($user->status == 'Verified Without Orders')
                                        <span class="badge badge-sm bg-gradient-info">{{$user->status}}</span>
                                        @elseif($user->status == 'One Time Order Only')
                                        <span class="badge badge-sm bg-gradient-secondary">{{$user->status}}</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$user->last_login}}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                            Show/Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{$users->links()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
    window.addEventListener('load', function() {
        $('#userSearchInput').on('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                $('#userSearchForm').submit();
            }
        });
    });
</script>