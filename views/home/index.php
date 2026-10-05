<?php use App\Core\Helper; ?>

<!-- HERO SECTION: ADMIN-MANAGED SLIDESHOW WITH FLOATING QUICK ACTION PILLS -->
<section class="nhc-hero-section position-relative overflow-hidden" style="background: #002B19;">
    <?php if (empty($heroSlides)): ?>
        <!-- Intentional Readable Fallback Banner -->
        <div class="container position-relative z-1 py-5 text-center text-light">
            <span class="badge bg-gold text-dark mb-3 px-3 py-2 fw-bold text-uppercase" style="letter-spacing: 1px;">
                <i class="bi bi-bank2 me-1"></i> HIGH COMMISSION OF NIGERIA NAIROBI
            </span>
            <h1 class="display-4 fw-bold text-white mb-3" style="font-family: 'Playfair Display', serif;">
                Serving Nigerians &bull; Strengthening Nigeria–Kenya Relations
            </h1>
            <p class="lead opacity-90 mx-auto mb-4 max-w-700" style="color: #E2E8F0;">
                Official web portal of the High Commission of the Federal Republic of Nigeria in Nairobi, serving citizens, bilateral partners, and visitors across Kenya, Somalia, and Seychelles.
            </p>
        </div>
    <?php else: ?>
        <!-- Bootstrap Carousel Container -->
        <div id="nhcHeroCarousel" class="carousel slide carousel-fade position-relative" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                <?php foreach ($heroSlides as $idx => $slide): ?>
                    <?php
                        $imageDesktop = Helper::baseUrl($slide['image_desktop']);
                        $imageMobile = !empty($slide['image_mobile']) ? Helper::baseUrl($slide['image_mobile']) : $imageDesktop;
                    ?>
                    <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?> position-relative" style="min-height: 480px; background: #0C1406;">
                        <!-- Background Image -->
                        <picture>
                            <source media="(max-width: 767px)" srcset="<?= $imageMobile ?>">
                            <img src="<?= $imageDesktop ?>" class="d-block w-100 position-absolute top-0 start-0 h-100" alt="<?= Helper::sanitize($slide['image_alt']) ?>" style="object-fit: cover; filter: brightness(0.65);">
                        </picture>

                        <!-- Slide Caption Overlay -->
                        <div class="container position-relative z-1 py-5">
                            <div class="row align-items-center" style="min-height: 380px;">
                                <div class="col-lg-8">
                                    <div class="p-4 rounded-4 bg-dark bg-opacity-75 text-white border border-light border-opacity-25 backdrop-blur shadow-lg">
                                        <span class="badge bg-gold text-dark mb-2 px-3 py-1.5 fw-bold text-uppercase" style="font-size: 0.78rem;">
                                            <i class="bi bi-bank2 me-1"></i> NIGERIA HIGH COMMISSION NAIROBI
                                        </span>
                                        <h1 class="display-5 fw-bold text-white mb-3" style="font-family: 'Playfair Display', serif;">
                                            <?= Helper::sanitize($slide['heading']) ?>
                                        </h1>
                                        <?php if (!empty($slide['subheading'])): ?>
                                            <p class="lead opacity-90 mb-4 fs-6 text-light">
                                                <?= Helper::sanitize($slide['subheading']) ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex flex-wrap gap-3">
                                            <?php if (!empty($slide['cta_primary_label']) && !empty($slide['cta_primary_url'])): ?>
                                                <a href="<?= Helper::baseUrl($slide['cta_primary_url']) ?>" class="btn btn-emerald btn-lg px-4 fw-bold">
                                                    <?= Helper::sanitize($slide['cta_primary_label']) ?> <i class="bi bi-arrow-right ms-1"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!empty($slide['cta_secondary_label']) && !empty($slide['cta_secondary_url'])): ?>
                                                <a href="<?= Helper::baseUrl($slide['cta_secondary_url']) ?>" class="btn btn-outline-light btn-lg px-4 fw-bold">
                                                    <?= Helper::sanitize($slide['cta_secondary_label']) ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <?php if (count($heroSlides) > 1): ?>
                <button class="carousel-control-prev z-2" type="button" data-bs-target="#nhcHeroCarousel" data-bs-slide="prev" aria-label="Previous Slide">
                    <span class="bg-dark bg-opacity-75 text-white p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </span>
                </button>
                <button class="carousel-control-next z-2" type="button" data-bs-target="#nhcHeroCarousel" data-bs-slide="next" aria-label="Next Slide">
                    <span class="bg-dark bg-opacity-75 text-white p-3 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </span>
                </button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- 3 FLOATING ACTION PILLS CENTERED AT BOTTOM OF HERO -->
    <div class="position-relative z-3 container" style="margin-top: -32px;">
        <div class="row g-3 justify-content-center">
            <div class="col-md-4 col-sm-6">
                <a href="<?= Helper::baseUrl('services') ?>" class="btn btn-emerald w-100 py-3 px-4 rounded-pill shadow-lg d-flex align-items-center justify-content-between text-white fw-bold">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-briefcase-fill fs-5"></i> CONSULAR SERVICES
                    </span>
                    <i class="bi bi-arrow-right fs-5"></i>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Helper::baseUrl('services/visa') ?>" class="btn btn-light border-emerald text-emerald-dark w-100 py-3 px-4 rounded-pill shadow-lg d-flex align-items-center justify-content-between fw-bold">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-card-checklist fs-5 text-emerald"></i> VISA SERVICES
                    </span>
                    <i class="bi bi-arrow-right fs-5 text-emerald"></i>
                </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <a href="<?= Helper::baseUrl('services/passport') ?>" class="btn btn-gold w-100 py-3 px-4 rounded-pill shadow-lg d-flex align-items-center justify-content-between text-dark fw-bold">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-passport fs-5"></i> PASSPORT SERVICES
                    </span>
                    <i class="bi bi-arrow-right fs-5"></i>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- SECTION 1: QUICK SERVICES (6 CARDS HORIZONTAL GRID) -->
