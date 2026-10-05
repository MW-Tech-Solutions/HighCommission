<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Document & Receipt Verification Seal Generator</h3>
        <div class="small text-muted">Issue official digital verification hashes for consular documents, receipts, and attestations.</div>
    </div>
    <button type="button" class="btn btn-emerald btn-sm" data-bs-toggle="modal" data-bs-target="#issueVerificationModal">
        <i class="bi bi-shield-plus me-1"></i>Issue New Verification Seal
    </button>
</div>

<!-- Modal: Issue Verification Seal -->
<div class="modal fade" id="issueVerificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form action="<?= Helper::baseUrl('admin/verification') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" style="font-family: 'Playfair Display', serif;">Issue Official Verification Code</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Verification Code (Leave blank for auto)</label>
                            <input type="text" name="verification_code" class="form-control" placeholder="e.g. NHCK-2026-9912">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Document / Receipt Type</label>
                            <input type="text" name="document_type" class="form-control" required placeholder="e.g. Consular Attestation Certificate / Receipt">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Holder / Beneficiary Full Name</label>
                            <input type="text" name="holder_name" class="form-control" required placeholder="e.g. Tunde Emmanuel">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Passport / Reference Number</label>
                            <input type="text" name="passport_or_ref" class="form-control" required placeholder="e.g. A00123456">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Issue Date</label>
                            <input type="date" name="issue_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Verification Status</label>
                            <select name="status" class="form-select" required>
                                <option value="valid">Valid / Verified</option>
                                <option value="pending">Pending Further Clearance</option>
                                <option value="revoked">Revoked / Invalid</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Officer Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="Authentic document issued under official High Commission seal.">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald btn-sm fw-bold">Issue Verification Seal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Code</th>
                        <th>Document Type</th>
                        <th>Holder Name</th>
                        <th>Passport / Ref</th>
                        <th>Status</th>
                        <th>Issued By</th>
                        <th>QR Hash</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $rec): ?>
                        <tr>
                            <td><code class="fw-bold text-dark"><?= Helper::sanitize($rec['verification_code']) ?></code></td>
                            <td class="fw-semibold text-dark"><?= Helper::sanitize($rec['document_type']) ?></td>
                            <td><?= Helper::sanitize($rec['holder_name']) ?></td>
                            <td><code><?= Helper::sanitize($rec['passport_or_ref']) ?></code></td>
                            <td><?= Helper::statusBadge($rec['status']) ?></td>
                            <td class="small text-muted"><?= Helper::sanitize($rec['issued_by_officer']) ?></td>
                            <td class="small font-monospace text-emerald"><?= Helper::sanitize($rec['qr_hash']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
