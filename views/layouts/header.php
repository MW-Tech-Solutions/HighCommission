<?php
use App\Core\Helper;
use App\Core\Auth;
use App\Models\SystemSetting;

$user = Auth::user();
$flash = Helper::getFlash();

$missionName = SystemSetting::get('mission_name', 'High Commission of the Federal Republic of Nigeria');
$shortName = SystemSetting::get('short_name', 'Nigeria High Commission');
$appTagline = SystemSetting::get('app_tagline', 'Nairobi, Republic of Kenya');
$headerLogo = SystemSetting::getLogo('light_bg');
$faviconUrl = SystemSetting::getFaviconUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Helper::sanitize(SystemSetting::get('app_name', 'Nigeria High Commission Nairobi')) ?></title>
    <!-- Meta SEO -->
    <meta name="description" content="Official Portal of the High Commission of the Federal Republic of Nigeria in Nairobi, Kenya. Consular Services, Visas, Passports, Diaspora Registration & Document Verification.">
    
    <?php if (!empty($faviconUrl)): ?>
        <link rel="icon" href="<?= $faviconUrl ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= $faviconUrl ?>" type="image/x-icon">
    <?php endif; ?>

    <!-- Google Fonts (Exact Required Typography: Montserrat Bold, Open Sans 400/600, Poppins 600) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:ital,wght@0,400;0,600;1,400;1,600&family=Poppins:wght@600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Custom Diplomatic Design System CSS -->
    <link href="<?= Helper::baseUrl('assets/css/custom.css') ?>?v=<?= time() ?>" rel="stylesheet">
</head>
<body>

