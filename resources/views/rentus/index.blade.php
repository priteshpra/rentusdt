@extends('layouts.app')

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

    {{-- ===========================
    BALANCE & ACTION SECTION
    ============================ --}}
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-welcome-img overflow-hidden">
                        <div class="card-body">
                            <h3 class="text-white fw-semibold fs-20 lh-base">
                                Rent Your Minimum 1000<br>USDT and Rest Yourself
                            </h3>
                            <!-- <a href="#" class="btn btn-sm btn-danger">Rent Your USDT Now</a> -->
                            <form action="{{ url('/deposit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="amount" value="1000">
                                <input type="hidden" name="coin" value="USDT.TRC20">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Rent Your USDT Now
                                </button>
                            </form>
                            <img src="{{ asset('rentus/assets/images/extra/fund.png') }}" alt="Fund"
                                class="mb-n4 float-end" height="107">
                        </div>
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <div class="card bg-globe-img">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fs-16 fw-semibold">Balance</span>
                            </div>

                            <h4 class="my-2 fs-24 fw-semibold">$ {{number_format($totalUSDT,2) }} <small
                                    class="font-14">USDT</small></h4>
                            <p class="mb-3 text-muted fw-semibold">
                                <span class="text-success"><i class="fas fa-arrow-up me-1"></i>UP TO 0.2% Per Day</span>
                                Outstanding balance boost
                            </p>

                            <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal"
                                data-bs-target="#rentModal">Rent More</button>
                            <button type="button" class="btn btn-soft-danger" data-bs-toggle="modal"
                                data-bs-target="#withdrawModal">Withdraw</button>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="card bg-globe-img">
                        <div class="card-body">

                            <!-- ====== TOP SECTION WITH REF CODE + BALANCE TITLE ====== -->
                            <div class="d-flex justify-content-between align-items-center">


                                <!-- Balance Title -->
                                <span class="fs-16 fw-semibold">Balance</span>


                                <!-- Refer Code + Copy Button -->
                                <div class="d-flex align-items-center">
                                    <span class="fw-semibold me-2">Refer Code:</span>
                                    <div class="d-flex align-items-center bg-light px-2 py-1 rounded">
                                        <span id="refCodeText" class="fw-bold text-primary me-2">
                                            {{ $user->refer_code }}
                                        </span>

                                        <button class="btn btn-sm btn-outline-primary py-0 px-2" onclick="copyRefCode()">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- ====== BALANCE VALUE ====== -->
                            <h4 class="my-2 fs-24 fw-semibold">
                                $ {{ number_format($totalUSDT, 2) }}
                                <small class="font-14">USDT</small>
                            </h4>

                            <p class="mb-3 text-muted fw-semibold">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>UP TO 0.2% Per Day
                                </span>
                                Outstanding balance boost
                            </p>

                            <!-- Rent + Withdraw Buttons -->
                            <button type="button" class="btn btn-soft-primary" data-bs-toggle="modal" data-bs-target="#rentModal">
                                Rent More
                            </button>

                            <button type="button" class="btn btn-soft-danger" data-bs-toggle="modal" data-bs-target="#withdrawModal">
                                Withdraw
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===========================
        RIGHT SUMMARY CARDS
        ============================ --}}
        <div class="col-lg-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Invested</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$ {{ number_format($totalInvest,2) }}</h4>
                                </div>
                                <div class="col-3 text-center">
                                    <div
                                        class="thumb-md border-dashed border-primary rounded mx-auto d-flex justify-content-center align-items-center">
                                        <i class="iconoir-dollar-circle fs-22 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Total Returns</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$5.06</h4>
                                </div>
                                <div class="col-3 text-center">
                                    <div
                                        class="thumb-md border-dashed border-info rounded mx-auto d-flex justify-content-center align-items-center">
                                        <i class="iconoir-cart fs-22 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="card bg-corner-img">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <p class="text-muted text-uppercase mb-0 fw-normal fs-13">Today's Return</p>
                                    <h4 class="mt-1 mb-0 fw-medium">$1.20</h4>
                                </div>
                                <div class="col-3 text-center">
                                    <div
                                        class="thumb-md border-dashed border-warning rounded mx-auto d-flex justify-content-center align-items-center">
                                        <i class="iconoir-percentage-circle fs-22 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===========================
    TRANSACTION HISTORY
    ============================ --}}
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Transaction History</h4>
                    <div class="dropdown">
                        <a href="#" class="btn bt btn-light dropdown-toggle" data-bs-toggle="dropdown">
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

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Transaction</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $tran)
                                <tr>
                                    <td><a href="#" class="fs-12 text-primary">{{ $tran->txn_id }}</a></td>
                                    <td>{{ $tran->apply_date->format('d M Y') }} <span>{{ $tran->apply_date->format('h:i
                                            A') }}</span></td>
                                    <td>{{ number_format($tran->amount1, 2) }} USDT</td>
                                    <td>
                                        <!-- <span class="badge bg-success-subtle text-success fs-11 fw-medium px-2">Completed</span> -->
                                        @if($tran->status_text == 'finished')
                                        <span class="badge bg-success">Complated</span>
                                        @elseif ($tran->status_text == 'waiting')
                                        <span class="badge bg-danger">Waiting</span>
                                        @elseif ($tran->status_text == 'pending')
                                        <span class="badge bg-danger">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- <a href="#"><i class="las la-receipt text-secondary fs-18"></i></a> -->
                                        <a href="#"><i class="las la-download text-secondary fs-18"></i></a>
                                        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @if($transactions->count() == 0)
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No transactions found.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function copyRefCode() {
        let text = document.getElementById("refCodeText").innerText;

        navigator.clipboard.writeText(text).then(() => {
            alert("Refer code copied: " + text);
        });
    }
</script>
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