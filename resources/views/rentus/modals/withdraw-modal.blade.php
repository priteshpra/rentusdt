<!-- Withdraw Modal -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title" id="withdrawModalLabel">💸 Withdraw Funds</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Wallet Address -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Enter your Wallet Address (BEP20 only)</label>
                    <input type="text" class="form-control" name="wallet_address" id="walletAddress" placeholder="Enter your BEP20 wallet address" value="{{ ($user->wallet_address) ?? '' }}">
                </div>

                <hr>

                <!-- Withdraw Options -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Make Withdrawal</label>

                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="withdrawType" id="entireCapital" value="capital">
                        <label class="form-check-label" for="entireCapital">
                            Entire Capital <span class="text-danger fw-semibold">(15% deduction)</span>
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="withdrawType" id="rentedIncome" value="income">
                        <label class="form-check-label" for="rentedIncome">
                            Rented Income <span class="text-muted fw-semibold">(Minimum amount: 25 USDT)</span>
                        </label>
                    </div>
                </div>

                <!-- Income Amount Section -->
                <div id="incomeAmountSection" class="mt-3 d-none">
                    <label class="form-label fw-bold">Enter Withdrawal Amount (USDT)</label>
                    <input type="number" class="form-control" id="incomeAmount" min="25" placeholder="Minimum 25 USDT">
                    <small id="incomeWarning" class="text-danger d-none">Amount must be at least 25 USDT</small>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="withdrawNow" class="btn btn-danger" disabled>Withdraw Now</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const withdrawTypeInputs = document.querySelectorAll('input[name="withdrawType"]');
    const withdrawNowBtn = document.getElementById('withdrawNow');
    const incomeAmountSection = document.getElementById('incomeAmountSection');
    const incomeAmountInput = document.getElementById('incomeAmount');
    const incomeWarning = document.getElementById('incomeWarning');
    const walletAddressInput = document.getElementById('walletAddress');

    withdrawTypeInputs.forEach(input => {
        input.addEventListener('change', () => {
            if (input.value === 'income') {
                incomeAmountSection.classList.remove('d-none');
                withdrawNowBtn.disabled = true;
            } else {
                incomeAmountSection.classList.add('d-none');
                withdrawNowBtn.disabled = false;
            }
        });
    });

    incomeAmountInput.addEventListener('input', () => {
        const amount = parseFloat(incomeAmountInput.value);
        if (isNaN(amount) || amount < 25) {
            incomeWarning.classList.remove('d-none');
            withdrawNowBtn.disabled = true;
        } else {
            incomeWarning.classList.add('d-none');
            withdrawNowBtn.disabled = false;
        }
    });

    withdrawNowBtn.addEventListener('click', () => {
        const wallet = walletAddressInput.value.trim();
        if (!wallet) {
            alert("Please enter your BEP20 wallet address.");
            return;
        }

        const selectedType = document.querySelector('input[name="withdrawType"]:checked');
        if (!selectedType) {
            alert("Please select a withdrawal type.");
            return;
        }

        const amount = parseFloat(incomeAmountInput.value);
        if (selectedType.value === 'capital') {
            alert("You are withdrawing Entire Capital with 15% deduction applied.");
        } else {
            if (isNaN(amount) || amount < 25) {
                alert("Please enter at least 25 USDT.");
                return;
            }
            alert(`You are withdrawing ${amount} USDT from Rented Income.`);
        }

        const modal = bootstrap.Modal.getInstance(document.getElementById('withdrawModal'));


        // --------------------------------------------------------------------
        // 🔥 SEND AJAX REQUEST TO LARAVEL
        // --------------------------------------------------------------------
        const url = "withdraw/request";
        const token = document.querySelector('meta[name="csrf-token"]').content;

        const formData = new FormData();
        const amnt = (amount) ? amount : 20;
        formData.append("withdraw_type", "crypto");
        formData.append("wallet", "totalwallet");
        // formData.append("username", loggedInUsername);
        formData.append("amount", amnt);

        fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => {
                return response.json().then(json => ({
                    status: response.status,
                    ok: response.ok,
                    json: json
                }));
            })
            .then(res => {

                // SUCCESS
                if (res.ok && res.json.status === "success") {
                    alert(res.json.message);

                    if (res.json.balance) {
                        document.getElementById('user-balance').innerText = res.json.balance;
                    }
                    return;
                }

                // VALIDATION ERRORS
                if (res.status === 422) {
                    let msg = "";
                    Object.values(res.json.errors).forEach(err => msg += err[0] + "\n");
                    alert(msg);
                    return;
                }

                // OTHER ERRORS
                alert(res.json.message || "Withdraw attempt failed.");

            })
            .catch(error => {
                // alert("Network error. Try again!");
            });

        modal.hide();
    });
</script>
@endpush