<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('services') ?>">Consular Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Document Legalization</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">DIPLOMATIC ATTESTATION</span>
        <h1>Document Legalization & Attestation</h1>
        <p>High Commission of the Federal Republic of Nigeria, Nairobi — Legalization & Notary Desk.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-file-earmark-check-fill text-emerald me-2"></i>Personal & Academic Documents</h4>
                <ul class="text-secondary small ps-3">
                    <li class="mb-2">Birth Certificates & Marriage Certificates</li>
                    <li class="mb-2">University Degrees, Academic Transcripts, & Diplomas</li>
                    <li class="mb-2">Police Clearance Certificates</li>
                    <li class="mb-2">Sworn Affidavits & Power of Attorney</li>
                </ul>
                <div class="alert alert-light border small mt-auto mb-0">
                    <strong>Prerequisite:</strong> Must be authenticated by the Ministry of Foreign Affairs (MFA) in Nigeria or Kenya prior to High Commission attestation.
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-building-check text-emerald me-2"></i>Commercial & Corporate Documents</h4>
                <ul class="text-secondary small ps-3">
                    <li class="mb-2">Certificates of Incorporation (CAC / BRS Kenya)</li>
                    <li class="mb-2">Memorandum & Articles of Association</li>
                    <li class="mb-2">Commercial Invoices & Certificates of Origin</li>
                    <li class="mb-2">Corporate Powers of Attorney & Agency Contracts</li>
                </ul>
                <div class="alert alert-light border small mt-auto mb-0">
                    <strong>Prerequisite:</strong> Requires Chamber of Commerce stamp prior to diplomatic legalization.
                </div>
            </div>
        </div>
    </div>

    <div class="text-center bg-white p-5 rounded-4 shadow-sm border">
        <h4 class="fw-bold text-dark mb-2">Schedule Your Legalization Appointment</h4>
        <p class="text-muted small mb-4">Book a dedicated slot for document submission and authentication seal issuance.</p>
        <a href="<?= Helper::baseUrl('appointment') ?>" class="btn btn-emerald btn-lg px-4">
            <i class="bi bi-calendar-event me-2"></i>Book Legalization Appointment
        </a>
    </div>
</div>