<!-- STICKY HEADER CONTAINER (SOVEREIGN DIPLOMATIC TWO-ROW HEADER) -->
<header class="nhc-header-container bg-white border-bottom border-3 border-emerald sticky-top">
    <div class="container">
        
        <!-- ROW 1: Identity, Diplomatic Motto & Website Search -->
        <div class="nhc-header-row1 py-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <!-- Brand Logo & Official Title -->
            <a class="nhc-brand-logo d-flex align-items-center gap-3 text-decoration-none" href="<?= Helper::baseUrl('/') ?>">
                <?php if ($headerLogo['has_image']): ?>
                    <img src="<?= $headerLogo['url'] ?>" alt="<?= Helper::sanitize($headerLogo['alt']) ?>" style="max-height: 56px; width: auto; object-fit: contain;">
                <?php else: ?>
                    <div class="nhc-crest-badge d-flex align-items-center justify-content-center rounded-2" style="width: 48px; height: 48px; background: #004D2C; border: 2px solid #D4AF37;">
                        <i class="bi bi-bank2 text-gold fs-4"></i>
                    </div>
                    <div>
                        <h1 class="nhc-brand-title m-0 fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 1.05rem; color: #004D2C; letter-spacing: -0.01em; text-transform: uppercase; line-height: 1.2;">
                            <?= Helper::sanitize($missionName) ?>
                        </h1>
                        <div class="nhc-brand-sub fw-bold" style="font-size: 0.8rem; color: #54B435; text-transform: uppercase; letter-spacing: 0.5px;">
                            <?= Helper::sanitize($appTagline) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Diplomatic Motto & Search Field -->
            <div class="d-none d-lg-flex align-items-center gap-4">
                <div class="text-end">
                    <div class="fst-italic fw-semibold text-secondary small" style="font-family: 'Playfair Display', serif; font-size: 0.92rem; color: #475569;">
                        Serving Nigerians &bull; Strengthening Nigeria–Kenya Relations
                    </div>
                    <div style="height: 2px; background: linear-gradient(90deg, transparent 0%, #D4AF37 50%, #008852 100%); margin-top: 3px;"></div>
                </div>

                <!-- Global Website Live Search Box -->
                <div class="position-relative" style="max-width: 270px;">
                    <form action="<?= Helper::baseUrl('search') ?>" method="GET" class="d-flex align-items-center" id="headerSearchForm">
                        <div class="input-group input-group-sm rounded-pill overflow-hidden border border-emerald bg-light">
                            <input type="text" name="q" id="headerSearchInput" class="form-control border-0 px-3 bg-light" placeholder="Search the website..." aria-label="Search the website" autocomplete="off">
                            <button class="btn btn-emerald border-0 px-3" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </form>

                    <!-- Live Search Dropdown Results Panel -->
                    <div id="liveSearchResults" class="dropdown-menu shadow-lg border-0 rounded-4 p-2 w-100 mt-2" 
                         style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 1060; max-height: 380px; overflow-y: auto; background: #ffffff; min-width: 320px;">
                    </div>
                </div>

                <!-- Emergency Contact Pill -->
                <a href="<?= Helper::baseUrl('emergency') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                    <i class="bi bi-bell-fill me-1"></i>Emergency
                </a>

                <!-- Portal Sign-in -->
                <?php if ($user): ?>
                    <a href="<?= Helper::baseUrl(in_array($user['role'], ['officer', 'editor', 'admin']) ? 'admin/dashboard' : 'portal/dashboard') ?>" class="btn btn-emerald btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-person-circle me-1"></i>My Portal
                    </a>
                <?php else: ?>
                    <a href="<?= Helper::baseUrl('portal/login') ?>" class="btn btn-emerald btn-sm rounded-pill px-3 fw-bold">
                        <i class="bi bi-box-arrow-in-right me-1"></i>My Portal
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Toggler -->
            <div class="d-lg-none d-flex align-items-center gap-2">
                <a href="<?= Helper::baseUrl('emergency') ?>" class="btn btn-danger btn-sm py-1 px-2 fw-bold">
                    <i class="bi bi-bell-fill"></i>
                </a>
                <button class="btn btn-emerald btn-sm py-1 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
                    <i class="bi bi-list fs-5"></i>
                </button>
            </div>
        </div>

    </div>

    <!-- ROW 2: Sovereign Dark Green Main Navigation Bar (Desktop) -->
    <div class="nhc-main-nav-bar d-none d-lg-block" style="background-color: #004D2C; border-top: 1px solid rgba(255, 255, 255, 0.15);">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark p-0">
                <ul class="navbar-nav d-flex align-items-center justify-content-between w-100 m-0 p-0 list-unstyled text-uppercase fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 0.85rem;">
                    
                    <!-- HOME -->
                    <li class="nav-item">
                        <a class="nav-link py-2.5 px-3 text-dark fw-bold" href="<?= Helper::baseUrl('/') ?>" style="background-color: #D4AF37; border-radius: 4px 4px 0 0; color: #0F172A !important;">
                            HOME
                        </a>
                    </li>
                    
                    <!-- THE MISSION -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2.5 px-3 text-white" href="<?= Helper::baseUrl('mission') ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            THE MISSION
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-3 text-none">
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('mission') ?>"><i class="bi bi-bank me-2 text-emerald"></i>Mandate & Bilateral Relations</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('mission/leadership') ?>"><i class="bi bi-person-badge me-2 text-emerald"></i>Mission Leadership</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('mission/message') ?>"><i class="bi bi-quote me-2 text-emerald"></i>High Commissioner's Message</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('mission/history') ?>"><i class="bi bi-journal-bookmark me-2 text-emerald"></i>Mission History</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('mission/friends-of-nigeria') ?>"><i class="bi bi-heart me-2 text-emerald"></i>Friends of Nigeria</a></li>
                        </ul>
                    </li>

                    <!-- CONSULAR SERVICES -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2.5 px-3 text-white" href="<?= Helper::baseUrl('services') ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            CONSULAR SERVICES
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-3">
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services') ?>"><i class="bi bi-grid me-2 text-emerald"></i>All Consular Services</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/passport') ?>"><i class="bi bi-passport me-2 text-emerald"></i>Passport Guidance & Renewal</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/visa') ?>"><i class="bi bi-card-checklist me-2 text-emerald"></i>Visa Categories & Entry Requirements</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/emergency-travel') ?>"><i class="bi bi-file-earmark-medical me-2 text-emerald"></i>Emergency Travel Cert (ETC)</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/document-support') ?>"><i class="bi bi-patch-check me-2 text-emerald"></i>Document Legalization & Attestation</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/fees') ?>"><i class="bi bi-currency-dollar me-2 text-emerald"></i>Approved Consular Fees</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('services/appointments') ?>"><i class="bi bi-calendar-event me-2 text-emerald"></i>Book Biometrics Appointment</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('track') ?>"><i class="bi bi-search me-2 text-emerald"></i>Track Application Status</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('verify') ?>"><i class="bi bi-shield-check me-2 text-success"></i>Official Seal Authenticator</a></li>
                        </ul>
                    </li>

                    <!-- NIGERIA -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2.5 px-3 text-white" href="<?= Helper::baseUrl('discover-nigeria') ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            NIGERIA
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-3">
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('discover-nigeria') ?>"><i class="bi bi-globe-africa me-2 text-emerald"></i>Culture, Tourism & Heritage</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('discover-nigeria/states') ?>"><i class="bi bi-geo-alt me-2 text-emerald"></i>Interactive 36 States Map</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('nigerians-in-kenya') ?>"><i class="bi bi-people me-2 text-emerald"></i>Nigerians in Kenya Hub</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('nigerians-in-kenya/register') ?>"><i class="bi bi-person-plus me-2 text-emerald"></i>Citizen Online Registration</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('discover-nigeria/government') ?>"><i class="bi bi-diagram-3 me-2 text-emerald"></i>Federal Government Structure</a></li>
                        </ul>
                    </li>

                    <!-- TRADE & INVESTMENT -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2.5 px-3 text-white" href="<?= Helper::baseUrl('trade') ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            TRADE & INVESTMENT
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-3">
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('trade') ?>"><i class="bi bi-graph-up-arrow me-2 text-emerald"></i>Bilateral Commerce & Trade Desk</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('trade/enquiry') ?>"><i class="bi bi-briefcase me-2 text-emerald"></i>Business Matchmaking Form</a></li>
                        </ul>
                    </li>

                    <!-- NEWS & MEDIA -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-2.5 px-3 text-white" href="<?= Helper::baseUrl('news') ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            NEWS & MEDIA
                        </a>
                        <ul class="dropdown-menu shadow border-0 rounded-3">
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('news') ?>"><i class="bi bi-newspaper me-2 text-emerald"></i>Newsroom & Press Releases</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('notices') ?>"><i class="bi bi-exclamation-square me-2 text-emerald"></i>Public Advisories & Notices</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('events') ?>"><i class="bi bi-calendar-event me-2 text-emerald"></i>Diplomatic Calendar & Events</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('gallery') ?>"><i class="bi bi-images me-2 text-emerald"></i>Photo Gallery</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('downloads') ?>"><i class="bi bi-download me-2 text-emerald"></i>Downloads & Official Forms</a></li>
                            <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('faq') ?>"><i class="bi bi-question-circle me-2 text-emerald"></i>Frequently Asked Questions</a></li>
                        </ul>
                    </li>

                    <!-- CONTACT -->
                    <li class="nav-item">
                        <a class="nav-link py-2.5 px-3 text-white" href="<?= Helper::baseUrl('contact') ?>">
                            CONTACT
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </div>
</header>

