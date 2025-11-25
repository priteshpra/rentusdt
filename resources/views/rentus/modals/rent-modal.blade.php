<!-- Rent More Modal -->
<div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="rentModalLabel">💰 Rent More USDT</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Step 1: Enter Amount -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Enter Amount to Rent (USDT)</label>
                    <input type="number" id="rentAmount" class="form-control" min="10" placeholder="Minimum 10 USDT">
                    <small class="text-muted">Minimum rent amount: 10 USDT</small>
                </div>

                <!-- Step 2: Show Payment Address -->
                <div id="paymentSection" class="d-none">
                    <hr>
                    <h6 class="fw-bold mb-2">Send Payment To:</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1 text-muted">USDT (BEP20) Wallet Address</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <code id="usdtAddress">0xA1b2C3d4E5F67890123456789ABCDEF012345678</code>
                            <button class="btn btn-sm btn-outline-secondary" onclick="copyAddress()">Copy</button>
                        </div>
                    </div>
                    <small class="text-muted">⚠️ Send the exact USDT amount mentioned above.</small>
                </div>

                <!-- Step 3: Transaction Proof -->
                <div id="proofSection" class="mt-4 d-none">
                    <hr>
                    <h6 class="fw-bold mb-3">Upload Payment Proof</h6>

                    <div class="mb-3">
                        <label class="form-label">Transaction ID (TXID)</label>
                        <input type="text" id="txid" class="form-control" placeholder="Enter your USDT transaction ID">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Screenshot / Proof</label>
                        <input type="file" class="form-control" id="paymentProof" accept="image/*">
                        <small class="text-muted">Accepted formats: JPG, PNG (Max 2MB)</small>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="nextStep" class="btn btn-primary">Proceed</button>
                <button type="button" id="submitProof" class="btn btn-success d-none">Submit Payment</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const rentAmountInput = document.getElementById('rentAmount');
    const paymentSection = document.getElementById('paymentSection');
    const proofSection = document.getElementById('proofSection');
    const nextStepBtn = document.getElementById('nextStep');
    const submitProofBtn = document.getElementById('submitProof');
    const txidInput = document.getElementById('txid');
    const proofFile = document.getElementById('paymentProof');

    nextStepBtn.addEventListener('click', () => {
        const amount = parseFloat(rentAmountInput.value);
        if (isNaN(amount) || amount < 10) {
            alert("⚠️ Please enter at least 10 USDT to rent.");
            return;
        }
        paymentSection.classList.remove('d-none');
        proofSection.classList.remove('d-none');
        nextStepBtn.classList.add('d-none');
        submitProofBtn.classList.remove('d-none');
    });

    function copyAddress() {
        const address = document.getElementById('usdtAddress').textContent;
        navigator.clipboard.writeText(address);
        alert("Wallet address copied!");
    }

    submitProofBtn.addEventListener('click', () => {
        const txid = txidInput.value.trim();
        const file = proofFile.files[0];
        if (!txid) {
            alert("⚠️ Please enter your Transaction ID (TXID).");
            return;
        }
        if (!file) {
            alert("⚠️ Please upload your payment screenshot or proof.");
            return;
        }
        alert("✅ Payment details submitted successfully! Our team will verify and update your rented balance.");
        const modal = bootstrap.Modal.getInstance(document.getElementById('rentModal'));
        alert(amount);
        let formData = new FormData();
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("amount", 1000);
        formData.append("coin", "USDT.TRC20");
        formData.append("txid", txid);
        formData.append("proof", file);

        $.ajax({
            url: "{{ url('/deposit') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert("✅ Submitted successfully!");
            },
            error: function (xhr) {
                alert("❌ Something went wrong.");
                console.log(xhr.responseText);
            }
        });
        modal.hide();
  });
</script>
@endpush