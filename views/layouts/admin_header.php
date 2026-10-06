<?php
use App\Core\Helper;
use App\Core\Auth;
use App\Models\SystemSetting;

$user = Auth::user();
$flash = Helper::getFlash();

$sidebarLogo = SystemSetting::getLogo('sidebar');
$shortName = SystemSetting::get('short_name', 'Nigeria High Commission');
$faviconUrl = SystemSetting::getFaviconUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Workspace | <?= Helper::sanitize(SystemSetting::get('app_name', 'Nigeria High Commission Nairobi')) ?></title>
    
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
<body class="bg-light">

<div class="d-flex flex-column flex-lg-row min-vh-100">
    <!-- Desktop Fixed / Sticky Sidebar (>= 992px) -->
    <aside class="admin-sidebar d-none d-lg-flex p-3 flex-column" style="width: 270px; min-width: 270px; position: sticky; top: 0; height: 100vh; overflow-y: auto; background-color: #004D2C; color: white;">
        <div class="d-flex align-items-center gap-3 mb-4 px-2 py-2 border-bottom border-light border-opacity-25 pb-3">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 42px; height: 42px; background: rgba(255, 255, 255, 0.1); border: 1.5px solid #D4AF37;">
                <?php if (file_exists(__DIR__ . '/../../public/assets/images/hero/cropped-coat-of-arms-of-nigeria-01-01-scaled-1-180x180.png')): ?>
                    <img src="<?= Helper::baseUrl('assets/images/hero/cropped-coat-of-arms-of-nigeria-01-01-scaled-1-180x180.png') ?>" alt="Nigeria Crest" style="width: 30px; height: 30px; object-fit: contain;">
                <?php else: ?>
                    <i class="bi bi-bank2 text-gold fs-5"></i>
                <?php endif; ?>
            </div>
            <div class="overflow-hidden">
                <h6 class="fw-bold mb-0 text-white text-truncate" style="font-family: 'Montserrat', sans-serif; font-size: 0.88rem; letter-spacing: 0.5px; text-transform: uppercase;">STAFF WORKSPACE</h6>
                <div class="small text-gold fw-bold text-truncate" style="font-size: 0.75rem; letter-spacing: 0.3px; text-transform: uppercase;"><?= Helper::sanitize($shortName) ?></div>
            </div>
        </div>

        <nav class="nav flex-column mb-auto gap-1">
            <div class="small text-uppercase text-white-50 px-2 fw-bold mb-1" style="font-size: 0.68rem; letter-spacing: 1px; font-family: 'Montserrat', sans-serif;">Core Workspace</div>
            <a class="nav-link text-white <?= ($_SERVER['REQUEST_URI'] == Helper::baseUrl('admin/dashboard')) ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/dashboard') ?>">
                <i class="bi bi-speedometer2 me-2 text-gold"></i>Dashboard
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'requests') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/requests') ?>">
                <i class="bi bi-inbox-fill me-2 text-gold"></i>Consular Cases
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'appointments') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/appointments') ?>">
                <i class="bi bi-calendar-check-fill me-2 text-gold"></i>Appointments
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'citizens') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/citizens') ?>">
                <i class="bi bi-people-fill me-2 text-gold"></i>Diaspora Registry
            </a>

            <div class="small text-uppercase text-white-50 px-2 fw-bold mt-3 mb-1" style="font-size: 0.68rem; letter-spacing: 1px; font-family: 'Montserrat', sans-serif;">CMS & Public Content</div>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'notices') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/notices') ?>">
                <i class="bi bi-newspaper me-2 text-gold"></i>News & Advisories
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'hero') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/hero') ?>">
                <i class="bi bi-images me-2 text-gold"></i>Hero Slideshow
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'verification') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/verification') ?>">
                <i class="bi bi-patch-check-fill me-2 text-gold"></i>Authenticator
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'trade') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/trade') ?>">
                <i class="bi bi-briefcase-fill me-2 text-gold"></i>Trade Enquiries
            </a>

            <div class="small text-uppercase text-white-50 px-2 fw-bold mt-3 mb-1" style="font-size: 0.68rem; letter-spacing: 1px; font-family: 'Montserrat', sans-serif;">Governance & System</div>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'reports') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/reports') ?>">
                <i class="bi bi-bar-chart-line-fill me-2 text-gold"></i>Reports & Workload
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/users') ?>">
                <i class="bi bi-person-gear me-2 text-gold"></i>User & Staff Roles
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'settings') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/settings') ?>">
                <i class="bi bi-gear-fill me-2 text-gold"></i>System Settings
            </a>
            <a class="nav-link text-white <?= strpos($_SERVER['REQUEST_URI'], 'audit') !== false ? 'active' : '' ?>" href="<?= Helper::baseUrl('admin/audit') ?>">
                <i class="bi bi-shield-lock-fill me-2 text-gold"></i>Audit Logs
            </a>
        </nav>

        <hr class="border-light opacity-25 my-3">

        <div class="px-2">
            <div class="small text-white-50 mb-1">Logged in as:</div>
            <div class="fw-bold text-white small mb-1"><?= Helper::sanitize($user['full_name'] ?? 'Staff User') ?></div>
            <span class="badge bg-gold text-dark mb-3 text-uppercase fw-bold"><?= Helper::sanitize(str_replace('_', ' ', $user['role'] ?? 'officer')) ?></span>
            <div class="d-grid gap-2">
                <a href="<?= Helper::baseUrl('/') ?>" target="_blank" class="btn btn-outline-light btn-sm rounded-2 text-start fw-bold">
                    <i class="bi bi-globe me-2"></i>Public Site
                </a>
                <a href="<?= Helper::baseUrl('portal/logout') ?>" class="btn btn-danger btn-sm rounded-2 text-start fw-bold">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                </a>
            </div>
        </div>
    </aside>

    <!-- Mobile Offcanvas Sidebar Drawer (< 992px) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="adminMobileSidebar" aria-labelledby="adminMobileSidebarLabel" style="background-color: #004D2C; color: white;">
        <div class="offcanvas-header border-bottom border-light border-opacity-25 py-3">
            <div class="d-flex align-items-center gap-2">
                <?php if ($sidebarLogo['has_image']): ?>
                    <img src="<?= $sidebarLogo['url'] ?>" alt="<?= Helper::sanitize($sidebarLogo['alt']) ?>" style="max-height: 36px;">
                <?php else: ?>
                    <div class="nhc-crest-badge" style="width: 36px; height: 36px;"><i class="bi bi-bank2 text-gold"></i></div>
                <?php endif; ?>
                <h5 class="offcanvas-title text-white fw-bold mb-0" id="adminMobileSidebarLabel" style="font-family: 'Montserrat', sans-serif;">Staff Workspace</h5>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-3">
            <nav class="nav flex-column mb-auto gap-1">
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/dashboard') ?>"><i class="bi bi-speedometer2 me-2 text-gold"></i>Dashboard</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/requests') ?>"><i class="bi bi-inbox-fill me-2 text-gold"></i>Consular Cases</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/appointments') ?>"><i class="bi bi-calendar-check-fill me-2 text-gold"></i>Appointments</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/citizens') ?>"><i class="bi bi-people-fill me-2 text-gold"></i>Diaspora Registry</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/notices') ?>"><i class="bi bi-newspaper me-2 text-gold"></i>News & Advisories</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/hero') ?>"><i class="bi bi-images me-2 text-gold"></i>Hero Slideshow</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/reports') ?>"><i class="bi bi-bar-chart-line-fill me-2 text-gold"></i>Reports & Analytics</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/users') ?>"><i class="bi bi-person-gear me-2 text-gold"></i>User & Staff Roles</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/settings') ?>"><i class="bi bi-gear-fill me-2 text-gold"></i>System Settings</a>
                <a class="nav-link text-white py-2 border-bottom border-light border-opacity-10 fw-semibold" href="<?= Helper::baseUrl('admin/audit') ?>"><i class="bi bi-shield-lock-fill me-2 text-gold"></i>Audit Logs</a>
            </nav>
            <div class="mt-4 pt-3 border-top border-light border-opacity-25">
                <a href="<?= Helper::baseUrl('/') ?>" target="_blank" class="btn btn-outline-light btn-sm w-100 mb-2 fw-bold"><i class="bi bi-globe me-2"></i>Public Site</a>
                <a href="<?= Helper::baseUrl('portal/logout') ?>" class="btn btn-danger btn-sm w-100 fw-bold"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a>
            </div>
        </div>
    </div>

    <!-- Main Content Layout Area -->
    <div class="flex-grow-1 d-flex flex-column min-w-0">
        <!-- Sticky Dashboard Header (Height ~68px) -->
        <header class="bg-white border-bottom border-emerald sticky-top shadow-sm py-2 px-3 px-lg-4 d-flex align-items-center justify-content-between" style="z-index: 1010; height: 68px;">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-emerald btn-sm d-lg-none py-1 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar" aria-label="Toggle navigation">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="fw-bold mb-0 text-emerald-dark" style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem;">
                        Staff Workspace Management
                    </h5>
                    <div class="small text-muted d-none d-sm-block">Official Mission Portal Admin Console</div>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= Helper::baseUrl('admin/requests') ?>" class="btn btn-outline-emerald btn-sm d-none d-md-inline-flex align-items-center gap-1">
                    <i class="bi bi-inbox"></i> Case Queues
                </a>

                <!-- User Dropdown Menu -->
                <div class="dropdown">
                    <button class="btn btn-light btn-sm border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-emerald text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                            <?= strtoupper(substr($user['full_name'] ?? 'S', 0, 1)) ?>
                        </div>
                        <span class="d-none d-md-inline fw-semibold small"><?= Helper::sanitize($user['full_name'] ?? 'Staff') ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold small"><?= Helper::sanitize($user['full_name'] ?? 'Staff User') ?></div>
                            <div class="small text-muted"><?= Helper::sanitize($user['email'] ?? '') ?></div>
                            <span class="badge bg-emerald text-white mt-1 text-uppercase" style="font-size: 0.65rem;"><?= Helper::sanitize($user['role'] ?? 'officer') ?></span>
                        </li>
                        <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('admin/settings') ?>"><i class="bi bi-gear me-2 text-emerald"></i>System Settings</a></li>
                        <li><a class="dropdown-item py-2" href="<?= Helper::baseUrl('/') ?>" target="_blank"><i class="bi bi-globe me-2 text-emerald"></i>Public Website</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-danger" href="<?= Helper::baseUrl('portal/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Page Body -->
        <main class="flex-grow-1 p-3 p-lg-4 min-w-0" style="min-width: 0; overflow-x: hidden;">
            <?php if ($flash): ?>
                <div class="alert alert-<?= Helper::sanitize($flash['type']) ?> alert-dismissible fade show shadow-sm rounded-3 border-0 mb-4" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?= Helper::sanitize($flash['message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
