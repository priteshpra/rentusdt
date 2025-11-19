<!-- Withdraw Modal -->
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
          <input type="text" class="form-control" id="walletAddress" placeholder="Enter your BEP20 wallet address">
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

    if (selectedType.value === 'capital') {
      alert("You are withdrawing Entire Capital with 15% deduction applied.");
    } else {
      const amount = parseFloat(incomeAmountInput.value);
      if (isNaN(amount) || amount < 25) {
        alert("Please enter at least 25 USDT.");
        return;
      }
      alert(`You are withdrawing ${amount} USDT from Rented Income.`);
    }

    const modal = bootstrap.Modal.getInstance(document.getElementById('withdrawModal'));
    modal.hide();
  });
</script>
@endpush
