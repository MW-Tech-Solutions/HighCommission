<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Authenticator</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic"><i class="bi bi-shield-check me-1"></i>ANTI-FRAUD PROTECTION ENGINE</span></div>
        <h1 class="display-6 fw-bold">Official Document & Receipt Authenticator</h1>
        <p class="max-w-700 mx-auto">Verify the authenticity of any document, consular receipt, or certificate issued under seal by the High Commission of the Federal Republic of Nigeria in Nairobi.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Search & Scanner Box -->
    <div class="nhc-card shadow-lg border-0 rounded-4 max-w-800 mx-auto mb-5 bg-white">
        <div class="card-body p-4 p-md-5">
            <form id="verify-search-form" action="<?= Helper::baseUrl('verify') ?>" method="GET" class="mb-4">
                <label class="form-label fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Enter Verification Code / Serial Number / Receipt ID:</label>
                <div class="input-group input-group-lg">
                    <span class="input-group-text bg-emerald-subtle border-0 text-emerald"><i class="bi bi-qr-code-scan"></i></span>
                    <input type="text" id="verification_query" name="verification_query" class="form-control border-0 bg-light fs-6" placeholder="e.g. NHCK-2026-8849 or REC-8841-KEN" value="<?= Helper::sanitize($query ?? '') ?>" required>
                    <button type="submit" class="btn btn-emerald px-4 fw-bold">
                        <i class="bi bi-shield-check me-1"></i>Verify Authenticity
                    </button>
                </div>
            </form>

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 pt-3 border-top">
                <div class="small text-muted">
                    <i class="bi bi-info-circle me-1 text-emerald"></i>Try sample codes: 
                    <a href="<?= Helper::baseUrl('verify?verification_query=NHCK-2026-8849') ?>" class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-2.5 py-1 text-decoration-none me-1">NHCK-2026-8849</a>
                    <a href="<?= Helper::baseUrl('verify?verification_query=NHCK-2026-1024') ?>" class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-2.5 py-1 text-decoration-none me-1">NHCK-2026-1024</a>
                    <a href="<?= Helper::baseUrl('verify?verification_query=REC-8841-KEN') ?>" class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-2.5 py-1 text-decoration-none">REC-8841-KEN</a>
                </div>
                <div>
                    <button type="button" id="btn-scan-qr" class="btn btn-outline-emerald btn-sm rounded-pill px-3">
                        <i class="bi bi-camera-fill me-1"></i>Scan QR Code
                    </button>
                    <input type="file" id="qr-file-input" class="d-none" accept="image/*">
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Results Display -->
    <?php if ($searched): ?>
        <div class="max-w-800 mx-auto">
            <?php if ($record): ?>
                <div class="nhc-card p-4 p-md-5 border-success border-2 shadow-sm bg-white position-relative overflow-hidden">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 bg-success text-white rounded-circle fs-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px;">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <div>
                                <h3 class="fw-bold text-success mb-0" style="font-family: var(--font-heading);">AUTHENTIC DOCUMENT VERIFIED</h3>
                                <div class="small text-muted">Official Seal Record #<?= Helper::sanitize($record['verification_code']) ?></div>
                            </div>
                        </div>
                        <div>
                            <?= Helper::statusBadge($record['status']) ?>
                        </div>
                    </div>

                    <div class="row g-3 bg-light p-4 rounded-3 mb-4 border">
                        <div class="col-md-6">
                            <div class="small text-muted">Document / Certificate Type</div>
                            <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($record['document_type']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Document Holder / Beneficiary</div>
                            <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($record['holder_name']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Passport / Reference Number</div>
                            <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($record['passport_or_ref']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Issuing Authority</div>
                            <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($record['issued_by_officer']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Issue Date</div>
                            <div class="fw-bold text-dark fs-6"><?= Helper::formatDate($record['issue_date'], 'd M Y') ?></div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Expiry Date</div>
                            <div class="fw-bold text-dark fs-6"><?= $record['expiry_date'] ? Helper::formatDate($record['expiry_date'], 'd M Y') : 'N/A' ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted small">
                        <div><i class="bi bi-qr-code me-1 text-emerald"></i>Digital Verification Hash: <code class="text-dark"><?= Helper::sanitize($record['qr_hash']) ?></code></div>
                        <div class="text-success fw-bold"><i class="bi bi-shield-lock-fill me-1"></i>Verified by Nigeria High Commission Nairobi Database</div>
                    </div>
                </div>
            <?php else: ?>
                <div class="nhc-card p-5 text-center border-danger border-2 rounded-4 shadow-sm bg-white">
                    <div class="fs-1 text-danger mb-3"><i class="bi bi-shield-x"></i></div>
                    <h3 class="fw-bold text-danger mb-2" style="font-family: var(--font-heading);">UNVERIFIED OR FRAUDULENT RECORD</h3>
                    <p class="text-muted mb-4">No matching document, receipt, or verification hash was found for code <code><?= Helper::sanitize($query) ?></code> in the official High Commission database.</p>
                    <div class="alert alert-warning max-w-600 mx-auto text-start small border-0 rounded-3 p-3">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><strong>Warning:</strong> If you received a document or fee request claiming to be from the Nigeria High Commission with this unverified code, it may be unauthorized or fraudulent. Please report it immediately to <a href="mailto:info@nigeriankenya.or.ke" class="fw-bold text-dark">info@nigeriankenya.or.ke</a>.
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
