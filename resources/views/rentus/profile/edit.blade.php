@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
            <h4 class="page-title">Edit Profile</h4>
            <div>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Rent USDT</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Profile Photo</label>
            <div class="d-flex align-items-center">
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('rentus/assets/images/users/avatar-5.jpg') }}"
                    alt="avatar" class="rounded me-3" style="width:70px;height:70px;object-fit:cover;">
                <input type="file" name="avatar" class="form-control-file">
            </div>
            @error('avatar') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact</label>
            <input name="contact" class="form-control" value="{{ old('contact', $user->contact) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Wallet Address (BEP20 only)</label>
            <input name="wallet_address" class="form-control" value="{{ old('contact', $user->wallet_address) }}">
        </div>

        <hr>

        <!-- <h5>Change Password (optional)</h5>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input name="password" type="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
        </div>-->

        <div class="mb-3">
            <button class="btn btn-primary" type="submit">Save Changes</button>
            <a href="{{ route('profile') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection