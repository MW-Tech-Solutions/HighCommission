<?php
use App\Core\Helper;
use App\Models\SystemSetting;

$footerLogo = SystemSetting::getLogo('footer');
$copyrightText = SystemSetting::get('copyright_text', '© 2026 High Commission of the Federal Republic of Nigeria, Nairobi, Kenya. All Rights Reserved.');
$address = SystemSetting::get('chancery_address', 'Lenana Road, Kilimani, P.O. Box 30294-00100, Nairobi, Kenya');
$phone = SystemSetting::get('emergency_hotline', '+254 795 770 247');
$email = SystemSetting::get('chancery_email', 'info@nigeriankenya.or.ke');
$officeHours = SystemSetting::get('office_hours_summary', 'Monday – Friday: 8:30 AM – 4:30 PM');
$twitterUrl = SystemSetting::get('social_twitter');
$facebookUrl = SystemSetting::get('social_facebook');
$instagramUrl = SystemSetting::get('social_instagram');
?>
<!-- HIGH COMMISSION INTERACTIVE MAP SECTION -->
<div class="w-100 position-relative bg-dark" style="border-top: 4px solid #008751; border-bottom: 3px solid #D4AF37;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15955.234920239!2d36.789426!3d-1.28897!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f10a5bd9b48d5%3A0xcc7bb0ab2135dc64!2sNigeria%20High%20Commission!5e0!3m2!1sen!2ske!4v1791191520042!5m2!1sen!2ske" width="100%" height="450" style="border:0; display: block;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin" title="Nigeria High Commission Nairobi Google Map"></iframe>
</div>

<!-- NEWSLETTER SUBSCRIBE BANNER SECTION -->
<div class="py-5 text-white" style="background: linear-gradient(135deg, #004D2C 0%, #002B19 100%); border-bottom: 1px solid rgba(212, 175, 55, 0.3);">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background: rgba(212, 175, 55, 0.2); border: 1px solid #D4AF37;">
                    <i class="bi bi-envelope-paper-fill text-gold"></i>
                    <span class="small fw-bold text-gold text-uppercase tracking-wider">Stay Connected</span>
                </div>
                <h3 class="fw-bold text-white mb-2" style="font-family: 'Montserrat', sans-serif;">Subscribe to Official Dispatches</h3>
                <p class="text-white-80 mb-0 small">Receive diplomatic notices, holiday schedule advisories, trade briefings, and emergency bulletins directly in your inbox.</p>
            </div>
            <div class="col-lg-6">
                <form action="<?= Helper::baseUrl('newsletter/subscribe') ?>" method="POST" class="d-flex flex-column flex-sm-row gap-2" id="footerNewsletterForm">
                    <input type="hidden" name="csrf_token" value="<?= Helper::csrfToken() ?>">
                    <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="Enter your email address..." required style="background: #FFFFFF; color: #000000;">
                    <button type="submit" class="btn btn-gold btn-lg fw-bold px-4 flex-shrink-0 text-dark shadow-sm rounded-3">
                        <i class="bi bi-send-fill me-1"></i> Subscribe
                    </button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                    <span class="small text-white-50" style="font-size: 0.75rem;"><i class="bi bi-lock-fill me-1"></i> 100% Secure & Confidential</span>
                    <a href="<?= Helper::baseUrl('newsletter') ?>" class="small text-gold text-decoration-none fw-semibold" style="font-size: 0.78rem;">Visit Newsletter Hub &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MAIN FOOTER (SOVEREIGN BRAND DARK GREEN SURFACES) -->
