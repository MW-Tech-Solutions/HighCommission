<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print flex-wrap gap-2">
        <a href="<?= Helper::baseUrl('appointment') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Book Another Appointment
        </a>
        <button onclick="window.print();" class="btn btn-emerald btn-sm">
            <i class="bi bi-printer-fill me-1"></i>Print Confirmation Voucher
        </button>
    </div>

    <div class="nhc-voucher-box shadow-lg max-w-800 mx-auto">
        <i class="bi bi-bank2 nhc-seal-watermark"></i>
        
        <!-- Header Strip -->
        <div class="text-center pb-3 mb-4 border-bottom border-2 border-emerald">
            <div class="nhc-crest-badge mx-auto mb-2" style="width: 50px; height: 50px; font-size: 1.3rem;">
                <i class="bi bi-bank2"></i>
            </div>
            <h3 class="fw-bold text-emerald-dark mb-1" style="font-family: 'Playfair Display', serif;">HIGH COMMISSION OF THE FEDERAL REPUBLIC OF NIGERIA</h3>
            <div class="small text-gold fw-bold text-uppercase" style="letter-spacing: 2px;">NAIROBI, REPUBLIC OF KENYA — CONSULAR ENTRY VOUCHER</div>
        </div>

        <div class="row align-items-center g-4 mb-4">
            <div class="col-md-8">
                <span class="badge bg-success text-white mb-2"><i class="bi bi-check-circle-fill me-1"></i>CONFIRMED APPOINTMENT</span>
                <h2 class="fw-bold text-dark mb-1">Voucher #: <code><?= Helper::sanitize($appointment['voucher_number']) ?></code></h2>
                <div class="text-muted small">Issued on: <?= Helper::formatDate($appointment['created_at'], 'd M Y, h:i A') ?></div>
            </div>
            <div class="col-md-4 text-md-end text-center">
                <div class="p-3 bg-light border rounded-3 d-inline-block">
                    <i class="bi bi-qr-code fs-1 text-dark"></i>
                    <div class="small text-muted font-monospace">VERIFIED QR SEAL</div>
                </div>
            </div>
        </div>

        <!-- Appointment Details Table -->
        <table class="table table-bordered align-middle mb-4">
            <tbody>
                <tr>
                    <th class="bg-light w-35 text-secondary">Applicant Name</th>
                    <td class="fw-bold text-dark"><?= Helper::sanitize($appointment['applicant_name']) ?></td>
                </tr>
                <tr>
                    <th class="bg-light text-secondary">Email & Phone</th>
                    <td><?= Helper::sanitize($appointment['applicant_email']) ?> | <?= Helper::sanitize($appointment['applicant_phone']) ?></td>
                </tr>
                <tr>
                    <th class="bg-light text-secondary">Service Category</th>
                    <td class="fw-bold text-emerald-dark text-uppercase"><?= str_replace('_', ' ', $appointment['service_category']) ?></td>
                </tr>
                <tr>
                    <th class="bg-light text-secondary">Scheduled Date</th>
                    <td class="fw-bold text-dark fs-5"><?= Helper::formatDate($appointment['appointment_date'], 'l, d F Y') ?></td>
                </tr>
                <tr>
                    <th class="bg-light text-secondary">Scheduled Time Slot</th>
                    <td class="fw-bold text-success fs-5"><?= Helper::sanitize($appointment['time_slot']) ?> (Africa/Nairobi Time)</td>
                </tr>
                <tr>
                    <th class="bg-light text-secondary">Location</th>
                    <td>Lenana Road, Kilimani, Nairobi, Kenya</td>
                </tr>
            </tbody>
        </table>

        <div class="alert alert-light border small text-secondary mb-0">
            <i class="bi bi-info-circle-fill text-emerald me-1"></i><strong>Security Gate Notice:</strong> Present this voucher alongside your original passport or identification document at the security gate.
        </div>
    </div>
</div>
