<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('services') ?>">Consular Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Visa Requirements</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">FOREIGN VISITORS & BUSINESS TRAVEL</span>
        <h1>Visa Categories & Entry Requirements</h1>
        <p>High Commission of the Federal Republic of Nigeria, Nairobi — Visa & Immigration Desk.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Interactive Visa Category Quiz -->
    <div class="card shadow-sm border-0 rounded-4 mb-5" style="background: linear-gradient(135deg, #004D2C 0%, #002B19 100%); color: white;">
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-5">
                    <span class="badge bg-gold text-dark mb-2">INTERACTIVE ASSISTANT</span>
                    <h3 class="fw-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">Which Visa Category Do You Need?</h3>
                    <p class="text-light opacity-90 small mb-0">Select your travel purpose and details below to instantly view recommended requirements and processing rules.</p>
                </div>
                <div class="col-lg-7">
                    <form id="visa-quiz-form" data-visa-url="https://visa.immigration.gov.ng" class="bg-white text-dark p-4 rounded-3 shadow">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">1. Purpose of Visit</label>
                                <select id="quiz-purpose" class="form-select" required>
                                    <option value="tourism">Holiday / Visiting Relatives</option>
                                    <option value="business">Business / Meetings / Trade</option>
                                    <option value="employment">Long-term Employment (Expatriate)</option>
                                    <option value="temporary_work">Short Technical Assignment (TWP)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">2. Nationality / Passport Holder</label>
                                <select id="quiz-nationality" class="form-select" required>
                                    <option value="kenya">Kenyan Passport Holder</option>
                                    <option value="eac">East African Community (EAC)</option>
                                    <option value="other">Foreign National Resident in Kenya</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">3. Intended Stay Duration</label>
                                <select id="quiz-duration" class="form-select" required>
                                    <option value="short">Short Stay (Up to 90 Days)</option>
                                    <option value="long">Long Stay / Permanent Expatriate</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-emerald w-100 mt-3 fw-bold">
                            <i class="bi bi-magic me-1"></i>Check Recommended Category
                        </button>
                    </form>
                    <div id="visa-quiz-result" class="d-none"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approved Visa Category Accordion -->
    <h3 class="fw-bold text-emerald-dark mb-4" style="font-family: 'Playfair Display', serif;">Approved Visa Categories & Requirement Matrix</h3>

    <div class="accordion shadow-sm rounded-4 overflow-hidden mb-5" id="visaAccordion">
        
        <!-- Category 1: Tourist Visa -->
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button fw-bold text-emerald-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="bi bi-camera-fill me-2 text-emerald"></i>1. Short Visit / Tourist Visa (F5A)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#visaAccordion">
                <div class="accordion-body p-4">
                    <p class="text-muted">Issued to foreign nationals who wish to visit Nigeria for tourism, vacation, or visiting friends/family.</p>
                    <h6 class="fw-bold text-dark mb-2">Required Documents:</h6>
                    <ul class="small text-secondary mb-3">
                        <li>Valid Passport with at least 6 months validity and minimum 2 blank pages.</li>
                        <li>Completed online Visa Application Form from NIS portal.</li>
                        <li>Official NIS Visa Payment Receipt & Acknowledgement Slip.</li>
                        <li>Two (2) recent passport-sized photographs (white background).</li>
                        <li>Formal Letter of Invitation from host in Nigeria (with host passport photocopy) OR confirmed hotel booking.</li>
                        <li>Return Flight Itinerary ticket.</li>
                        <li>Bank Statement showing sufficient funds for the duration of stay.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Category 2: Business Visa -->
        <div class="accordion-item border-0 border-top">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed fw-bold text-emerald-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="bi bi-briefcase-fill me-2 text-emerald"></i>2. Business Visa (F4A / F4B)
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#visaAccordion">
                <div class="accordion-body p-4">
                    <p class="text-muted">For corporate executives, investors, and trade delegates attending business meetings, conferences, or contract negotiations in Nigeria.</p>
                    <h6 class="fw-bold text-dark mb-2">Required Documents:</h6>
                    <ul class="small text-secondary mb-3">
                        <li>Formal Letter of Invitation on Nigerian Host Company's official letterhead (accepting full immigration responsibility).</li>
                        <li>Certificate of Incorporation of the host Nigerian company (CAC).</li>
                        <li>Formal Letter of Introduction from the applicant's Kenyan employer/organization.</li>
                        <li>Confirmed Hotel Reservation or Host Accommodation details.</li>
                        <li>Return Flight Ticket.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Category 3: STR -->
        <div class="accordion-item border-0 border-top">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed fw-bold text-emerald-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="bi bi-building-fill-gear me-2 text-emerald"></i>3. Subject to Regularization (STR) Visa
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#visaAccordion">
                <div class="accordion-body p-4">
                    <p class="text-muted">Issued to foreign expatriates taking up long-term employment in Nigeria under approved Expatriate Quotas.</p>
                    <h6 class="fw-bold text-dark mb-2">Required Documents:</h6>
                    <ul class="small text-secondary mb-3">
                        <li>Formal Letter of Appointment and Acceptance of Offer of Employment.</li>
                        <li>Copy of Comptroller General of Immigration Expatriate Quota Approval.</li>
                        <li>Four (4) sets of Credentials, CV, and Certificates duly attested.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Official Handoff CTA -->
    <div class="card bg-emerald-dark text-white border-0 rounded-4 p-4 text-center">
        <h4 class="fw-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">Ready to Submit Your Application?</h4>
        <p class="opacity-90 mb-4">Complete your form and statutory fee payment on the official Nigeria Immigration Service portal.</p>
        <div>
            <a href="https://visa.immigration.gov.ng" target="_blank" rel="noopener" class="btn btn-gold btn-lg fw-bold">
                Continue to NIS Official Visa Portal <i class="bi bi-box-arrow-up-right ms-2"></i>
            </a>
        </div>
    </div>
</div>
