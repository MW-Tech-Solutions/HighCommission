<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Track Request</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">LIVE REQUEST TRACKING</span></div>
        <h1 class="display-6 fw-bold">Track Your Mission Request</h1>
        <p class="max-w-700 mx-auto">Enter your Reference Number (e.g. <code>REQ-2026-1001</code> or <code>APT-2026-8801</code>) to follow progress instantly.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="nhc-card shadow-lg border-0 rounded-4 max-w-700 mx-auto mb-5 p-4 p-md-5 bg-white">
        <form action="<?= Helper::baseUrl('track') ?>" method="GET" class="mb-4">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-emerald-subtle border-0 text-emerald"><i class="bi bi-search"></i></span>
                <input type="text" name="ref" class="form-control border-0 bg-light fs-6" placeholder="Enter REQ-XXXX or APT-XXXX..." value="<?= Helper::sanitize($ref ?? '') ?>" required>
                <button type="submit" class="btn btn-emerald px-4 fw-bold"><i class="bi bi-search me-1"></i>Track Status</button>
            </div>
        </form>

        <?php if ($ref): ?>
            <?php if ($result): ?>
                <div class="nhc-card p-4 border-emerald rounded-3 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="badge bg-gold text-dark font-monospace fs-6 px-3 py-1.5"><?= Helper::sanitize($ref) ?></span>
                        <?= Helper::statusBadge($result['status']) ?>
                    </div>
                    <?php if ($type === 'request'): ?>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);"><?= Helper::sanitize($result['subject']) ?></h5>
                        <p class="text-muted small mb-2">Service: <?= str_replace('_', ' ', strtoupper($result['service_type'])) ?></p>
                        <div class="small text-secondary mb-3">Date Logged: <?= Helper::formatDate($result['created_at'], 'd M Y, h:i A') ?></div>
                        <a href="<?= Helper::baseUrl('portal/request?ref=' . $result['reference_number']) ?>" class="btn btn-emerald btn-sm shadow-sm">View Full Thread & Messages <i class="bi bi-arrow-right ms-1"></i></a>
                    <?php else: ?>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Appointment: <?= str_replace('_', ' ', strtoupper($result['service_category'])) ?></h5>
                        <div class="small text-muted mb-3">Scheduled Date: <strong class="text-dark"><?= Helper::formatDate($result['appointment_date'], 'd M Y') ?></strong> at <strong class="text-dark"><?= Helper::sanitize($result['time_slot']) ?></strong></div>
                        <a href="<?= Helper::baseUrl('appointment/voucher?code=' . $result['voucher_number']) ?>" class="btn btn-accent btn-sm shadow-sm">View Appointment Voucher <i class="bi bi-arrow-right ms-1"></i></a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-warning border-0 text-center mb-0 p-4 rounded-3">
                    <i class="bi bi-exclamation-circle-fill me-1 fs-5"></i>No active request or appointment found matching reference code <code><?= Helper::sanitize($ref) ?></code>.
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
