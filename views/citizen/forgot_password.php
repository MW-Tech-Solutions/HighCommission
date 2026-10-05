<?php
use App\Core\Helper;
use App\Models\SystemSetting;

$authLogo = SystemSetting::getLogo('auth');
$shortName = SystemSetting::get('short_name', 'Nigeria High Commission');
$appTagline = SystemSetting::get('app_tagline', 'Nairobi, Republic of Kenya');
?>
<div class="container py-5">
    <div class="nhc-auth-container">
        <div class="nhc-auth-card shadow-lg">
            <div class="row g-0">
                <!-- Left Banner -->
                <div class="col-lg-5 nhc-auth-banner">
                    <div>
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <?php if ($authLogo['has_image']): ?>
                                <img src="<?= $authLogo['url'] ?>" alt="<?= Helper::sanitize($authLogo['alt']) ?>" style="max-height: 54px; width: auto; object-fit: contain;">
                            <?php else: ?>
                                <div class="nhc-auth-banner-crest">
                                    <i class="bi bi-bank2"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <h5 class="fw-bold mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-size: 1.05rem; text-transform: uppercase;"><?= Helper::sanitize($shortName) ?></h5>
                                <div class="small text-gold fw-semibold" style="font-size: 0.75rem; text-transform: uppercase;"><?= Helper::sanitize($appTagline) ?></div>
                            </div>
                        </div>

                        <h4 class="fw-bold text-white mb-3" style="font-family: 'Montserrat', sans-serif;">Account Recovery</h4>
                        <p class="small text-white-50 mb-4" style="line-height: 1.6;">
                            If you lost access to your applicant account, enter your registered email address to receive a secure time-limited password reset link.
                        </p>
                    </div>

                    <div class="pt-3 border-top border-white border-opacity-20 mt-3">
                        <div class="small text-gold fw-bold mb-1"><i class="bi bi-shield-lock me-1"></i>Secure Password Recovery</div>
                        <div class="small text-white-50">Token hashes expire automatically after 60 minutes.</div>
                    </div>
                </div>

                <!-- Right Form Area -->
                <div class="col-lg-7 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                    <h3 class="fw-bold text-emerald-dark mb-1" style="font-family: 'Montserrat', sans-serif;">Password Recovery</h3>
                    <p class="text-muted small mb-4">Enter your registered email address to receive password reset instructions.</p>

                    <form action="<?= Helper::baseUrl('forgot-password') ?>" method="POST">
                        <?= Helper::csrfField() ?>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Registered Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-emerald"></i></span>
                                <input type="email" name="email" class="form-control border-start-0" required placeholder="tunde@example.com">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold shadow-sm py-3 mb-4" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
                            <i class="bi bi-send-fill me-2"></i>Send Recovery Link
                        </button>

                        <div class="text-center small">
                            <a href="<?= Helper::baseUrl('portal/login') ?>" class="text-emerald fw-bold text-decoration-none">&larr; Return to Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