<footer class="pt-5 pb-4 text-light mt-auto" style="background-color: #002B19; border-top: 4px solid #D4AF37;">
    <div class="container">
        <div class="row g-4 mb-4">
            
            <!-- Col 1: Coat of Arms Identity & Direct Contacts -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <?php if ($footerLogo['has_image']): ?>
                        <img src="<?= $footerLogo['url'] ?>" alt="<?= Helper::sanitize($footerLogo['alt']) ?>" style="max-height: 52px; width: auto; object-fit: contain;">
                    <?php else: ?>
                        <div class="nhc-crest-badge" style="width: 48px; height: 48px; font-size: 1.3rem; background: #000000; border: 2px solid #D4AF37;">
                            <i class="bi bi-bank2 text-gold"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h6 class="fw-bold mb-0 text-white" style="font-family: 'Montserrat', sans-serif; font-size: 0.95rem; text-transform: uppercase; letter-spacing: -0.01em;">
                            High Commission of the Federal Republic of Nigeria
                        </h6>
                        <div class="small text-gold fw-semibold" style="font-size: 0.8rem;">Nairobi, Kenya</div>
                    </div>
                </div>

                <ul class="list-unstyled small d-flex flex-column gap-2 mb-3" style="color: rgba(255, 255, 255, 0.85);">
                    <li class="d-flex align-items-start gap-2">
                        <i class="bi bi-geo-alt-fill text-gold mt-1 flex-shrink-0"></i>
                        <span>Off Ngong Road, Nairobi, Kenya</span>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-telephone-fill text-gold flex-shrink-0"></i>
                        <a href="tel:+254202712733" class="text-white text-decoration-none">+254 20 2712733 / 4</a>
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-envelope-fill text-gold flex-shrink-0"></i>
                        <a href="mailto:info@nigeriankenya.or.ke" class="text-white text-decoration-none">info@nigeriankenya.or.ke</a>
                    </li>
                </ul>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="nhc-footer-title mb-3 text-gold fw-bold text-uppercase" style="font-size: 0.85rem;">Quick Links</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="<?= Helper::baseUrl('services/passport') ?>" class="text-white-80 text-decoration-none">Passport Services</a></li>
                    <li><a href="<?= Helper::baseUrl('services/visa') ?>" class="text-white-80 text-decoration-none">Visa Services</a></li>
                    <li><a href="<?= Helper::baseUrl('services') ?>" class="text-white-80 text-decoration-none">Consular Services</a></li>
                    <li><a href="<?= Helper::baseUrl('nigerians-in-kenya/register') ?>" class="text-white-80 text-decoration-none">Citizen Registration</a></li>
                    <li><a href="<?= Helper::baseUrl('contact') ?>" class="text-white-80 text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Col 3: Useful Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="nhc-footer-title mb-3 text-gold fw-bold text-uppercase" style="font-size: 0.85rem;">Useful Links</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="https://foreignaffairs.gov.ng" target="_blank" rel="noopener" class="text-white-80 text-decoration-none">Nigerian Government</a></li>
                    <li><a href="https://passport.immigration.gov.ng" target="_blank" rel="noopener" class="text-white-80 text-decoration-none">Nigerian Immigration Service</a></li>
                    <li><a href="https://nipc.gov.ng" target="_blank" rel="noopener" class="text-white-80 text-decoration-none">NIPC (Investment)</a></li>
                    <li><a href="<?= Helper::baseUrl('trade') ?>" class="text-white-80 text-decoration-none">Trade & Investment</a></li>
                    <li><a href="<?= Helper::baseUrl('discover-nigeria') ?>" class="text-white-80 text-decoration-none">Tourism Nigeria</a></li>
                </ul>
            </div>

            <!-- Col 4: Site Information -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="nhc-footer-title mb-3 text-gold fw-bold text-uppercase" style="font-size: 0.85rem;">Site Information</h6>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="<?= Helper::baseUrl('privacy') ?>" class="text-white-80 text-decoration-none">Privacy Policy</a></li>
                    <li><a href="<?= Helper::baseUrl('accessibility') ?>" class="text-white-80 text-decoration-none">Accessibility</a></li>
                    <li><a href="<?= Helper::baseUrl('sitemap') ?>" class="text-white-80 text-decoration-none">Sitemap</a></li>
                    <li><a href="<?= Helper::baseUrl('terms') ?>" class="text-white-80 text-decoration-none">Terms of Use</a></li>
                    <li><a href="<?= Helper::baseUrl('admin/login') ?>" class="text-gold fw-bold text-decoration-none"><i class="bi bi-lock-fill me-1"></i>Staff Portal</a></li>
                </ul>
            </div>

            <!-- Col 5: Follow Us & Scan QR Code -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 class="nhc-footer-title mb-3 text-gold fw-bold text-uppercase" style="font-size: 0.85rem;">Follow Us</h6>
                <div class="d-flex gap-2 mb-3">
                    <a href="#" class="nhc-social-btn" title="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="nhc-social-btn" title="Twitter/X"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="nhc-social-btn" title="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="nhc-social-btn" title="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="nhc-social-btn" title="LinkedIn"><i class="bi bi-linkedin"></i></a>
                </div>

                <div class="p-2 bg-white rounded-3 d-inline-block text-center text-dark shadow-sm">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?= urlencode(Helper::baseUrl('/')) ?>" alt="Scan QR Code" width="70" height="70" class="d-block mx-auto mb-1">
                    <div class="extra-small fw-bold" style="font-size: 0.65rem; color: #0F172A;">Scan to visit<br>our website</div>
                </div>
            </div>

        </div>

        <hr class="border-secondary opacity-30 my-3">

        <!-- Bottom Copyright Bar with Flag Badge -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small gap-2 text-white-80" style="font-size: 0.82rem;">
            <div>
                © 2026 High Commission of the Federal Republic of Nigeria. All rights reserved.
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="small opacity-85">Official Sovereign Portal</span>
                <!-- Green-White-Green Flag Badge -->
                <div class="d-inline-flex border rounded overflow-hidden" style="width: 24px; height: 16px;">
                    <div style="width: 33.3%; height: 100%; background-color: #008751;"></div>
                    <div style="width: 33.3%; height: 100%; background-color: #FFFFFF;"></div>
                    <div style="width: 33.3%; height: 100%; background-color: #008751;"></div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 JavaScript Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Application JavaScript -->
<script src="<?= Helper::baseUrl('assets/js/app.js') ?>"></script>
</body>
</html>
