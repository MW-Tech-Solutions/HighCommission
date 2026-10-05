<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-700 mx-auto">
        <h2 class="fw-bold text-emerald-dark mb-2" style="font-family: 'Playfair Display', serif;">Consular Service Feedback</h2>
        <p class="text-muted small mb-4">Help us improve consular services by submitting your feedback or experience rating.</p>

        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
            <form action="<?= Helper::baseUrl('feedback') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Your Full Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Kiplagat / Tunde">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="applicant@example.com">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Service Evaluated</label>
                    <select name="service" class="form-select" required>
                        <option value="Passport Biometrics">Passport Renewal Biometrics</option>
                        <option value="Visa Application">Visa Application Processing</option>
                        <option value="ETC Application">Emergency Travel Certificate</option>
                        <option value="Document Attestation">Document Legalization</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Feedback Comments</label>
                    <textarea name="comments" class="form-control" rows="4" required placeholder="Share your experience..."></textarea>
                </div>
                <button type="submit" class="btn btn-emerald w-100 fw-bold">Submit Feedback</button>
            </form>
        </div>
    </div>
</div>
