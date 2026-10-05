<?php
use App\Core\Helper;
use App\Models\SystemSetting;

$mainLogo = SystemSetting::getLogo('main');
$footerLogo = SystemSetting::getLogo('footer');
$authLogo = SystemSetting::getLogo('auth');
$sidebarLogo = SystemSetting::getLogo('sidebar');
$darkLogo = SystemSetting::getLogo('dark_bg');
$lightLogo = SystemSetting::getLogo('light_bg');
$faviconUrl = SystemSetting::getFaviconUrl();
?>
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div>
        <h2 class="h3 fw-bold text-heading mb-1" style="font-family: 'Montserrat', sans-serif;">Institutional Branding & System Settings</h2>
        <p class="text-muted mb-0">Manage Mission identity, dynamic logo assets, favicon, exact typography, Chancery contacts, and domain settings.</p>
    </div>
    <div>
        <a href="<?= Helper::baseUrl('/') ?>" target="_blank" class="btn btn-outline-success btn-sm fw-bold">
            <i class="bi bi-box-arrow-up-right me-1"></i> Preview Public Site
        </a>
    </div>
</div>

<form action="<?= Helper::baseUrl('admin/settings') ?>" method="POST" enctype="multipart/form-data">
    <?= Helper::csrfField() ?>

    <ul class="nav nav-pills mb-4 gap-2 bg-white p-2 rounded-3 shadow-sm border" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold py-2 px-3" id="identity-tab" data-bs-toggle="pill" data-bs-target="#identity-panel" type="button" role="tab">
                <i class="bi bi-building me-2"></i>Mission Identity
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 px-3" id="logos-tab" data-bs-toggle="pill" data-bs-target="#logos-panel" type="button" role="tab">
                <i class="bi bi-image me-2"></i>Logos & Favicon
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 px-3" id="typography-tab" data-bs-toggle="pill" data-bs-target="#typography-panel" type="button" role="tab">
                <i class="bi bi-fonts me-2"></i>Typography & Colors
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 px-3" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact-panel" type="button" role="tab">
                <i class="bi bi-telephone me-2"></i>Contacts & Social
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 px-3" id="hc-tab" data-bs-toggle="pill" data-bs-target="#hc-panel" type="button" role="tab">
                <i class="bi bi-person-badge me-2"></i>High Commissioner & Welcome Message
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold py-2 px-3" id="discover-tab" data-bs-toggle="pill" data-bs-target="#discover-panel" type="button" role="tab">
                <i class="bi bi-compass me-2"></i>Discover Nigeria Cards
            </button>
        </li>
    </ul>

    <div class="tab-content" id="settingsTabContent">
        <!-- TAB 1: MISSION IDENTITY -->
        <div class="tab-pane fade show active" id="identity-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-globe me-2"></i>Domain & Diplomatic Mission Identity
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mission Full Title</label>
                            <input type="text" name="settings[mission_name]" class="form-control" value="<?= Helper::sanitize($settings['mission_name'] ?? 'High Commission of the Federal Republic of Nigeria') ?>" required>
                            <div class="form-text">Used on official headers, document templates, and receipt verification.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Short Display Name</label>
                            <input type="text" name="settings[short_name]" class="form-control" value="<?= Helper::sanitize($settings['short_name'] ?? 'Nigeria High Commission') ?>" required>
                            <div class="form-text">Used in mobile headers and dashboard sidebar collapsed states.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Site / Application Name</label>
                            <input type="text" name="settings[app_name]" class="form-control" value="<?= Helper::sanitize($settings['app_name'] ?? 'Nigeria High Commission Nairobi') ?>" required>
                            <div class="form-text">Appears in browser title bar and metadata tags.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Approved Mission Tagline</label>
                            <input type="text" name="settings[app_tagline]" class="form-control" value="<?= Helper::sanitize($settings['app_tagline'] ?? 'Nairobi, Republic of Kenya') ?>" required>
                            <div class="form-text">Subtitle shown below header title.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Canonical Domain URL</label>
                            <input type="url" name="settings[canonical_domain]" class="form-control" value="<?= Helper::sanitize($settings['canonical_domain'] ?? 'https://nigeriankenya.or.ke') ?>" required>
                            <div class="form-text">Must use standard HTTPS format for production.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Copyright & Footer Wording</label>
                            <input type="text" name="settings[copyright_text]" class="form-control" value="<?= Helper::sanitize($settings['copyright_text'] ?? '© 2026 High Commission of the Federal Republic of Nigeria, Nairobi, Kenya. All Rights Reserved.') ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: LOGOS & FAVICON -->
        <div class="tab-pane fade" id="logos-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-images me-2"></i>Dynamic Branding Assets & Favicon Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Logo Alt Text -->
                        <div class="col-12">
                            <label class="form-label fw-bold">Logo Alternative Text (WCAG AA Compliance)</label>
                            <input type="text" name="settings[logo_alt_text]" class="form-control" value="<?= Helper::sanitize($settings['logo_alt_text'] ?? 'Coat of Arms of the Federal Republic of Nigeria') ?>" required>
                        </div>

                        <!-- 1. Main Emblem / Logo -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-shield-fill me-1 text-success"></i> Main Mission Emblem / Logo</h6>
                                <p class="small text-muted mb-3">Primary official logo. Inherited by all placements if an override is not provided.</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Main Logo (PNG, JPG, WEBP, SVG)</label>
                                    <input type="file" name="logo_main" class="form-control form-control-sm" accept="image/*,.svg">
                                </div>

                                <!-- Previews -->
                                <div class="row g-2 mt-2">
                                    <div class="col-6">
                                        <div class="p-2 border rounded bg-white text-center">
                                            <div class="small text-muted mb-1">Light Surface</div>
                                            <?php if ($mainLogo['has_image']): ?>
                                                <img src="<?= $mainLogo['url'] ?>" alt="<?= Helper::sanitize($mainLogo['alt']) ?>" style="max-height: 48px; max-width: 100%; object-fit: contain;">
                                            <?php else: ?>
                                                <div class="nhc-crest-badge mx-auto"><i class="bi bi-bank2"></i></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-2 border rounded text-center" style="background-color: #0C1406; color: white;">
                                            <div class="small text-white-50 mb-1">Dark Surface</div>
                                            <?php if ($mainLogo['has_image']): ?>
                                                <img src="<?= $mainLogo['url'] ?>" alt="<?= Helper::sanitize($mainLogo['alt']) ?>" style="max-height: 48px; max-width: 100%; object-fit: contain;">
                                            <?php else: ?>
                                                <div class="nhc-crest-badge mx-auto"><i class="bi bi-bank2"></i></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if (!empty($settings['logo_main'])): ?>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[logo_main]" value="1" id="del_logo_main">
                                        <label class="form-check-label text-danger small fw-bold" for="del_logo_main">
                                            Remove custom main logo override (revert to default badge)
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 2. Favicon & Browser Icon -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-app-indicator me-1 text-success"></i> Favicon & Browser Icon</h6>
                                <p class="small text-muted mb-3">Browser tab icon, mobile web app shortcut icon, and bookmark icon.</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Favicon (.ico, .png, .svg)</label>
                                    <input type="file" name="favicon_url" class="form-control form-control-sm" accept=".ico,.png,.svg,image/*">
                                </div>

                                <div class="p-3 border rounded bg-white d-flex align-items-center gap-3 mt-2">
                                    <?php if (!empty($faviconUrl)): ?>
                                        <img src="<?= $faviconUrl ?>" alt="Favicon Preview" style="width: 32px; height: 32px; object-fit: contain;" class="border p-1 rounded">
                                    <?php else: ?>
                                        <div class="badge bg-secondary p-2"><i class="bi bi-globe fs-5"></i></div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="fw-bold small">Live Favicon Preview</div>
                                        <div class="small text-muted">Auto versioned with cache buster query</div>
                                    </div>
                                </div>

                                <?php if (!empty($settings['favicon_url'])): ?>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[favicon_url]" value="1" id="del_favicon">
                                        <label class="form-check-label text-danger small fw-bold" for="del_favicon">
                                            Remove custom favicon override
                                        </label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 3. Sidebar / Dashboard Logo -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-layout-sidebar-inset me-1 text-success"></i> Dashboard & Sidebar Logo</h6>
                                <p class="small text-muted mb-3">Used inside Citizen & Staff Dashboard fixed sidebars.</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Sidebar Logo (Optional Override)</label>
                                    <input type="file" name="logo_sidebar" class="form-control form-control-sm" accept="image/*,.svg">
                                </div>

                                <div class="p-3 border rounded text-center" style="background-color: #004D2C; color: white;">
                                    <div class="small text-white-50 mb-1">Sidebar Surface Preview</div>
                                    <?php if ($sidebarLogo['has_image']): ?>
                                        <img src="<?= $sidebarLogo['url'] ?>" alt="<?= Helper::sanitize($sidebarLogo['alt']) ?>" style="max-height: 40px; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="nhc-crest-badge mx-auto"><i class="bi bi-bank2"></i></div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($settings['logo_sidebar'])): ?>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[logo_sidebar]" value="1" id="del_sidebar">
                                        <label class="form-check-label text-danger small fw-bold" for="del_sidebar">Remove sidebar override</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 4. Footer Logo Override -->
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-segmented-nav me-1 text-success"></i> Public Footer Logo</h6>
                                <p class="small text-muted mb-3">Rendered on the deep dark footer surface.</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Footer Logo (Optional Override)</label>
                                    <input type="file" name="logo_footer" class="form-control form-control-sm" accept="image/*,.svg">
                                </div>

                                <div class="p-3 border rounded text-center" style="background-color: #0C1406; color: white;">
                                    <div class="small text-white-50 mb-1">Footer Dark Surface Preview</div>
                                    <?php if ($footerLogo['has_image']): ?>
                                        <img src="<?= $footerLogo['url'] ?>" alt="<?= Helper::sanitize($footerLogo['alt']) ?>" style="max-height: 40px; max-width: 100%; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="nhc-crest-badge mx-auto"><i class="bi bi-bank2"></i></div>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($settings['logo_footer'])): ?>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[logo_footer]" value="1" id="del_footer">
                                        <label class="form-check-label text-danger small fw-bold" for="del_footer">Remove footer override</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 3: TYPOGRAPHY & COLORS -->
        <div class="tab-pane fade" id="typography-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-fonts me-2"></i>Typography Configuration & Approved Brand Colors
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Headings Font Family</label>
                            <select name="settings[font_heading]" class="form-select">
                                <option value="Montserrat" <?= ($settings['font_heading'] ?? 'Montserrat') === 'Montserrat' ? 'selected' : '' ?>>Montserrat (Bold 700 - Assigned Standard)</option>
                                <option value="Playfair Display" <?= ($settings['font_heading'] ?? '') === 'Playfair Display' ? 'selected' : '' ?>>Playfair Display (Diplomatic Serif)</option>
                                <option value="Inter" <?= ($settings['font_heading'] ?? '') === 'Inter' ? 'selected' : '' ?>>Inter (Modern Sans)</option>
                            </select>
                            <div class="form-text">Applied to h1–h6, page titles, card headers & sidebar group headings.</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Body Text Font Family</label>
                            <select name="settings[font_body]" class="form-select">
                                <option value="Open Sans" <?= ($settings['font_body'] ?? 'Open Sans') === 'Open Sans' ? 'selected' : '' ?>>Open Sans (Regular 400/600 - Assigned Standard)</option>
                                <option value="Inter" <?= ($settings['font_body'] ?? '') === 'Inter' ? 'selected' : '' ?>>Inter</option>
                                <option value="Roboto" <?= ($settings['font_body'] ?? '') === 'Roboto' ? 'selected' : '' ?>>Roboto</option>
                            </select>
                            <div class="form-text">Applied to paragraphs, labels, form fields, tables & nav text.</div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Buttons & CTAs Font Family</label>
                            <select name="settings[font_button]" class="form-select">
                                <option value="Poppins" <?= ($settings['font_button'] ?? 'Poppins') === 'Poppins' ? 'selected' : '' ?>>Poppins (SemiBold 600 - Assigned Standard)</option>
                                <option value="Montserrat" <?= ($settings['font_button'] ?? '') === 'Montserrat' ? 'selected' : '' ?>>Montserrat</option>
                                <option value="Inter" <?= ($settings['font_button'] ?? '') === 'Inter' ? 'selected' : '' ?>>Inter</option>
                            </select>
                            <div class="form-text">Applied to all .btn controls, submit buttons & action triggers.</div>
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Primary Brand Green Token</label>
                            <input type="color" name="settings[branding_primary_color]" class="form-control form-control-color w-100" value="<?= Helper::sanitize($settings['branding_primary_color'] ?? '#008852') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Dark Contrast Surface Token</label>
                            <input type="color" name="settings[branding_dark_color]" class="form-control form-control-color w-100" value="<?= Helper::sanitize($settings['branding_dark_color'] ?? '#0C1406') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Leaf Accent Token</label>
                            <input type="color" name="settings[branding_leaf_color]" class="form-control form-control-color w-100" value="<?= Helper::sanitize($settings['branding_leaf_color'] ?? '#54B435') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Warm Accent Token</label>
                            <input type="color" name="settings[branding_accent_color]" class="form-control form-control-color w-100" value="<?= Helper::sanitize($settings['branding_accent_color'] ?? '#D5862C') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 4: CONTACTS & SOCIAL -->
        <div class="tab-pane fade" id="contact-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-telephone me-2"></i>Chancery Contacts, Office Hours & Social Links
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Chancery Physical Address</label>
                            <input type="text" name="settings[chancery_address]" class="form-control" value="<?= Helper::sanitize($settings['chancery_address'] ?? 'Lenana Road, Kilimani, P.O. Box 30294-00100, Nairobi, Kenya') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">General Switchboard Phone</label>
                            <input type="text" name="settings[chancery_phone]" class="form-control" value="<?= Helper::sanitize($settings['chancery_phone'] ?? '+254 20 2713412') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">24/7 Emergency Distress Hotline</label>
                            <input type="text" name="settings[emergency_hotline]" class="form-control fw-bold text-danger" value="<?= Helper::sanitize($settings['emergency_hotline'] ?? '+254 795 770 247') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Official Public Email</label>
                            <input type="email" name="settings[chancery_email]" class="form-control" value="<?= Helper::sanitize($settings['chancery_email'] ?? 'info@nigeriankenya.or.ke') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Office Hours Summary</label>
                            <input type="text" name="settings[office_hours_summary]" class="form-control" value="<?= Helper::sanitize($settings['office_hours_summary'] ?? 'Monday – Friday: 8:30 AM – 4:30 PM (Consular Intake: 9:00 AM – 1:00 PM)') ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Twitter / X Handle URL</label>
                            <input type="url" name="settings[social_twitter]" class="form-control" value="<?= Helper::sanitize($settings['social_twitter'] ?? 'https://x.com/nigeriankenya') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Facebook Page URL</label>
                            <input type="url" name="settings[social_facebook]" class="form-control" value="<?= Helper::sanitize($settings['social_facebook'] ?? 'https://facebook.com/nigeriankenya') ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Instagram Profile URL</label>
                            <input type="url" name="settings[social_instagram]" class="form-control" value="<?= Helper::sanitize($settings['social_instagram'] ?? 'https://instagram.com/nigeriankenya') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- TAB 5: HIGH COMMISSIONER & WELCOME MESSAGE -->
        <div class="tab-pane fade" id="hc-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-person-badge me-2"></i>High Commissioner Profile & Dynamic Welcome Message
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">High Commissioner Full Name & Title</label>
                            <input type="text" name="settings[high_commissioner_name]" class="form-control" value="<?= Helper::sanitize($settings['high_commissioner_name'] ?? 'H.E. Amb. Danlami Ibrahim') ?>" required>
                            <div class="form-text">e.g. H.E. Amb. Danlami Ibrahim</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Official Rank / Designation</label>
                            <input type="text" name="settings[high_commissioner_title]" class="form-control" value="<?= Helper::sanitize($settings['high_commissioner_title'] ?? 'High Commissioner') ?>" required>
                            <div class="form-text">e.g. High Commissioner / Ambassador Extraordinary</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Dynamic Welcome Quote / Statement</label>
                            <textarea name="settings[high_commissioner_quote]" class="form-control" rows="3" required><?= Helper::sanitize($settings['high_commissioner_quote'] ?? '"The High Commission remains committed to strengthening the bonds between Nigeria and Kenya, while providing efficient consular services and promoting opportunities for our citizens and businesses."') ?></textarea>
                            <div class="form-text">Displayed on the homepage middle section and diplomatic welcome card.</div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <h6 class="fw-bold text-dark mb-2"><i class="bi bi-person-bounding-box me-1 text-success"></i> Official Portrait Photo</h6>
                                <p class="small text-muted mb-3">High Commissioner official portrait image (JPG, PNG, WEBP).</p>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Portrait Photo</label>
                                    <input type="file" name="high_commissioner_photo" class="form-control form-control-sm" accept="image/*">
                                </div>

                                <div class="p-3 border rounded bg-white text-center mt-2">
                                    <div class="small text-muted mb-2">Live Portrait Preview</div>
                                    <?php 
                                        $hcPhotoUrl = SystemSetting::getAssetUrl('high_commissioner_photo');
                                        if (empty($hcPhotoUrl)) {
                                            $hcPhotoUrl = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80';
                                        }
                                    ?>
                                    <img src="<?= $hcPhotoUrl ?>" alt="High Commissioner Preview" style="max-height: 140px; border-radius: 12px; object-fit: cover;" class="border shadow-sm">
                                </div>

                                <?php if (!empty($settings['high_commissioner_photo'])): ?>
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[high_commissioner_photo]" value="1" id="del_hc_photo">
                                        <label class="form-check-label text-danger small fw-bold" for="del_hc_photo">Remove custom portrait photo override</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-link-45deg me-1 text-success"></i> Read Full Message Handoff Page</h6>
                                    <label class="form-label small fw-bold">Read Full Message Button Route / URL</label>
                                    <input type="text" name="settings[high_commissioner_message_url]" class="form-control form-control-sm mb-2" value="<?= Helper::sanitize($settings['high_commissioner_message_url'] ?? 'mission/message') ?>" required>
                                    <div class="form-text">Destination page when users click "Read Full Message &rarr;". Default: <code>mission/message</code></div>
                                </div>

                                <div class="alert alert-success border-0 small m-0 mt-3">
                                    <i class="bi bi-check-circle-fill me-1"></i> Changes saved here update the homepage welcome card and the diplomatic address page automatically!
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 6: DISCOVER NIGERIA CARDS -->
        <div class="tab-pane fade" id="discover-panel" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title fw-bold mb-0 text-success" style="font-family: 'Montserrat', sans-serif;">
                        <i class="bi bi-compass me-2"></i>Homepage Discover Nigeria (4 Feature Cards)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-4">Customize the title, subtitle, destination link, and photo image for each of the 4 Discover Nigeria cards displayed on the public homepage.</p>
                    
                    <div class="row g-4">
                        <?php
                        $defaults = [
                            1 => ['title' => 'Tourism', 'sub' => 'Beaches, parks, landmarks', 'url' => 'discover-nigeria', 'img' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=600&q=80'],
                            2 => ['title' => 'Culture', 'sub' => 'Festivals, arts, heritage', 'url' => 'discover-nigeria', 'img' => 'https://images.unsplash.com/photo-1533105079780-92b9be482077?auto=format&fit=crop&w=600&q=80'],
                            3 => ['title' => 'Business', 'sub' => 'Invest & grow', 'url' => 'trade', 'img' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80'],
                            4 => ['title' => 'States of Nigeria', 'sub' => '36 states, endless possibilities', 'url' => 'discover-nigeria/states', 'img' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?auto=format&fit=crop&w=600&q=80']
                        ];
                        for ($i = 1; $i <= 4; $i++):
                            $cTitleKey = "discover_card_{$i}_title";
                            $cSubKey = "discover_card_{$i}_subtitle";
                            $cUrlKey = "discover_card_{$i}_url";
                            $cImgKey = "discover_card_{$i}_image";

                            $titleVal = $settings[$cTitleKey] ?? $defaults[$i]['title'];
                            $subVal = $settings[$cSubKey] ?? $defaults[$i]['sub'];
                            $urlVal = $settings[$cUrlKey] ?? $defaults[$i]['url'];
                            
                            $customImgUrl = SystemSetting::getAssetUrl($cImgKey);
                            $previewImg = !empty($customImgUrl) ? $customImgUrl : $defaults[$i]['img'];
                        ?>
                        <div class="col-md-6">
                            <div class="border rounded-3 p-3 bg-light h-100">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                    <h6 class="fw-bold text-dark m-0"><i class="bi bi-card-heading me-1 text-success"></i> Card #<?= $i ?>: <?= Helper::sanitize($titleVal) ?></h6>
                                    <span class="badge bg-success bg-opacity-10 text-success fw-bold">Slot <?= $i ?></span>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Card Title</label>
                                    <input type="text" name="settings[<?= $cTitleKey ?>]" class="form-control form-control-sm" value="<?= Helper::sanitize($titleVal) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Card Subtitle / Description</label>
                                    <input type="text" name="settings[<?= $cSubKey ?>]" class="form-control form-control-sm" value="<?= Helper::sanitize($subVal) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Target Route / Link</label>
                                    <input type="text" name="settings[<?= $cUrlKey ?>]" class="form-control form-control-sm" value="<?= Helper::sanitize($urlVal) ?>" required>
                                    <div class="form-text extra-small">e.g. <code>discover-nigeria</code>, <code>trade</code>, or <code>discover-nigeria/states</code></div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Upload Custom Photo Asset</label>
                                    <input type="file" name="<?= $cImgKey ?>" class="form-control form-control-sm" accept="image/*">
                                </div>

                                <div class="p-2 border rounded bg-white text-center">
                                    <div class="extra-small text-muted mb-1">Live Card Image Preview</div>
                                    <img src="<?= Helper::sanitize($previewImg) ?>" alt="Card Preview" style="height: 110px; width: 100%; object-fit: cover; border-radius: 8px;">
                                </div>

                                <?php if (!empty($settings[$cImgKey])): ?>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="delete_logo[<?= $cImgKey ?>]" value="1" id="del_card_<?= $i ?>">
                                        <label class="form-check-label text-danger extra-small fw-bold" for="del_card_<?= $i ?>">Remove custom uploaded photo override</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-emerald px-5 py-2 fs-6 fw-bold shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i> Save System Configuration & Branding
        </button>
    </div>
</form>
