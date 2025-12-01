@extends('layouts.app')

@section('title', 'User Profile')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Profile</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Rent USDT</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif
<div class="row justify-content-center">
    {{-- Left Column: Profile Summary --}}
    <div class="col-md-4">
        {{-- Profile Card --}}
        <div class="card">
            <div class="card-body p-4 rounded text-center img-bg"></div>

            <div class="card-body mt-n6">
                <div class="d-flex align-items-center mb-3">
                    <div class="position-relative">
                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('rentus/assets/images/users/avatar-5.jpg') }}"
                            alt="User Avatar" class="rounded-circle img-fluid"
                            style="height:80px; width:80px; object-fit:cover;">
                    </div>
                    <div class="flex-grow-1 text-truncate ms-3 align-self-end">
                        <h5 class="m-0 fs-3 fw-bold">{{ $user->name }}</h5>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="text-body mb-2 d-flex align-items-center">
                        <i class="iconoir-language fs-20 me-1 text-muted"></i>
                        <span class="fw-semibold">Total Rented :</span> $ {{ number_format($user->total_usdt, 2) }}
                    </div>
                    <div class="text-muted mb-2 d-flex align-items-center">
                        <i class="iconoir-mail-out fs-20 me-1"></i>
                        <span class="fw-semibold">Total Return :</span> $ {{ number_format($user->totalReturn, 2) }}
                    </div>
                    <div class="text-body mb-3 d-flex align-items-center">
                        <i class="iconoir-phone fs-20 me-1 text-muted"></i>
                        <span class="fw-semibold">Today Return :</span> $ {{ number_format($user->todaysReturn, 2) }}
                    </div>
                    <button type="button" class="btn btn-primary d-inline-block" data-bs-toggle="modal"
                        data-bs-target="#rentModal">Rent More USDT</button>
                    <button type="button" class="btn btn-light d-inline-block" data-bs-toggle="modal"
                        data-bs-target="#withdrawModal">Withdraw</button>
                </div>
            </div>
        </div>

        {{-- Personal Info Summary --}}
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Personal Information</h4>
                <a href="{{ route('profile.edit') }}" class="text-muted text-decoration-underline">
                    <i class="iconoir-edit-pencil fs-18 me-1"></i>Edit
                </a>
            </div>
            <div class="card-body pt-0">
                <p class="text-muted fw-medium mb-3">
                    It is a long established fact that a reader will be distracted by the readable content of a page.
                </p>

                <ul class="list-unstyled mb-0">
                    <li>
                        <i class="las la-user me-2 text-secondary fs-22 align-middle"></i>
                        <b>Name</b> : <span id="userName">{{ $user->name }}</span>
                    </li>

                    <li class="mt-2">
                        <i class="las la-id-badge me-2 text-secondary fs-22 align-middle"></i>
                        <b>Profile</b> :
                        <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('rentus/assets/images/users/avatar-1.jpg') }}"
                            alt="profile" class="rounded-circle ms-2"
                            style="height:48px; width:48px; object-fit:cover;">
                    </li>

                    <li class="mt-2">
                        <i class="las la-phone me-2 text-secondary fs-22 align-middle"></i>
                        <b>Phone</b> :
                        <a href="tel:+912345678910" class="text-decoration-none" id="userPhone">+91 {{ $user->contact
                            }}</a>
                    </li>

                    <li class="mt-2">
                        <i class="las la-envelope me-2 text-secondary fs-22 align-middle"></i>
                        <b>Email</b> :
                        <a href="mailto:{{ $user->email }}" class="text-decoration-none" id="userEmail">
                            {{ $user->email }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Right Column: Editable Settings --}}
    <div class="col-md-8">
        {{-- Profile Photo Upload --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Settings</h4>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body pt-0">
                    <div class="form-group mb-4 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Profile Photo</label>
                        <div class="col-lg-9 col-xl-8 d-flex align-items-center">
                            <input type="file" name="avatar" class="form-control" id="profileImage" accept="image/*">
                            <small class="text-muted d-block mt-1">Upload JPG, PNG only</small>
                            @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Name</label>
                        <div class="col-lg-9 col-xl-8">
                            <input class="form-control" name="name" type="text" value="{{ $user->name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Email</label>
                        <div class="col-lg-9 col-xl-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="las la-at"></i></span>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Contact</label>
                        <div class="col-lg-9 col-xl-8">
                            <div class="input-group">
                                <span class="input-group-text"><i class="las la-phone"></i></span>
                                <input type="text" name="contact" class="form-control" value="{{ $user->contact }}"
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                            <button type="submit" class="btn btn-primary">Save Photo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Change Password --}}
        <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Change Password</h4>
            </div>

            <form action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                <div class="card-body pt-0">
                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Current Password</label>
                        <div class="col-lg-9 col-xl-8">
                            <input class="form-control" name="current_password" type="password"
                                placeholder="Current Password">
                            <!-- <a href="#" class="text-primary font-12">Forgot password?</a> -->
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">New Password</label>
                        <div class="col-lg-9 col-xl-8">
                            <input class="form-control" name="new_password" type="password" placeholder="New Password">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-xl-3 col-lg-3 text-end form-label align-self-center">Confirm Password</label>
                        <div class="col-lg-9 col-xl-8">
                            <input class="form-control" type="password" name="confirm_password"
                                placeholder="Re-enter Password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-9 col-xl-8 offset-lg-3">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                            <button type="button" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        {{-- Other Settings --}}
        <!-- <div class="card mt-3">
            <div class="card-header">
                <h4 class="card-title">Other Settings</h4>
            </div>
            <div class="card-body pt-0">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Email_Notifications" checked>
                    <label class="form-check-label" for="Email_Notifications">Email Notifications</label>
                    <span class="form-text text-muted fs-12">Do you need them?</span>
                </div>

                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="API_Access">
                    <label class="form-check-label" for="API_Access">API Access</label>
                    <span class="form-text text-muted fs-12">Enable or disable API access</span>
                </div>
            </div>
        </div> -->
    </div>
</div>

{{-- ===========================
RENT MORE MODAL
============================ --}}
@include('rentus.modals.rent-modal')

{{-- ===========================
WITHDRAW MODAL
============================ --}}
@include('rentus.modals.withdraw-modal')
@endsection