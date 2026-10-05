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

                        <h4 class="fw-bold text-white mb-3" style="font-family: 'Montserrat', sans-serif;">Register Applicant Account</h4>
                        <p class="small text-white-50 mb-4" style="line-height: 1.6;">
                            Create your official portal account to register as a Nigerian in Kenya, submit visa or passport enquiries, book appointment slots, and manage consular cases.
                        </p>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-person-check-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white">Online Citizen Registration</div>
                                    <div class="small text-white-50">Generate official Diaspora Registration Record (REC-...)</div>
                                </div>
                            </div>
                            <div class="nhc-auth-feature-icon-item nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-calendar-event-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white">Biometrics & Interview Slots</div>
                                    <div class="small text-white-50">Reserve confirmed appointment vouchers.</div>
                                </div>
                            </div>
                            <div class="nhc-auth-feature-item">
                                <div class="nhc-auth-feature-icon"><i class="bi bi-chat-left-dots-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white">Direct Messaging with Officers</div>
                                    <div class="small text-white-50">Secure case conversation thread & status updates.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top border-white border-opacity-20 mt-3">
                        <div class="small text-gold fw-bold mb-1"><i class="bi bi-shield-check me-1"></i>Official Mission Portal</div>
                        <div class="small text-white-50">Compliant with MFA & Nigeria Data Protection Regulation (NDPR).</div>
                    </div>
                </div>

                <!-- Right Interactive Form Area -->
                <div class="col-lg-7 p-4 p-md-5 bg-white d-flex flex-column justify-content-center">
                    <!-- Navigation Tabs -->
                    <div class="nhc-auth-nav-tabs">
                        <a href="<?= Helper::baseUrl('portal/login') ?>" class="nhc-auth-nav-link">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                        </a>
                        <a href="<?= Helper::baseUrl('portal/register') ?>" class="nhc-auth-nav-link active">
                            <i class="bi bi-person-plus me-2"></i>Create Account
                        </a>
                    </div>

                    <h3 class="fw-bold text-emerald-dark mb-1" style="font-family: 'Montserrat', sans-serif;">Create Portal Account</h3>
                    <p class="text-muted small mb-4">Fill in your details below to set up your consular applicant profile.</p>

                    <form action="<?= Helper::baseUrl('portal/register') ?>" method="POST" id="registerForm">
                        <?= Helper::csrfField() ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">Full Legal Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-emerald"></i></span>
                                    <input type="text" name="full_name" class="form-control border-start-0" required placeholder="e.g. Tunde Emmanuel">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-emerald"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0" required placeholder="name@example.com">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">Phone Number in Kenya</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-emerald"></i></span>
                                    <input type="text" name="phone" class="form-control border-start-0" required placeholder="+254 700 000 000">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">Nigerian Passport # <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-passport text-emerald"></i></span>
                                    <input type="text" name="passport_number" class="form-control border-start-0" placeholder="A00123456">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">NIN Number <span class="text-muted fw-normal">(Optional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-text text-emerald"></i></span>
                                    <input type="text" name="nin_number" class="form-control border-start-0" placeholder="11-digit NIN">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-dark mb-1">Account Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-emerald"></i></span>
                                    <input type="password" id="reg_password" name="password" class="form-control border-start-0 border-end-0" required placeholder="Minimum 6 characters">
                                    <button type="button" class="btn btn-light border border-start-0" onclick="togglePasswordVisibility('reg_password', this)" title="Show/Hide Password">
                                        <i class="bi bi-eye text-muted"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label small text-muted" for="terms">
                                I confirm that all provided details are true and consent to official processing under <a href="<?= Helper::baseUrl('privacy') ?>" class="text-emerald fw-semibold">Privacy Policy</a>.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold shadow-sm py-3 mb-3" style="font-family: 'Poppins', sans-serif; font-size: 1rem;">
                            <i class="bi bi-person-plus-fill me-2"></i>Create Applicant Account
                        </button>
                    </form>

                    <div class="text-center small text-muted">
                        Already have an account? <a href="<?= Helper::baseUrl('portal/login') ?>" class="text-emerald fw-bold text-decoration-none">Sign In here</a>
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
