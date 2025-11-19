@extends('layouts.admin')

@section('title', 'Users')

@section('content')

<div class="row justify-content-center">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box d-md-flex justify-content-md-between align-items-center">
                <h4 class="page-title">Users</h4>
                <div class="">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">RentUSDT</a>
                        </li><!--end nav-item-->
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div><!--end row-->
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Users Details</h4>
                    </div>
                    <div class="col-auto">
                        <!-- <button class="btn bg-primary text-white" data-bs-toggle="modal" data-bs-target="#addUser">
                            <i class="fas fa-plus me-1"></i> Add User
                        </button> -->
                        <a href="{{ route('admin.users.create') }}" class="btn bg-primary text-white">
                            <i class="fas fa-plus me-1"></i> Add User
                        </a>
                    </div>
                </div>
            </div><!--end card-header-->

            <div class="card-body pt-0">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Refer Code</th>
                                <!-- <th>Password</th> -->
                                <th>Status</th>
                                <th>Total USDT</th>
                                <th>Assign % Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr class="text-center">
                                <td>
                                    <img src="admin/assets/images/users/avatar-1.jpg" height="40" class="rounded-circle" alt="">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ($user->contact) ? $user->contact : '-' }}</td>
                                <td>{{ ($user->refer_code) ? $user->refer_code : '-' }}</td>
                                <!-- <td>******</td> -->
                                <td>
                                    @if($user->status == 1)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $user->total_usdt }} USDT</td>
                                <td>
                                    <!-- <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignRateModal">
                                        <i class="fas fa-percentage me-1"></i> Assign
                                    </button> -->
                                    <button class="btn btn-outline-primary btn-sm assign-rate-btn"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-total="{{ number_format($user->total_usdt, 2) }}"
                                        data-assign="{{ $user->assign_rate ?? '' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignRateModal">
                                        <i class="fas fa-percentage me-1"></i> Assign
                                    </button>
                                </td>
                                <td class="d-flex">
                                    <!-- <a href="#" title="View"><i class="las la-eye text-secondary fs-18 me-2"></i></a> -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit"><i class="las la-pen text-secondary fs-18 me-2"></i></a>
                                    <!-- <a href="#" title="Delete"><i class="las la-trash-alt text-secondary fs-18"></i></a> -->
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

                            <!-- <tr class="text-center">
                                <td>
                                    <img src="assets/images/users/avatar-2.jpg" height="40" class="rounded-circle" alt="">
                                </td>
                                <td>Sophie Miller</td>
                                <td>sophie@gmail.com</td>
                                <td>+49 123 456 789</td>
                                <td>REF67890</td>
                                <td>ER#$3434</td>
                                <td>ER#$3434</td>
                                <td>900 USDT</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignRateModal">
                                        <i class="fas fa-percentage me-1"></i> Assign
                                    </button>
                                </td>
                                <td class="d-flex">
                                    <a href="#" title="View"><i class="las la-eye text-secondary fs-18 me-2"></i></a>
                            <a href="#" title="Edit"><i class="las la-pen text-secondary fs-18 me-2"></i></a>
                            <a href="#" title="Delete"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                            </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div><!--end table-responsive-->
            </div><!--end card-body-->
        </div><!--end card-->
    </div> <!--end col-->
</div><!--end row-->

<!-- Assign Rate Modal -->
<div class="modal fade" id="assignRateModal" tabindex="-1" aria-labelledby="assignRateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="assignRateLabel"><i class="fas fa-percentage me-1"></i> Assign Return Rate</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="assignRateForm">
                    @csrf <!-- for jQuery form serialization if needed -->
                    <input type="hidden" name="user_id" id="assign_user_id">

                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" id="assign_user_name" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Invested (USDT)</label>
                        <input type="text" id="assign_user_total" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Return Rate (%)</label>
                        <input type="number" name="assign_rate" id="assign_rate_input" class="form-control" placeholder="Enter % rate" min="1" max="100" required>
                        <div class="invalid-feedback" id="assignRateError"></div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="assignRateSaveBtn">Save Rate</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {

        // populate modal when "Assign" button clicked
        $(document).on('click', '.assign-rate-btn', function() {
            const btn = $(this);
            $('#assign_user_id').val(btn.data('id'));
            $('#assign_user_name').val(btn.data('name'));
            $('#assign_user_total').val(btn.data('total'));
            $('#assign_rate_input').val(btn.data('assign') ?? '');
            $('#assignRateError').text('').hide();
            $('#assign_rate_input').removeClass('is-invalid');
        });

        // submit form via ajax
        $('#assignRateForm').on('submit', function(e) {
            e.preventDefault();

            const userId = $('#assign_user_id').val();
            const url = "{{ url('/admin/users') }}/" + userId + "/assign-rate";
            const token = $('meta[name="csrf-token"]').attr('content');

            const payload = {
                assign_rate: $('#assign_rate_input').val(),
                _token: token
            };

            $('#assignRateSaveBtn').prop('disabled', true).text('Saving...');

            $.ajax({
                url: url,
                method: 'POST',
                data: payload,
                dataType: 'json'
            }).done(function(res) {
                // update UI: find the assign_rate cell in the same row
                // we locate the row by the button's data-id
                const rowBtn = $('.assign-rate-btn[data-id="' + res.data.id + '"]');
                // assume you have a cell with class .assign-rate-value in the row
                rowBtn.closest('tr').find('.assign-rate-value').text(res.data.assign_rate + '%');

                // close modal
                $('#assignRateModal').modal('hide');

                // optional: show a toast or inline success
                alert(res.message);
                location.reload();

            }).fail(function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.assign_rate) {
                        $('#assign_rate_input').addClass('is-invalid');
                        $('#assignRateError').text(errors.assign_rate[0]).show();
                    }
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }).always(function() {
                $('#assignRateSaveBtn').prop('disabled', false).text('Save Rate');
            });

        });

    });
</script>
@endsection