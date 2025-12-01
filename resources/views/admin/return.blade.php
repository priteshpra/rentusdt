@extends('layouts.admin')

@section('title', 'Return History')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Return History</h4>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <a href="#" class="btn bt btn-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="icofont-calendar fs-5 me-1"></i> <span class="selected-filter-text">This
                                    Month</span> <i class="las la-angle-down ms-1"></i>
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
            <!--end card-header-->

            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Transaction ID</th>
                                <th>Total Investment</th>
                                <th>Today's Return</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($returnHist as $retrn)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ !empty($retrn->get_user) && !empty($retrn->get_user->avatar) ? asset('storage/'.$retrn->get_user->avatar) : asset('rentus/assets/images/users/avatar-1.jpg') }}"
                                            height="40" class="me-2 rounded" alt="">
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="m-0">{{ $retrn->get_user->name }}</h6>
                                            <p class="fs-12 text-muted mb-0">{{ $retrn->get_user->country ?? 'USA' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td><a href="#" class="fs-12 text-primary">{{ $retrn->txn_id }}</a></td>
                                <td>{{ $retrn->principal_snapshot }} USDT</td>
                                <td>{{ $retrn->daily_return }} USDT</td>
                                <td><span class="badge bg-success-subtle text-success fs-11 fw-medium px-2">Added to
                                        Wallet</span></td>
                                <td class="text-center">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
                                    <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            {{-- More static rows can go here --}}
                            @if($returnHist->count() == 0)
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No Returns found.
                                </td>
                            </tr>
                            @endif


                        </tbody>
                    </table>
                </div>
                <!--end table-responsive-->
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->

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
                url: "{{ route('admin.return.filter') }}",
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