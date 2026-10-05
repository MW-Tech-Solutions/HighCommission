<?php
use App\Core\Helper;
use App\Models\SystemSetting;

$authLogo = SystemSetting::getLogo('auth');
$missionName = SystemSetting::get('mission_name', 'High Commission of the Federal Republic of Nigeria');
$shortName = SystemSetting::get('short_name', 'Nigeria High Commission');
$appTagline = SystemSetting::get('app_tagline', 'Nairobi, Republic of Kenya');
?>
<div class="container py-5">
    <div class="nhc-auth-container">
        <div class="nhc-auth-card shadow-lg">
            <div class="row g-0">
                <!-- Left Banner (Diplomatic Visual Surface) -->
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

                        <h4 class="fw-bold text-white mb-3" style="font-family: 'Montserrat', sans-serif;">Official Consular Portal</h4>
                        <p class="small text-white-50 mb-4" style="line-height: 1.6;">
                            Access your citizen registration, submitted visa and passport applications, appointment scheduling, document legalization, and secure messaging threads.
                        </p>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-shield-lock-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white">SSL Encrypted Authentication</div>
                                    <div class="small text-white-50">State-grade data privacy and secure session controls.</div>
                                </div>
                            </div>
                            <div class="nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-search"></i></div>
                                <div>
                                    <div class="fw-bold text-white">Live Request & Status Tracking</div>
                                    <div class="small text-white-50">Real-time updates on consular cases and biometrics.</div>
                                </div>
                            </div>
                            <div class="nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-patch-check-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white">Document Authenticator</div>
                                    <div class="small text-white-50">Cryptographic verification of consular receipts & certificates.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Demo Accounts Switcher -->
                    <div class="pt-3 border-top border-white border-opacity-20 mt-3">
                        <div class="small text-gold fw-bold mb-2"><i class="bi bi-person-badge me-1"></i>Demonstration Accounts (Click to Fill)</div>
                        <div class="d-flex flex-wrap gap-1">
                            <button type="button" onclick="document.getElementById('login_email').value='admin@nigeriankenya.or.ke';document.getElementById('login_password').value='Password123!';" class="btn btn-sm btn-outline-danger flex-grow-1" style="font-size: 0.75rem;">
                                Admin Demo
                            </button>
                            <button type="button" onclick="document.getElementById('login_email').value='officer@nigeriankenya.or.ke';document.getElementById('login_password').value='Password123!';" class="btn btn-sm btn-outline-warning flex-grow-1" style="font-size: 0.75rem;">
                                Staff Demo
                            </button>
                            <button type="button" onclick="document.getElementById('login_email').value='tunde.demo@example.com';document.getElementById('login_password').value='Password123!';" class="btn btn-sm btn-outline-light flex-grow-1" style="font-size: 0.75rem;">
                                Citizen Demo
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Interactive Form Area -->
                <div class="col-lg-7 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                    <!-- Navigation Tabs -->
                    <div class="nhc-auth-nav-tabs">
                        <a href="<?= Helper::baseUrl('portal/login') ?>" class="nhc-auth-nav-link active">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </a>
                        <a href="<?= Helper::baseUrl('portal/register') ?>" class="nhc-auth-nav-link">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </a>
                    </div>

                    <h3 class="fw-bold text-emerald-dark mb-1" style="font-family: 'Montserrat', sans-serif;">Sign In to Portal</h3>
                    <p class="text-muted small mb-4">Please enter your authorized email and password to proceed.</p>

                    <form action="<?= Helper::baseUrl('portal/login') ?>" method="POST" id="loginForm">
                        <?= Helper::csrfField() ?>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Registered Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-emerald"></i></span>
                                <input type="email" id="login_email" name="email" class="form-control border-start-0" required placeholder="name@example.com" autocomplete="email">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-bold small text-dark mb-0">Password</label>
                                <a href="<?= Helper::baseUrl('forgot-password') ?>" class="small text-emerald fw-semibold text-decoration-none">Forgot Password?</a>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-emerald"></i></span>
                                <input type="password" id="login_password" name="password" class="form-control border-start-0 border-end-0" required placeholder="••••••••" autocomplete="current-password">
                                <button type="button" class="btn btn-light border border-start-0" onclick="togglePasswordVisibility('login_password', this)" title="Show/Hide Password">
                                    <i class="bi bi-eye text-muted"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember" value="1">
                            <label class="form-check-label small text-muted" for="remember">
                                Keep me signed in on this trusted browser
                            </label>
                        </div>

                        <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold shadow-sm py-3 mb-4" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Portal
                        </button>
                    </form>

                    <div class="text-center small text-muted border-top pt-3">
                        Need official emergency assistance? <a href="<?= Helper::baseUrl('emergency') ?>" class="text-danger fw-bold text-decoration-none"><i class="bi bi-bell-fill me-1"></i>24/7 Consular Hotline</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
