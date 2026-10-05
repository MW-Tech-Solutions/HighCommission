<?php
use App\Core\Helper;
?>
<div class="container my-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 750px;">
        <div class="card-header bg-dark text-white p-4 border-bottom border-success border-4">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?= Helper::baseUrl('assets/images/coat-of-arms.png') ?>" alt="Coat of Arms" style="height: 60px;">
                    <div>
                        <h4 class="mb-0 fw-bold text-uppercase" style="letter-spacing: 0.5px;">Nigeria High Commission</h4>
                        <p class="small text-white-50 mb-0">Nairobi, Republic of Kenya</p>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge bg-success fs-6 px-3 py-2"><?= Helper::sanitize($type) ?></span>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-light border border-success d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h6 class="fw-bold text-success mb-1">Official Reference Code</h6>
                    <h3 class="fw-bold text-dark font-monospace mb-0"><?= Helper::sanitize($data['voucher_number'] ?? $data['reference_number'] ?? 'NHCK-SLIP') ?></h3>
                </div>
                <div class="text-end">
                    <span class="small text-muted d-block">Issued Date</span>
                    <strong><?= Helper::formatDate($data['created_at'] ?? date('Y-m-d H:i:s')) ?></strong>
                </div>
            </div>

            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Applicant & Service Details</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <span class="text-muted small d-block">Full Name</span>
                    <strong class="text-dark fs-6"><?= Helper::sanitize($data['applicant_name'] ?? $user['full_name']) ?></strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Contact Email</span>
                    <strong class="text-dark fs-6"><?= Helper::sanitize($data['applicant_email'] ?? $user['email']) ?></strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Phone Number</span>
                    <strong class="text-dark fs-6"><?= Helper::sanitize($data['applicant_phone'] ?? 'N/A') ?></strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Current Status</span>
                    <?= Helper::statusBadge($data['status'] ?? 'confirmed') ?>
                </div>
                <?php if (!empty($data['service_category'])): ?>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Service Category</span>
                    <strong class="text-success fs-6"><?= strtoupper(str_replace('_', ' ', $data['service_category'])) ?></strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Appointment Schedule</span>
                    <strong class="text-dark fs-6"><?= Helper::formatDate($data['appointment_date'], 'D, d M Y') ?> (<?= Helper::sanitize($data['time_slot']) ?>)</strong>
                </div>
                <?php elseif (!empty($data['service_type'])): ?>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Service Requested</span>
                    <strong class="text-success fs-6"><?= strtoupper(str_replace('_', ' ', $data['service_type'])) ?></strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted small d-block">Subject</span>
                    <strong class="text-dark fs-6"><?= Helper::sanitize($data['subject']) ?></strong>
                </div>
                <?php endif; ?>
            </div>

            <div class="border-top pt-3 mt-4 text-center">
                <p class="small text-muted mb-2">
                    Please present this printed confirmation slip along with your original passport and supporting documentation at the Chancery (Lenana Road, Kilimani, Nairobi).
                </p>
                <div class="d-print-none mt-4">
                    <button onclick="window.print();" class="btn btn-success me-2">
                        <i class="bi bi-printer me-1"></i> Print / Download PDF
                    </button>
                    <a href="<?= Helper::baseUrl('portal/dashboard') ?>" class="btn btn-outline-secondary">
                        Back to Portal
                    </a>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-center py-3">
            <span class="small text-muted">High Commission of the Federal Republic of Nigeria, Nairobi | Official Consular Service Slip</span>
        </div>
    </div>
</div>