<!-- MOBILE OFFCANVAS NAVIGATION DRAWER -->
<div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header bg-emerald-light border-bottom border-emerald">
        <h5 class="offcanvas-title fw-bold text-emerald-dark" id="mobileMenuLabel" style="font-family: 'Playfair Display', serif;">Nigeria High Commission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="<?= Helper::baseUrl('search') ?>" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search services...">
                <button class="btn btn-emerald" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <div class="d-grid gap-2 mb-3">
            <a href="<?= Helper::baseUrl('emergency') ?>" class="btn btn-danger btn-sm fw-bold">
                <i class="bi bi-bell-fill me-1"></i>24/7 Emergency Support
            </a>
            <?php if ($user): ?>
                <a href="<?= Helper::baseUrl(in_array($user['role'], ['officer', 'editor', 'admin']) ? 'admin/dashboard' : 'portal/dashboard') ?>" class="btn btn-emerald btn-sm fw-bold">
                    <i class="bi bi-person-circle me-1"></i>My Portal Dashboard
                </a>
            <?php else: ?>
                <a href="<?= Helper::baseUrl('portal/login') ?>" class="btn btn-emerald btn-sm fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Sign In to Portal
                </a>
            <?php endif; ?>
        </div>

        <nav class="nav flex-column gap-1">
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('/') ?>"><i class="bi bi-house me-2 text-emerald"></i>Home</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('services') ?>"><i class="bi bi-grid me-2 text-emerald"></i>Consular Services</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('nigerians-in-kenya') ?>"><i class="bi bi-people me-2 text-emerald"></i>Nigerians in Kenya</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('discover-nigeria') ?>"><i class="bi bi-geo-alt me-2 text-emerald"></i>Discover Nigeria (36 States)</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('trade') ?>"><i class="bi bi-graph-up-arrow me-2 text-emerald"></i>Trade & Investment</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('mission') ?>"><i class="bi bi-bank me-2 text-emerald"></i>The Mission</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('news') ?>"><i class="bi bi-newspaper me-2 text-emerald"></i>Newsroom & Advisories</a>
            <a class="nav-link py-2 border-bottom text-dark fw-bold" href="<?= Helper::baseUrl('contact') ?>"><i class="bi bi-envelope me-2 text-emerald"></i>Contact Us</a>
        </nav>
    </div>
