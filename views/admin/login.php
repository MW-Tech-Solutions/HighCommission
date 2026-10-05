<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-450 mx-auto">
        <div class="text-center mb-4">
            <div class="nhc-crest-badge mx-auto mb-2" style="width: 50px; height: 50px; font-size: 1.3rem;">
                <i class="bi bi-bank2"></i>
            </div>
            <h3 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Staff & Admin Workspace</h3>
            <p class="text-muted small">High Commission Authorized Officer Authentication Portal.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 p-4 bg-white mb-4">
            <form action="<?= Helper::baseUrl('admin/login') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Official Staff Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="email" id="admin_email" name="email" class="form-control" required placeholder="officer@nigeriankenya.or.ke">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" id="admin_password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold mb-3">
                    <i class="bi bi-shield-lock-fill me-2"></i>Authenticate Staff Access
                </button>
            </form>
        </div>

        <div class="card p-3 border-0 bg-light rounded-3 text-center small">
            <div class="fw-bold text-dark mb-2"><i class="bi bi-key-fill text-gold me-1"></i>Demonstration Staff Accounts</div>
            <div class="d-flex justify-content-center gap-2">
                <button type="button" onclick="document.getElementById('admin_email').value='officer@nigeriankenya.or.ke';document.getElementById('admin_password').value='Password123!';" class="btn btn-outline-success btn-sm">
                    Consular Officer
                </button>
                <button type="button" onclick="document.getElementById('admin_email').value='editor@nigeriankenya.or.ke';document.getElementById('admin_password').value='Password123!';" class="btn btn-outline-success btn-sm">
                    CMS Editor
                </button>
                <button type="button" onclick="document.getElementById('admin_email').value='admin@nigeriankenya.or.ke';document.getElementById('admin_password').value='Password123!';" class="btn btn-outline-danger btn-sm">
                    Super Admin
                </button>
            </div>
        </div>
    </div>
</div>
