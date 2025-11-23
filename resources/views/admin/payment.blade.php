@extends('layouts.admin')

@section('title', 'Transactions History')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Transactions History</h4>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <a href="#" class="btn bt btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icofont-calendar fs-5 me-1"></i> <span class="selected-filter-text">This Month</span> <i class="las la-angle-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="today">Today</a>
                                <a class="dropdown-item" href="last_week">Last Week</a>
                                <a class="dropdown-item" href="last_month">Last Month</a>
                                <a class="dropdown-item" href="this_year">This Year</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Transaction ID</th>
                                <th>Date & Time</th>
                                <th>Amount (USDT)</th>
                                <th>Status</th>
                                <th>Payment Proof</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $tran)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ !empty($tran->get_user) && !empty($tran->get_user->avatar) ? asset('storage/'.$tran->get_user->avatar) : asset('admin/assets/images/users/avatar-1.jpg') }}" height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">{{ $tran->get_user->name }}</h6>
                                            <p class="fs-12 text-muted mb-0">USA</p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">{{ $tran->txn_id }}</a></td>
                                <td>{{ $tran->apply_date->format('d M Y') }} <span>{{ $tran->apply_date->format('h:i A') }}</span></td>
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
                                <td>
                                    <a href="admin/assets/docs/proof1.pdf" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="#"><i class="las la-receipt text-secondary fs-18"></i></a>
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
                {{-- PAGINATION HERE --}}
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('.dropdown-item').on('click', function(e) {
            e.preventDefault();

            let filter = $(this).attr('href').replace('#', '');
            let perPage = 15;
            let selectedText = $(this).text().trim();
            // Update dropdown button label
            $('.selected-filter-text').text(selectedText);

            $.ajax({
                url: "{{ route('admin.transactions.filter') }}",
                type: 'GET',
                data: {
                    filter: filter,
                    per_page: perPage
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('tbody').html(response.html);
                    }
                }
            });
        });

    });
</script>
@endsection