</div>

<!-- FLASH MESSAGES CONTAINER -->
<?php if ($flash): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= Helper::sanitize($flash['type']) ?> alert-dismissible fade show shadow-sm rounded-3 border-0" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i><?= Helper::sanitize($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Header Live Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('headerSearchInput');
    const searchResults = document.getElementById('liveSearchResults');
    let debounceTimer;

    if (!searchInput || !searchResults) return;

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            searchResults.style.display = 'none';
            searchResults.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            searchResults.style.display = 'block';
            searchResults.innerHTML = '<div class="p-3 text-center text-muted small"><span class="spinner-border spinner-border-sm text-emerald me-2" role="status"></span>Searching Mission Portal...</div>';

            fetch('<?= Helper::baseUrl("api/search") ?>?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data) || data.length === 0) {
                        searchResults.innerHTML = '<div class="p-3 text-center text-muted small"><i class="bi bi-search me-1"></i>No matching results for "<strong>' + escapeHtml(query) + '</strong>"</div>';
                        return;
                    }

                    let html = '<div class="small text-muted fw-bold px-2 py-1 border-bottom text-uppercase" style="font-size:0.68rem; letter-spacing:0.5px;">Live Search Results</div>';
                    data.forEach(item => {
                        html += `
                            <a href="${item.url}" class="dropdown-item p-2 rounded-3 text-wrap d-block text-decoration-none my-1 hover-bg-light">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold text-emerald small text-truncate me-2">${escapeHtml(item.title)}</span>
                                    <span class="badge bg-light text-dark border text-uppercase" style="font-size:0.65rem;">${escapeHtml(item.category)}</span>
                                </div>
                                <div class="text-secondary small text-truncate" style="font-size:0.75rem;">${escapeHtml(item.snippet)}</div>
                            </a>
                        `;
                    });
                    html += `<div class="p-2 border-top text-center"><a href="<?= Helper::baseUrl("search") ?>?q=${encodeURIComponent(query)}" class="small text-emerald fw-bold text-decoration-none">See all results for "${escapeHtml(query)}" &rarr;</a></div>`;
                    searchResults.innerHTML = html;
                })
                .catch(err => {
                    searchResults.style.display = 'none';
                });
        }, 220);
    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });

    // Close on Escape key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.style.display = 'none';
        }
    });
});
</script>
