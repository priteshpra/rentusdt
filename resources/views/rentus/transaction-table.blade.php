@forelse($transactions as $tran)
<tr>
    <td>
        <div class="d-flex align-items-center">
            <img src="{{ !empty($tran->get_user) && !empty($tran->get_user->avatar) ? asset('storage/'.$tran->get_user->avatar) : asset('rentus/assets/images/users/avatar-1.jpg') }}" height="40" class="me-2 rounded" alt="">
            <div class="flex-grow-1">
                <h6 class="m-0">{{ $tran->get_user->name }}</h6>
                <p class="fs-12 text-muted mb-0">USA</p>
            </div>
        </div>
    </td>
    <td>{{ $tran->txn_id }}</td>
    <td>{{ $tran->apply_date->format('d M Y') }} <span>{{ $tran->apply_date->format('h:i A') }}</span></td>
    <td>{{ number_format($tran->amount1, 2) }} USDT</td>
    <td>
        @if($tran->status_text == 'finished')
        <span class="badge bg-success">Completed</span>
        @elseif ($tran->status_text == 'waiting')
        <span class="badge bg-danger">Waiting</span>
        @elseif ($tran->status_text == 'pending')
        <span class="badge bg-warning">Pending</span>
        @endif
    </td>
    <td class="text-center">
        <a href="#"><i class="las la-receipt text-secondary fs-18"></i></a>
        <a href="#"><i class="las la-download text-secondary fs-18"></i></a>
        <a href="#"><i class="las la-trash-alt text-secondary fs-18"></i></a>
    </td>
</tr>
@empty

<tr>
    <td colspan="6" class="text-center py-4">
        <strong>No Transactions Found</strong>
    </td>
</tr>

@endforelse