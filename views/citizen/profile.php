<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-700 mx-auto">
        <h2 class="fw-bold text-emerald-dark mb-4" style="font-family: 'Playfair Display', serif;">My Profile & Contact Settings</h2>

        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white mb-4">
            <form action="<?= Helper::baseUrl('portal/profile') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Full Name</label>
                        <input type="text" class="form-control" value="<?= Helper::sanitize($user['full_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" class="form-control" value="<?= Helper::sanitize($user['email']) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Passport Booklet Number</label>
                        <input type="text" class="form-control" value="<?= Helper::sanitize($user['passport_number'] ?? '') ?>" placeholder="A00123456">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">National Identification Number (NIN)</label>
                        <input type="text" class="form-control" value="<?= Helper::sanitize($user['nin_number'] ?? '') ?>" placeholder="11-digit NIN">
                    </div>
                </div>
                <button type="submit" class="btn btn-emerald fw-bold mt-4">Save Profile Changes</button>
            </form>
        </div>
    </div>
</div>
