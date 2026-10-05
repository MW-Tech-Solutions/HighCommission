<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <a href="<?= Helper::baseUrl('portal/dashboard') ?>" class="btn btn-outline-secondary btn-sm mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <span class="badge bg-gold text-dark font-monospace mb-1"><?= Helper::sanitize($req['reference_number']) ?></span>
                <h2 class="fw-bold text-emerald-dark mb-0" style="font-family: 'Playfair Display', serif;"><?= Helper::sanitize($req['subject']) ?></h2>
            </div>
            <div>
                <?= Helper::statusBadge($req['status']) ?>
            </div>
        </div>
    </div>

    <!-- Case Info Card -->
    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="small text-muted">Applicant Name</div>
                <div class="fw-bold text-dark"><?= Helper::sanitize($req['applicant_name']) ?></div>
            </div>
            <div class="col-md-4">
                <div class="small text-muted">Service Type</div>
                <div class="fw-bold text-uppercase"><?= str_replace('_', ' ', $req['service_type']) ?></div>
            </div>
            <div class="col-md-4">
                <div class="small text-muted">Assigned Consular Officer</div>
                <div class="fw-bold text-emerald"><?= Helper::sanitize($req['officer_name'] ?? 'Assigned to Duty Desk') ?></div>
            </div>
            <div class="col-12 mt-3 pt-3 border-top">
                <div class="small text-muted mb-1">Initial Request Details</div>
                <div class="p-3 bg-light rounded-3 text-secondary"><?= nl2br(Helper::sanitize($req['details'])) ?></div>
            </div>
        </div>
    </div>

    <!-- Messages Thread -->
    <h4 class="fw-bold text-emerald-dark mb-3" style="font-family: 'Playfair Display', serif;">Official Messaging Thread</h4>
    
    <div class="mb-4">
        <?php foreach ($messages as $msg): ?>
            <div class="card border-0 shadow-sm rounded-4 mb-3 <?= $msg['sender_type'] === 'staff' ? 'bg-emerald-light border-start border-4 border-emerald' : 'bg-white' ?>">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="fw-bold <?= $msg['sender_type'] === 'staff' ? 'text-emerald-dark' : 'text-dark' ?>">
                            <i class="bi <?= $msg['sender_type'] === 'staff' ? 'bi-bank text-emerald me-1' : 'bi-person-circle me-1' ?>"></i>
                            <?= Helper::sanitize($msg['sender_name']) ?> 
                            <?php if ($msg['sender_type'] === 'staff'): ?>
                                <span class="badge bg-emerald ms-2">Consular Officer</span>
                            <?php endif; ?>
                        </div>
                        <div class="small text-muted"><?= Helper::formatDate($msg['created_at'], 'd M Y, h:i A') ?></div>
                    </div>
                    <div class="text-secondary small"><?= nl2br(Helper::sanitize($msg['message'])) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Reply Box -->
    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-reply-fill text-emerald me-1"></i>Post a Message</h5>
        <form action="<?= Helper::baseUrl('portal/request?ref=' . $req['reference_number']) ?>" method="POST">
            <?= Helper::csrfField() ?>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="3" required placeholder="Write your reply or request update..."></textarea>
            </div>
            <button type="submit" class="btn btn-emerald fw-bold">
                <i class="bi bi-send-fill me-1"></i>Send Reply
            </button>
        </form>
    </div>
</div>
