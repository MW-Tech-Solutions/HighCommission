<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-450 mx-auto">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Set New Password</h3>
            <p class="text-muted small">Enter your new secure password below.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 p-4 bg-white mb-4">
            <form action="<?= Helper::baseUrl('reset-password') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold small">New Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small">Confirm New Password</label>
                    <input type="password" name="password_confirm" class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold mb-3">
                    Update Password & Sign In
                </button>
            </form>
        </div>
    </div>
</div>
