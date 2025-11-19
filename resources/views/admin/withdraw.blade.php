@extends('layouts.admin')

@section('title', 'Withdrawal History')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Withdrawal History</h4>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <a href="#" class="btn bt btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icofont-calendar fs-5 me-1"></i> This Month <i class="las la-angle-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Today</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">This Year</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end card-header-->

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Transaction ID</th>
                                <th>Withdraw Amount</th>
                                <th>Withdrawal Date</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- Example static rows — replace with @foreach() when dynamic data is available --}}
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('rentus/assets/images/users/avatar-1.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">Alex Johnson</h6>
                                            <p class="fs-12 text-muted mb-0">USA</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">WD-6548</a></td>
                                <td>120 USDT</td>
                                <td>06 Nov 2025 <span>10:25 AM</span></td>
                                <td><span class="badge bg-warning-subtle text-warning fs-11 fw-medium px-2">Processing</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('rentus/assets/images/users/avatar-2.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">Sophie Miller</h6>
                                            <p class="fs-12 text-muted mb-0">Germany</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">WD-6523</a></td>
                                <td>300 USDT</td>
                                <td>05 Nov 2025 <span>02:45 PM</span></td>
                                <td><span class="badge bg-info-subtle text-info fs-11 fw-medium px-2">Confirmed</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('rentus/assets/images/users/avatar-3.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">Liam Carter</h6>
                                            <p class="fs-12 text-muted mb-0">France</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">WD-7721</a></td>
                                <td>500 USDT</td>
                                <td>04 Nov 2025 <span>08:10 PM</span></td>
                                <td><span class="badge bg-success-subtle text-success fs-11 fw-medium px-2">Settled to Bank</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('rentus/assets/images/users/avatar-4.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">Isabella Gomez</h6>
                                            <p class="fs-12 text-muted mb-0">Canada</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">WD-8810</a></td>
                                <td>150 USDT</td>
                                <td>02 Nov 2025 <span>11:12 AM</span></td>
                                <td><span class="badge bg-danger-subtle text-danger fs-11 fw-medium px-2">Failed</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('rentus/assets/images/users/avatar-5.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">Rahul Verma</h6>
                                            <p class="fs-12 text-muted mb-0">India</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">WD-7754</a></td>
                                <td>200 USDT</td>
                                <td>01 Nov 2025 <span>09:40 PM</span></td>
                                <td><span class="badge bg-secondary-subtle text-secondary fs-11 fw-medium px-2">On Hold</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!--end col-->
</div><!--end row-->

@endsection