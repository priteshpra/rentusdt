@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-8 mx-auto">

            <div class="card">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>

                <div class="card-body">
                    {{-- SUCCESS MESSAGE --}}
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    {{-- ERROR MESSAGES --}}
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <?php
                    if (!$user) {
                    ?>
                        <form action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                        <?php } else { ?>
                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                            <?php }   ?>
                            <div class="row">

                                {{-- Name --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text"
                                        name="name"
                                        class="form-control"
                                        value="{{ old('name', $user->name ?? '') }}"
                                        required>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                        name="email"
                                        class="form-control"
                                        value="{{ old('email', $user->email ?? '') }}"
                                        required>
                                </div>

                                {{-- Contact --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact</label>
                                    <input type="text"
                                        name="contact"
                                        class="form-control"
                                        value="{{ old('contact', $user->contact ?? '') }}">
                                </div>

                                {{-- Refer Code --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Refer Code</label>
                                    <input type="text"
                                        name="refer_code"
                                        class="form-control"
                                        value="{{ old('refer_code', $user->refer_code ?? '') }}">
                                </div>

                                {{-- Password --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Password (Leave blank to keep same)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <!-- <div class="col-md-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div> -->

                                {{-- Status --}}
                                @php $status = old('status', $user->status ?? ''); @endphp
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                {{-- Total USDT (readonly) --}}
                                <!-- <div class="col-md-6 mb-3">
                                <label class="form-label">Total USDT</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $user->total_usdt ?? '' }} USDT"
                                    readonly>
                            </div> -->

                                {{-- Assign % Rate --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Assign Return Rate (%)</label>
                                    <input type="number"
                                        name="assign_rate"
                                        class="form-control"
                                        value="{{ old('assign_rate', $user->assign_rate ?? '') }}"
                                        placeholder="Enter % rate"
                                        min="1"
                                        max="100">
                                </div>

                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>

                            </form>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection