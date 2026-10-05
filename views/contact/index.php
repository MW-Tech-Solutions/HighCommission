<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">OFFICIAL DIPLOMATIC CONTACT</span></div>
        <h1 class="display-6 fw-bold">Contact the High Commission</h1>
        <p class="max-w-700 mx-auto">Reach out to the High Commission of the Federal Republic of Nigeria in Nairobi, Kenya for consular assistance, trade inquiries, or diplomatic appointments.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-5">
        <div class="col-lg-5 d-flex">
            <div class="nhc-card p-4 p-md-5 w-100 bg-white d-flex flex-column justify-content-between">
                <div>
                    <h4 class="fw-bold text-emerald-dark mb-4" style="font-family: var(--font-heading);"><i class="bi bi-geo-alt-fill text-gold me-2"></i>Mission Location & Details</h4>
                    
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="nhc-service-icon flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.2rem;">
                            <i class="bi bi-building"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block" style="font-family: var(--font-heading);">Physical Address:</strong>
                            <span class="text-muted small">Lenana Road, Kilimani Area<br>P.O. Box 30516-00100<br>Nairobi, Republic of Kenya</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="nhc-service-icon flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.2rem;">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block" style="font-family: var(--font-heading);">Phone & Consular Desk:</strong>
                            <a href="tel:+254795770247" class="text-emerald fw-semibold small text-decoration-none">+254 795 770 247</a>
                        </div>
                    </div>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="nhc-service-icon flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.2rem;">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block" style="font-family: var(--font-heading);">Official Email Enquiries:</strong>
                            <a href="mailto:info@nigeriankenya.or.ke" class="text-emerald fw-semibold small text-decoration-none">info@nigeriankenya.or.ke</a>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mt-4 pt-3 border-top">
                    <div class="nhc-service-icon flex-shrink-0" style="width: 44px; height: 44px; font-size: 1.2rem;">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <strong class="text-dark d-block" style="font-family: var(--font-heading);">Public Consular Hours:</strong>
                        <span class="text-muted small">Monday to Friday: 9:00 AM - 3:00 PM</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 d-flex">
            <div class="nhc-card p-4 p-md-5 w-100 bg-white d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
                        <div class="nhc-service-icon bg-emerald-subtle text-emerald flex-shrink-0" style="width: 46px; height: 46px; font-size: 1.3rem;">
                            <i class="bi bi-chat-left-dots-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Send a General Enquiry</h4>
                            <span class="small text-muted">Complete the form below for diplomatic or consular matters.</span>
                        </div>
                    </div>

                    <form action="<?= Helper::baseUrl('contact') ?>" method="POST" class="d-flex flex-column justify-content-between h-100">
                        <?= Helper::csrfField() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Your Full Name</label>
                                <input type="text" name="name" class="form-control form-control-lg fs-6" required placeholder="e.g. Kiplagat Omondi / Tunde Emmanuel">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email Address</label>
                                <input type="email" name="email" class="form-control form-control-lg fs-6" required placeholder="e.g. email@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Phone / WhatsApp Number</label>
                                <input type="text" name="phone" class="form-control form-control-lg fs-6" required placeholder="e.g. +254 712 345 678">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Subject Category</label>
                                <select name="subject" class="form-select form-select-lg fs-6" required>
                                    <option value="">Select Category...</option>
                                    <option value="passport">E-Passport & Biometrics</option>
                                    <option value="visa">Visa Requirements</option>
                                    <option value="etc">Emergency Travel Certificate</option>
                                    <option value="legalization">Document Legalization / Attestation</option>
                                    <option value="trade">Trade & Investment Enquiry</option>
                                    <option value="general">General Diplomatic Enquiry</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small">Message / Inquiry Details</label>
                                <textarea name="message" class="form-control" rows="4" required placeholder="Provide specific details regarding your inquiry..."></textarea>
                            </div>
                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-emerald btn-lg px-5 shadow fw-bold">
                                    <i class="bi bi-send-fill me-2"></i>Send Enquiry Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