<section class="py-5" style="background-color: var(--brand-pale);">
    <div class="container py-2">
        <div class="mb-4">
            <div style="width: 40px; height: 3px; background-color: #D4AF37;" class="mb-2"></div>
            <h2 class="fw-bold text-emerald-dark m-0" style="font-family: 'Montserrat', sans-serif; font-size: 1.6rem;">QUICK SERVICES</h2>
            <p class="text-muted small m-0">Find the services you need, quickly and easily.</p>
        </div>

        <div class="row g-3">
            <!-- 1. Passport -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('services/passport') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-passport"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Passport</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">Apply, renew, replace</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>

            <!-- 2. Visa -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('services/visa') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Visa</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">Types, requirements, apply online</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>

            <!-- 3. Citizen Registration -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('nigerians-in-kenya/register') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-person-fill-add"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Citizen Registration</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">Register with the Mission</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>

            <!-- 4. Emergency Travel Certificate -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('services/emergency-travel') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-file-earmark-medical-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Emergency Travel Cert</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">For urgent travel</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>

            <!-- 5. Consular Assistance -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('services') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Consular Assistance</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">Support & guidance</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>

            <!-- 6. Trade & Investment -->
            <div class="col-lg-2 col-md-4 col-6">
                <a href="<?= Helper::baseUrl('trade') ?>" class="nhc-quick-card text-decoration-none text-center p-3 bg-white rounded-4 shadow-sm border d-flex flex-column align-items-center h-100 transition-all">
                    <div class="nhc-quick-icon-circle mb-2" style="width: 52px; height: 52px; background: rgba(0, 136, 82, 0.1); color: #008852; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1 small">Trade & Investment</h6>
                    <p class="text-muted extra-small mb-2 lh-sm" style="font-size: 0.75rem;">Invest, partner, grow</p>
                    <i class="bi bi-arrow-right text-emerald mt-auto fs-6"></i>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- SECTION 2: 3-COLUMN MIDDLE BLOCK (LATEST NOTICES | HIGH COMMISSIONER MESSAGE | NIGERIA-KENYA RELATIONS) -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container py-2">
        <div class="row g-4">
            
            <!-- Column 1: Latest Notices -->
            <div class="col-lg-4">
                <div class="card border rounded-4 shadow-sm h-100 overflow-hidden">
                    <div class="card-header bg-emerald-dark text-white p-3 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold m-0 fs-6 text-white" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-megaphone me-2 text-gold"></i>Latest Notices</h5>
                        <a href="<?= Helper::baseUrl('news') ?>" class="text-white small text-decoration-none fw-semibold">View All &rarr;</a>
                    </div>
                    <div class="card-body p-3 d-flex flex-column gap-3 bg-white">
                        <?php foreach (array_slice($notices, 0, 4) as $n): ?>
                            <div class="d-flex align-items-start gap-3 border-bottom pb-2">
                                <div class="date-badge text-center p-2 rounded-3 bg-light border flex-shrink-0" style="min-width: 60px;">
                                    <div class="fw-bold text-dark fs-5 lh-1"><?= Helper::formatDate($n['published_at'], 'd') ?></div>
                                    <div class="extra-small text-muted text-uppercase" style="font-size: 0.7rem;"><?= Helper::formatDate($n['published_at'], 'M Y') ?></div>
                                </div>
                                <div>
                                    <span class="badge bg-emerald-subtle text-emerald extra-small mb-1"><?= Helper::sanitize(ucwords(str_replace('_', ' ', $n['category']))) ?></span>
                                    <h6 class="fw-bold text-dark mb-1 small lh-sm"><?= Helper::sanitize($n['title']) ?></h6>
                                    <a href="<?= Helper::baseUrl('news/view?slug=' . $n['slug']) ?>" class="small text-emerald fw-semibold text-decoration-none" style="font-size: 0.8rem;">Read More &rarr;</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Column 2: Message from the High Commissioner -->
            <?php
                use App\Models\SystemSetting;
                $hcName = SystemSetting::get('high_commissioner_name', 'H.E. Amb. Danlami Ibrahim');
                $hcTitle = SystemSetting::get('high_commissioner_title', 'High Commissioner');
                $hcQuote = SystemSetting::get('high_commissioner_quote', '"The High Commission remains committed to strengthening the bonds between Nigeria and Kenya, while providing efficient consular services and promoting opportunities for our citizens and businesses."');
                $hcPhoto = SystemSetting::getAssetUrl('high_commissioner_photo');
                if (empty($hcPhoto)) {
                    $hcPhoto = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80';
                }
                $hcRoute = SystemSetting::get('high_commissioner_message_url', 'mission/message');
            ?>
            <div class="col-lg-5">
                <div class="card border rounded-4 shadow-sm h-100 p-4 bg-white">
                    <h5 class="fw-bold text-emerald-dark mb-3" style="font-family: 'Montserrat', sans-serif;">Message from the High Commissioner</h5>
                    
                    <div class="row align-items-center g-3 mb-3">
                        <div class="col-md-5 text-center">
                            <div class="rounded-4 overflow-hidden shadow-sm border border-emerald border-2">
                                <img src="<?= Helper::sanitize($hcPhoto) ?>" alt="<?= Helper::sanitize($hcName) ?>" class="img-fluid w-100" style="object-fit: cover; max-height: 220px;">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h6 class="fw-bold text-dark mb-1"><?= Helper::sanitize($hcName) ?></h6>
                            <div class="small text-emerald fw-semibold mb-2" style="font-size: 0.8rem;"><?= Helper::sanitize($hcTitle) ?></div>
                            <p class="text-muted small fst-italic lh-base mb-0" style="font-size: 0.85rem;">
                                <?= Helper::sanitize($hcQuote) ?>
                            </p>
                        </div>
                    </div>

                    <a href="<?= Helper::baseUrl($hcRoute) ?>" class="btn btn-emerald w-100 mt-auto fw-bold py-2.5">
                        Read Full Message &rarr;
                    </a>
                </div>
            </div>

            <!-- Column 3: Nigeria - Kenya Relations -->
            <div class="col-lg-3">
                <div class="card border rounded-4 shadow-sm h-100 overflow-hidden bg-white">
                    <div class="position-relative text-white p-3" style="background: linear-gradient(135deg, #004D2C 0%, #002B19 100%);">
                        <span class="badge bg-gold text-dark mb-1 extra-small fw-bold">BILATERAL PARTNERSHIP</span>
                        <h6 class="fw-bold text-white mb-1">Nigeria – Kenya Relations</h6>
                        <p class="extra-small opacity-90 m-0" style="font-size: 0.78rem;">Building stronger partnerships for a shared future.</p>
                        <a href="<?= Helper::baseUrl('mission') ?>" class="small text-gold fw-bold text-decoration-none mt-2 d-inline-block">Learn More &rarr;</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush small">
                            <a href="<?= Helper::baseUrl('mission') ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3">
                                <span><i class="bi bi-bank me-2 text-emerald"></i>Diplomatic Relations</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                            <a href="<?= Helper::baseUrl('trade') ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3">
                                <span><i class="bi bi-graph-up me-2 text-emerald"></i>Trade & Investment</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                            <a href="<?= Helper::baseUrl('discover-nigeria') ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3">
                                <span><i class="bi bi-mortarboard me-2 text-emerald"></i>Culture & Education</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                            <a href="<?= Helper::baseUrl('events') ?>" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3">
                                <span><i class="bi bi-people me-2 text-emerald"></i>High-Level Visits</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- SECTION 3: DISCOVER NIGERIA (4 DYNAMIC FEATURE CARDS) -->
