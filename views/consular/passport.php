<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('services') ?>">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">E-Passport Guidance</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">NIGERIA IMMIGRATION SERVICE (NIS) & HIGH COMMISSION NAIROBI</span>
        <h1>E-Passport Renewal & Replacement Guidance</h1>
        <p>Information Owner: Consular & Immigration Section | Last Reviewed: October 2026</p>
    </div>
</div>

<div class="container pb-5">
    <!-- Official Advisory Callout -->
    <div class="alert alert-warning border-0 shadow-sm p-4 rounded-3 mb-5" style="background: var(--brand-warm); border-left: 5px solid var(--reference-accent) !important;">
        <h5 class="fw-bold text-dark mb-2"><i class="bi bi-shield-exclamation text-gold me-2"></i>Official Application & Payment Protocol</h5>
        <p class="mb-2 text-secondary small">
            Statutory passport applications MUST be initiated on the official Nigeria Immigration Service (NIS) portal (<a href="https://passport.immigration.gov.ng" target="_blank" rel="noopener" class="fw-bold text-dark">passport.immigration.gov.ng</a>). Payment for passport fees is processed strictly through the official NIS / Remita payment portal. 
        </p>
        <p class="mb-0 text-secondary small">
            <strong>Do NOT pay cash to any agent.</strong> The High Commission in Nairobi conducts physical biometric enrollment ONLY after verification of an official NIS application payment slip.
        </p>
    </div>

    <!-- 4 Numbered Steps -->
    <h3 class="fw-bold text-emerald-dark mb-4">4-Step Passport Renewal Process</h3>
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="p-3 bg-white border rounded-3 h-100">
                <span class="badge bg-emerald text-white mb-2">STEP 1 (EXTERNAL ONLINE)</span>
                <h6 class="fw-bold text-dark mb-1">Verify NIN & Apply Online</h6>
                <p class="text-muted small mb-0">Ensure your National Identification Number (NIN) matches your passport data. Fill application on NIS portal.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white border rounded-3 h-100">
                <span class="badge bg-emerald text-white mb-2">STEP 2 (EXTERNAL ONLINE)</span>
                <h6 class="fw-bold text-dark mb-1">Pay Statutory Fees</h6>
                <p class="text-muted small mb-0">Pay required statutory fees online via Remita on the NIS portal and print out official receipt slips.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white border rounded-3 h-100">
                <span class="badge bg-gold text-dark mb-2">STEP 3 (LOCAL MISSION)</span>
                <h6 class="fw-bold text-dark mb-1">Book Biometrics Slot</h6>
                <p class="text-muted small mb-0">Reserve your biometrics enrollment date & time slot at the Nairobi High Commission premises.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-white border rounded-3 h-100">
                <span class="badge bg-secondary text-white mb-2">STEP 4 (IN-PERSON)</span>
                <h6 class="fw-bold text-dark mb-1">Enrollment & Pickup</h6>
                <p class="text-muted small mb-0">Attend appointment in Kilimani, Nairobi for biometric capture. Estimated processing: 2 to 4 weeks.</p>
            </div>
        </div>
    </div>

    <!-- Two Scenario Tabs: Renewal vs Lost/Damaged Passport -->
    <div class="card shadow-sm border-0 rounded-4 mb-5">
        <div class="card-header bg-emerald-dark text-white p-3 rounded-top-4">
            <ul class="nav nav-tabs card-header-tabs border-0" id="passportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold" id="renewal-tab" data-bs-toggle="tab" data-bs-target="#renewal-tab-pane" type="button" role="tab" aria-controls="renewal-tab-pane" aria-selected="true">
                        <i class="bi bi-arrow-repeat me-1"></i>Scenario A: Standard Passport Renewal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold" id="lost-tab" data-bs-toggle="tab" data-bs-target="#lost-tab-pane" type="button" role="tab" aria-controls="lost-tab-pane" aria-selected="false">
                        <i class="bi bi-exclamation-octagon me-1"></i>Scenario B: Lost or Damaged Passport
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="tab-content" id="passportTabsContent">
                
                <!-- SCENARIO A: RENEWAL -->
                <div class="tab-pane fade show active" id="renewal-tab-pane" role="tabpanel" aria-labelledby="renewal-tab" tabindex="0">
                    <h4 class="fw-bold text-emerald-dark mb-3">Requirements Checklist for Passport Renewal</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div>
                                <strong>Valid National Identification Number (NIN) Slip</strong>
                                <div class="text-muted small">Name, DOB, and gender on NIN MUST match existing passport data exactly.</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div>
                                <strong>Official NIS Application Form & Acknowledgement Slip</strong>
                                <div class="text-muted small">Printed directly from <a href="https://passport.immigration.gov.ng" target="_blank" rel="noopener">passport.immigration.gov.ng</a>.</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div>
                                <strong>Official Remita Payment Receipt</strong>
                                <div class="text-muted small">Confirming statutory NIS passport fee payment.</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div>
                                <strong>Original Existing Passport Booklet + Photocopies</strong>
                                <div class="text-muted small">Photocopy of data page and valid Kenya visa/permit page.</div>
                            </div>
                        </li>
                    </ul>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= Helper::baseUrl('services/appointments') ?>" class="btn btn-emerald btn-lg">
                            <i class="bi bi-calendar-event me-2"></i>Book Mission Biometrics Appointment
                        </a>
                        <a href="https://passport.immigration.gov.ng" target="_blank" rel="noopener" class="btn btn-outline-emerald btn-lg">
                            Continue to NIS Official Portal <i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                    </div>
                </div>

                <!-- SCENARIO B: LOST OR DAMAGED PASSPORT -->
                <div class="tab-pane fade" id="lost-tab-pane" role="tabpanel" aria-labelledby="lost-tab" tabindex="0">
                    <h4 class="fw-bold text-danger mb-3">Requirements Checklist for Lost / Damaged Passport</h4>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
                            <div>
                                <strong>Kenya Police Abstract Report</strong>
                                <div class="text-muted small">Issued by Kenya Police Service detailing loss date & circumstances.</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
                            <div>
                                <strong>Sworn Affidavit of Loss</strong>
                                <div class="text-muted small">Duly sworn before a Commissioner for Oaths or Magistrate Court.</div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-start gap-3 py-3">
                            <i class="bi bi-shield-exclamation text-danger fs-5"></i>
                            <div>
                                <strong>Photocopy of Lost Passport / Birth Certificate</strong>
                                <div class="text-muted small">Proves citizenship identity details.</div>
                            </div>
                        </li>
                    </ul>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= Helper::baseUrl('contact') ?>" class="btn btn-emerald btn-lg">
                            <i class="bi bi-envelope-fill me-2"></i>Send Enquiry to Consular Desk
                        </a>
                        <a href="<?= Helper::baseUrl('services/appointments') ?>" class="btn btn-accent btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Book Interview & Biometrics Slot
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
