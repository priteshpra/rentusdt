@forelse($returnHist as $retrn)
<tr>
    <td>
        <div class="d-flex align-items-center">
            <img src="{{ !empty($retrn->get_user) && !empty($retrn->get_user->avatar) ? asset('storage/'.$retrn->get_user->avatar) : asset('rentus/assets/images/users/avatar-1.jpg') }}" height="40" class="me-2 rounded" alt="">
            <div class="flex-grow-1 text-truncate">
                <h6 class="m-0">{{ $retrn->get_user->name }}</h6>
                <p class="fs-12 text-muted mb-0">USA</p>
            </div>
        </div>
    </td>
    <td><a href="#" class="fs-12 text-primary">{{ $retrn->txn_id }}</a></td>
    <td>{{ $retrn->principal_snapshot }} USDT</td>
    <td>{{ $retrn->daily_return }} USDT</td>
    <td><span class="badge bg-success-subtle text-success fs-11 fw-medium px-2">Added to Wallet</span></td>
    <td class="text-center">
        <a href="#" title="View"><i class="las la-eye text-secondary fs-18"></i></a>
        <a href="#" title="Print"><i class="las la-print text-secondary fs-18"></i></a>
    </td>
</tr>
@empty

<tr>
    <td colspan="6" class="text-center py-4">
        <strong>No Return History Found</strong>
    </td>
</tr>

@endforelse