<?php
$discoverCards = [
    1 => [
        'title' => SystemSetting::get('discover_card_1_title', 'Tourism'),
        'subtitle' => SystemSetting::get('discover_card_1_subtitle', 'Beaches, parks, landmarks'),
        'url' => SystemSetting::get('discover_card_1_url', 'discover-nigeria'),
        'image' => SystemSetting::getAssetUrl('discover_card_1_image'),
        'default_image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80',
    ],
    2 => [
        'title' => SystemSetting::get('discover_card_2_title', 'Culture'),
        'subtitle' => SystemSetting::get('discover_card_2_subtitle', 'Festivals, arts, heritage'),
        'url' => SystemSetting::get('discover_card_2_url', 'discover-nigeria'),
        'image' => SystemSetting::getAssetUrl('discover_card_2_image'),
        'default_image' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=600&q=80',
    ],
    3 => [
        'title' => SystemSetting::get('discover_card_3_title', 'Business'),
        'subtitle' => SystemSetting::get('discover_card_3_subtitle', 'Invest & grow'),
        'url' => SystemSetting::get('discover_card_3_url', 'trade'),
        'image' => SystemSetting::getAssetUrl('discover_card_3_image'),
        'default_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80',
    ],
    4 => [
        'title' => SystemSetting::get('discover_card_4_title', 'States of Nigeria'),
        'subtitle' => SystemSetting::get('discover_card_4_subtitle', '36 states, endless possibilities'),
        'url' => SystemSetting::get('discover_card_4_url', 'discover-nigeria/states'),
        'image' => SystemSetting::getAssetUrl('discover_card_4_image'),
        'default_image' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=600&q=80',
    ],
];
?>
<section class="py-5" style="background-color: var(--brand-pale);">
    <div class="container py-2">
        <div class="row align-items-end mb-4 g-3">
            <div class="col-md-8">
                <div style="width: 40px; height: 3px; background-color: #D4AF37;" class="mb-2"></div>
                <h2 class="fw-bold text-emerald-dark m-0" style="font-family: 'Montserrat', sans-serif; font-size: 1.6rem;">DISCOVER NIGERIA</h2>
                <p class="text-muted small m-0">Explore our rich culture, vibrant cities and endless opportunities.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= Helper::baseUrl('discover-nigeria') ?>" class="btn btn-emerald fw-bold px-4 py-2">
                    Explore Nigeria &rarr;
                </a>
            </div>
        </div>

        <div class="row g-3">
            <?php foreach ($discoverCards as $cIdx => $card): ?>
                <?php 
                    $cardImg = !empty($card['image']) ? $card['image'] : $card['default_image'];
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 nhc-discover-card position-relative">
                        <img src="<?= Helper::sanitize($cardImg) ?>" alt="<?= Helper::sanitize($card['title']) ?>" class="w-100" style="height: 200px; object-fit: cover;">
                        <div class="p-3 bg-emerald-dark text-white d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-bold m-0 text-white"><?= Helper::sanitize($card['title']) ?></h6>
                                <span class="extra-small opacity-85" style="font-size: 0.75rem;"><?= Helper::sanitize($card['subtitle']) ?></span>
                            </div>
                            <a href="<?= Helper::baseUrl($card['url']) ?>" class="text-gold" aria-label="Explore <?= Helper::sanitize($card['title']) ?>"><i class="bi bi-arrow-right fs-5"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- SECTION 4: 2-COLUMN ROW (EMERGENCY ASSISTANCE & NEWS / EVENTS GRID) -->
