<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Consular Services</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">OFFICIAL SERVICE CATALOGUE</span></div>
        <h1 class="display-6 fw-bold">High Commission Consular Services</h1>
        <p class="max-w-700 mx-auto">Providing authoritative guidelines, application procedures, biometric appointment scheduling, and document attestation services for Nigerian citizens and foreign nationals in Kenya, Somalia, and Seychelles.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4">
        <!-- 1. Passport Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-passport"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Biometric Passport</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">E-Passport Renewal</h4>
                <p class="text-muted small flex-grow-1 lh-base">Step-by-step instructions for standard e-passport renewals, lost/damaged passport clearances, NIN verification, and biometric capture appointments in Kilimani, Nairobi.</p>
                <a href="<?= Helper::baseUrl('services/passport') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Access Passport Guide <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- 2. Visa Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-card-checklist"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Entry & Visas</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Visa Processing & Quiz</h4>
                <p class="text-muted small flex-grow-1 lh-base">Requirement matrices for all approved visa categories (Tourist, Business, STR, TWP), 3-question finder quiz, fee structure, and handoff to the official NIS portal.</p>
                <a href="<?= Helper::baseUrl('services/visa') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Explore Visa Requirements <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- 3. ETC Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column border-danger bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-file-earmark-medical"></i>
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1.5 small fw-semibold">Fast-Track 24h-48h</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Emergency Travel Cert (ETC)</h4>
                <p class="text-muted small flex-grow-1 lh-base">Issued to Nigerian citizens in Kenya who lost their passport or have expired documents and urgently need one-way emergency travel home to Nigeria. Online draft generator available.</p>
                <a href="<?= Helper::baseUrl('services/emergency-travel') ?>" class="btn btn-danger btn-sm mt-3 w-100">
                    Apply for ETC Draft <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- 4. Legalization Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-patch-check"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Legal Attestation</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Document Legalization</h4>
                <p class="text-muted small flex-grow-1 lh-base">Official diplomatic endorsement and attestation of educational certificates, corporate contracts, marriage certificates, and powers of attorney for official use in Nigeria or Kenya.</p>
                <a href="<?= Helper::baseUrl('services/document-support') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Legalization Guidelines <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- 5. Consular Fees Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Statutory Tariff</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Consular Fees Schedule</h4>
                <p class="text-muted small flex-grow-1 lh-base">Official published statutory fee schedules for passport clearances, document attestations, emergency certificates, and authentications processed via Remita and NIS online portals.</p>
                <a href="<?= Helper::baseUrl('services/fees') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    View Approved Fees <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- 6. Appointments & Biometrics Card -->
        <div class="col-md-6 col-lg-4">
            <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="nhc-service-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle rounded-pill px-3 py-1.5 small fw-semibold">Biometrics Capture</span>
                </div>
                <h4 class="fw-bold mb-2 text-dark" style="font-family: var(--font-heading);">Book Biometric Appointment</h4>
                <p class="text-muted small flex-grow-1 lh-base">Schedule an official biometric capture appointment slot or submit tracked consular enquiries to High Commission duty officers in Kilimani, Nairobi.</p>
                <a href="<?= Helper::baseUrl('services/appointments') ?>" class="btn btn-emerald btn-sm mt-3 w-100">
                    Book Appointment Slot <i class="bi bi-calendar-plus ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
