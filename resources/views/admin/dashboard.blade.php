@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Dashboard</h4>
                <div>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">RentUSDT</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Stats Section -->
        <div class="col-lg-12">
            <div class="row">
                <!-- Total Asset -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Asset</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$250,000</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-info rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-bank fs-22 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Rented USDT -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Rented USDT
                                    </p>
                                    <h4 class="mt-1 mb-0 fw-medium">$120,000</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-warning rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-dollar-circle fs-22 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Total Withdraw USDT -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Withdraw
                                        USDT</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$85,000</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-danger rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-upload fs-22 text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Given Commission -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Given Commission
                                    </p>
                                    <h4 class="mt-1 mb-0 fw-medium">$12,300</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-secondary rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-hand-cash fs-22 text-secondary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Active Users -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Active Users</p>
                                    <h4 class="mt-1 mb-0 fw-medium">{{ $activeUsers }}</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-success rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-user fs-22 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Today's Credit Fund -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Today's Credit</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$1,200</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-success rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-arrow-up-circle fs-22 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Today's Withdraw Fund -->
                <div class="col-md-3 col-lg-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Today's Withdraw
                                    </p>
                                    <h4 class="mt-1 mb-0 fw-medium">$950</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-danger rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-arrow-down-circle fs-22 text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Withdraw Applications -->
                <div class="col-md-3 mb-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Withdraw
                                        Applications</p>
                                    <h4 class="mt-1 mb-0 fw-medium">35 Pending</h4>
                                </div>
                                <div class="col-3 text-end">
                                    <div
                                        class="thumb-md border-dashed border-warning rounded d-flex justify-content-center align-items-center mx-auto">
                                        <i class="iconoir-clock fs-22 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--end row-->
        </div><!--end col-->
    </div><!--end row-->


    <div class="row justify-content-center">
        <div class="col-md-12 order-1 order-lg-2">
            <!-- ✅ TODAY'S CREDIT TABLE -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Today's Credit Fund</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-1.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">John Carter</h6>
                                                <small class="text-muted">UID: #1021</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#TXN78652</td>
                                    <td>$150</td>
                                    <td>06 Nov 2025</td>
                                    <td>10:35 AM</td>
                                    <td><span class="badge bg-success-subtle text-success">Complete</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-2.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Emily Stone</h6>
                                                <small class="text-muted">UID: #1058</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#TXN78596</td>
                                    <td>$300</td>
                                    <td>06 Nov 2025</td>
                                    <td>09:12 AM</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Pending</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-3.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Ryan Thomas</h6>
                                                <small class="text-muted">UID: #1092</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>#TXN78450</td>
                                    <td>$75</td>
                                    <td>06 Nov 2025</td>
                                    <td>08:42 AM</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Cancelled</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ✅ TODAY'S WITHDRAW TABLE -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Today's Withdraw Requests</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>BEP20 Wallet Address</th>
                                    <th>Withdraw Type</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-4.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Sophia Brown</h6>
                                                <small class="text-muted">UID: #2025</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>0xA13bC9D0E1F67890...</code></td>
                                    <td>Commission</td>
                                    <td>$85</td>
                                    <td>06 Nov 2025</td>
                                    <td><span class="badge bg-info-subtle text-info">Send</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-5.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Michael Lee</h6>
                                                <small class="text-muted">UID: #2031</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>0xB44cD1E5A7F90123...</code></td>
                                    <td>Total Withdraw</td>
                                    <td>$250</td>
                                    <td>06 Nov 2025</td>
                                    <td><span class="badge bg-warning-subtle text-warning">In Review</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-6.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Ava Johnson</h6>
                                                <small class="text-muted">UID: #2048</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>0xZ91aC3E4B5F60678...</code></td>
                                    <td>Commission</td>
                                    <td>$40</td>
                                    <td>06 Nov 2025</td>
                                    <td><span class="badge bg-danger-subtle text-danger">Address Not
                                            Correct</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ✅ TODAY'S JOINED USERS -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="card-title">Today's Joined Users</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <!-- <th>Country</th> -->
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayUsers as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ !empty($user) && !empty($user->avatar) ? asset('storage/'.$user->avatar) : asset('admin/assets/images/users/avatar-1.jpg') }}" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">UID: #0010{{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <!-- <td>USA</td> -->
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <!-- <span class="badge bg-success-subtle text-success">Active</span> -->
                                        @if($user->status == 1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- <a href="#"><i class="las la-eye text-secondary fs-18"></i></a> -->
                                        <a href="{{ route('admin.users.edit', $user->id) }}"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to deactivate this user?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn p-0 border-0 bg-transparent" title="Delete">
                                                <i class="las la-trash-alt text-secondary fs-18"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                <!-- <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="assets/images/users/user-8.jpg" height="40"
                                                class="me-3 rounded" alt="">
                                            <div>
                                                <h6 class="mb-0">Jessica Miller</h6>
                                                <small class="text-muted">UID: #3019</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>jessicamiller@mail.com</td>
                                    <td>India</td>
                                    <td>06 Nov 2025</td>
                                    <td><span class="badge bg-warning-subtle text-warning">Pending</span></td>
                                    <td>
                                        <a href="#"><i class="las la-eye text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-edit text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
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

@push('scripts')
<!-- <script src="{{ asset('rentus/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('rentus/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('rentus/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('rentus/assets/js/pages/index.init.js') }}"></script>
<script src="{{ asset('rentus/assets/js/DynamicSelect.js') }}"></script>
<script src="{{ asset('rentus/assets/js/app.js') }}"></script> -->
@endpush