<section class="py-5 bg-white border-top">
    <div class="container py-2">
        <div class="row g-4">
            
            <!-- Left Column: Emergency Assistance Panel -->
            <div class="col-lg-4">
                <div class="card border border-danger border-opacity-25 rounded-4 shadow-sm p-4 h-100" style="background-color: rgba(220, 38, 38, 0.04);">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; font-weight: bold;">
                            !
                        </div>
                        <div>
                            <h5 class="fw-bold text-danger m-0" style="font-family: 'Montserrat', sans-serif;">EMERGENCY ASSISTANCE</h5>
                            <span class="extra-small text-muted" style="font-size: 0.78rem;">Need help? We are here for you.</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-3 bg-white border border-danger border-opacity-25 mb-3">
                        <div class="small fw-semibold text-secondary mb-1">24/7 Emergency Line:</div>
                        <a href="tel:+254722205911" class="fs-5 fw-bold text-danger text-decoration-none">+254 722 205 911</a>
                    </div>

                    <ul class="list-unstyled small text-secondary d-flex flex-column gap-2 mb-4">
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-shield-x text-danger"></i> Lost or stolen passport</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-person-x text-danger"></i> Arrest / detention assistance</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-activity text-danger"></i> Serious accident / medical emergency</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-heartbreak text-danger"></i> Death of a Nigerian citizen</li>
                        <li class="d-flex align-items-center gap-2"><i class="bi bi-file-earmark-medical text-danger"></i> Emergency Travel Certificate</li>
                    </ul>

                    <a href="<?= Helper::baseUrl('emergency') ?>" class="btn btn-danger w-100 mt-auto fw-bold py-2.5">
                        See Full Emergency Information &rarr;
                    </a>
                </div>
            </div>

            <!-- Right Column: News & Events Grid -->
            <div class="col-lg-8">
                <div class="card border rounded-4 shadow-sm h-100 overflow-hidden">
                    <div class="card-header bg-emerald-dark text-white p-3 d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold m-0 fs-6 text-white" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-calendar-event me-2 text-gold"></i>News & Events</h5>
                        <a href="<?= Helper::baseUrl('events') ?>" class="text-white small text-decoration-none fw-semibold">View All &rarr;</a>
                    </div>
                    <div class="card-body p-3 bg-white">
                        <div class="row g-3">
                            <?php 
                                $displayNotices = array_slice($notices, 0, 3);
                                foreach ($displayNotices as $n): 
                                    $img = !empty($n['featured_image']) ? (preg_match('#^https?://#i', $n['featured_image']) ? $n['featured_image'] : Helper::baseUrl($n['featured_image'])) : '';
                                    if (empty($img)) {
                                        $cat = strtolower($n['category'] ?? '');
                                        if (str_contains($cat, 'trade') || str_contains($cat, 'business')) {
                                            $img = 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=400&q=80';
                                        } elseif (str_contains($cat, 'cultural') || str_contains($cat, 'event') || str_contains($cat, 'holiday')) {
                                            $img = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=400&q=80';
                                        } else {
                                            $img = 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=400&q=80';
                                        }
                                    }
                            ?>
                                <div class="col-md-4">
                                    <div class="card border rounded-3 overflow-hidden h-100 shadow-xs">
                                        <div class="position-relative">
                                            <img src="<?= Helper::sanitize($img) ?>" alt="<?= Helper::sanitize($n['title']) ?>" class="w-100" style="height: 120px; object-fit: cover;">
                                            <span class="badge bg-gold text-dark position-absolute top-0 start-0 m-2 fw-bold" style="font-size: 0.7rem;"><?= Helper::formatDate($n['published_at'], 'd M Y') ?></span>
                                        </div>
                                        <div class="p-3 d-flex flex-column h-100">
                                            <span class="extra-small text-emerald fw-bold mb-1 text-uppercase" style="font-size: 0.72rem;"><?= Helper::sanitize(str_replace('_', ' ', $n['category'])) ?></span>
                                            <h6 class="fw-bold text-dark mb-1 small lh-sm"><?= Helper::sanitize($n['title']) ?></h6>
                                            <p class="extra-small text-muted mb-2 lh-sm flex-grow-1" style="font-size: 0.75rem;"><?= Helper::sanitize(substr(strip_tags($n['content']), 0, 75)) ?>...</p>
                                            <a href="<?= Helper::baseUrl('news/view?slug=' . $n['slug']) ?>" class="small text-emerald fw-semibold text-decoration-none mt-auto">Read More &rarr;</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
