<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Public Sitemap</h1>
        <p class="text-muted">Human-readable index of all public routes and consular services. (XML sitemap available at <a href="<?= Helper::baseUrl('sitemap.xml') ?>" target="_blank">sitemap.xml</a>).</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-emerald mb-3">Consular Services</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="<?= Helper::baseUrl('services') ?>">Service Directory</a></li>
                    <li><a href="<?= Helper::baseUrl('services/passport') ?>">E-Passport Guidance</a></li>
                    <li><a href="<?= Helper::baseUrl('services/visa') ?>">Visa Requirements & Quiz</a></li>
                    <li><a href="<?= Helper::baseUrl('services/emergency-travel') ?>">Emergency Travel Cert (ETC)</a></li>
                    <li><a href="<?= Helper::baseUrl('services/document-support') ?>">Document Legalization</a></li>
                    <li><a href="<?= Helper::baseUrl('services/fees') ?>">Consular Fees Schedule</a></li>
                    <li><a href="<?= Helper::baseUrl('services/appointments') ?>">Book Biometrics Slot</a></li>
                    <li><a href="<?= Helper::baseUrl('verify') ?>">Document Authenticator</a></li>
                    <li><a href="<?= Helper::baseUrl('track') ?>">Track Case Request</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-emerald mb-3">Diaspora & Country Info</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="<?= Helper::baseUrl('nigerians-in-kenya') ?>">Diaspora Overview</a></li>
                    <li><a href="<?= Helper::baseUrl('nigerians-in-kenya/register') ?>">Online Citizen Registration</a></li>
                    <li><a href="<?= Helper::baseUrl('nigerians-in-kenya/community') ?>">Community Directory</a></li>
                    <li><a href="<?= Helper::baseUrl('emergency') ?>">24/7 Emergency Support</a></li>
                    <li><a href="<?= Helper::baseUrl('discover-nigeria') ?>">Discover Nigeria Culture</a></li>
                    <li><a href="<?= Helper::baseUrl('discover-nigeria/states') ?>">Interactive 36 States Map</a></li>
                    <li><a href="<?= Helper::baseUrl('discover-nigeria/government') ?>">Government Structure</a></li>
                    <li><a href="<?= Helper::baseUrl('trade') ?>">Trade & Investment Gateway</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold text-emerald mb-3">The Mission & News</h5>
                <ul class="list-unstyled small d-flex flex-column gap-2 mb-0">
                    <li><a href="<?= Helper::baseUrl('mission') ?>">Mission Mandate</a></li>
                    <li><a href="<?= Helper::baseUrl('mission/leadership') ?>">Mission Leadership</a></li>
                    <li><a href="<?= Helper::baseUrl('mission/history') ?>">Bilateral History</a></li>
                    <li><a href="<?= Helper::baseUrl('mission/message') ?>">High Commissioner Message</a></li>
                    <li><a href="<?= Helper::baseUrl('news') ?>">Newsroom & Advisories</a></li>
                    <li><a href="<?= Helper::baseUrl('contact') ?>">Contact & Location</a></li>
                    <li><a href="<?= Helper::baseUrl('official-channels') ?>">Official Channels & Scam Protection</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
