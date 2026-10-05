<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-700 mx-auto">
        <h2 class="fw-bold text-danger mb-2" style="font-family: 'Playfair Display', serif;"><i class="bi bi-shield-slash me-2"></i>Report Suspicious Activity / Fake Website</h2>
        <p class="text-muted small mb-4">Report unauthorized mirror sites, fraudulent fee solicitations, or suspicious emails claiming to represent the High Commission.</p>

        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
            <form action="<?= Helper::baseUrl('report-suspicious') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Your Name (Optional)</label>
                    <input type="text" name="reporter_name" class="form-control" placeholder="Reporter name">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Your Email Address</label>
                    <input type="email" name="reporter_email" class="form-control" required placeholder="email@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Suspicious URL / Phone Number / Email Address</label>
                    <input type="text" name="suspicious_source" class="form-control" required placeholder="e.g. suspicious-domain.org or +254 700 000 000">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Description of Suspicious Activity</label>
                    <textarea name="details" class="form-control" rows="4" required placeholder="Provide details of the fraudulent fee request or unauthorized website..."></textarea>
                </div>
                <button type="submit" class="btn btn-danger w-100 fw-bold"><i class="bi bi-shield-exclamation me-1"></i>Lodge Security Incident Report</button>
            </form>
        </div>
    </div>
</div>
