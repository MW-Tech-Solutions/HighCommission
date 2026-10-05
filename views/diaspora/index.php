<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nigerians in Kenya</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">DIASPORA AFFAIRS & CITIZEN WELFARE</span></div>
        <h1 class="display-6 fw-bold">Nigerians in Kenya Diaspora Hub</h1>
        <p class="max-w-700 mx-auto">Connecting, serving, and safeguarding Nigerian citizens residing, studying, or conducting business in Kenya, Somalia, and Seychelles.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4 mb-5">
        <!-- Citizen Registration Card -->
        <div class="col-md-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Citizen Registry</span>
                </div>
                <h3 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Online Registration</h3>
                <p class="text-muted small flex-grow-1 lh-base">Official census registry for Nigerian residents in East Africa. Enables the High Commission to provide emergency consular assistance, residency verification, and welfare updates.</p>
                <a href="<?= Helper::baseUrl('nigerians-in-kenya/register') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Register Online <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Community Directory Card -->
        <div class="col-md-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-building-gear"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Associations</span>
                </div>
                <h3 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Community Directory</h3>
                <p class="text-muted small flex-grow-1 lh-base">Verified directory of Nigerian student unions, professional associations, cultural groups, and business networks operating across Kenya.</p>
                <a href="<?= Helper::baseUrl('nigerians-in-kenya/community') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Explore Directory <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Emergency Beacon Card -->
        <div class="col-md-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column border-danger bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1.5 small fw-semibold">24/7 Crisis Response</span>
                </div>
                <h3 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Distress Beacon</h3>
                <p class="text-muted small flex-grow-1 lh-base">Immediate distress alert system for Nigerian citizens facing urgent medical emergencies, legal distress, accidents, or consular crises in East Africa.</p>
                <a href="<?= Helper::baseUrl('emergency') ?>" class="btn btn-danger btn-sm mt-3 w-100">
                    Activate Distress Beacon <i class="bi bi-exclamation-triangle-fill ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
