<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trade & Investment</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">BILATERAL ECONOMIC DESK</span></div>
        <h1 class="display-6 fw-bold">Trade, Commerce & Investment Gateway</h1>
        <p class="max-w-700 mx-auto">Promoting bilateral economic partnerships, trade facilitation, and cross-border investments under AfCFTA between Nigeria and Kenya.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Stats Bar -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="nhc-card p-4 text-center h-100 bg-white">
                <div class="nhc-service-icon mx-auto mb-2 bg-emerald-subtle text-emerald" style="width: 46px; height: 46px; font-size: 1.3rem;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="fs-2 fw-bold text-emerald-dark mb-1" style="font-family: var(--font-heading);">$470B+</div>
                <div class="small fw-semibold text-dark">Nigeria Nominal GDP</div>
                <span class="small text-muted" style="font-size: 0.78rem;">Africa's Largest Economy</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="nhc-card p-4 text-center h-100 bg-white">
                <div class="nhc-service-icon mx-auto mb-2 bg-emerald-subtle text-emerald" style="width: 46px; height: 46px; font-size: 1.3rem;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="fs-2 fw-bold text-emerald-dark mb-1" style="font-family: var(--font-heading);">220M+</div>
                <div class="small fw-semibold text-dark">Consumer Market</div>
                <span class="small text-muted" style="font-size: 0.78rem;">Dynamic Youth Population</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="nhc-card p-4 text-center h-100 bg-white">
                <div class="nhc-service-icon mx-auto mb-2 bg-gold bg-opacity-20 text-dark" style="width: 46px; height: 46px; font-size: 1.3rem;">
                    <i class="bi bi-globe-africa-west"></i>
                </div>
                <div class="fs-2 fw-bold text-dark mb-1" style="font-family: var(--font-heading);">AfCFTA</div>
                <div class="small fw-semibold text-dark">Trade Alignment</div>
                <span class="small text-muted" style="font-size: 0.78rem;">Duty-Free Access</span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="nhc-card p-4 text-center h-100 bg-white">
                <div class="nhc-service-icon mx-auto mb-2 bg-emerald-subtle text-emerald" style="width: 46px; height: 46px; font-size: 1.3rem;">
                    <i class="bi bi-cpu-fill"></i>
                </div>
                <div class="fs-2 fw-bold text-emerald-dark mb-1" style="font-family: var(--font-heading);">Top 3</div>
                <div class="small fw-semibold text-dark">Bilateral Tech Hubs</div>
                <span class="small text-muted" style="font-size: 0.78rem;">Nairobi & Lagos Corridor</span>
            </div>
        </div>
    </div>

    <!-- Business Matchmaking Form -->
    <div class="nhc-card p-4 p-md-5 border-0 shadow-lg rounded-4 bg-white max-w-900 mx-auto">
        <div class="d-flex align-items-center gap-3 mb-4 pb-2 border-bottom">
            <div class="nhc-service-icon bg-gold bg-opacity-20 text-dark flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.4rem;">
                <i class="bi bi-briefcase-fill text-dark"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Kenya-Nigeria Business Matchmaking Desk</h3>
                <span class="small text-muted">Register corporate investment, export, or joint venture inquiries.</span>
            </div>
        </div>

        <form action="<?= Helper::baseUrl('trade') ?>" method="POST">
            <?= Helper::csrfField() ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Company / Organization Name</label>
                    <input type="text" name="company_name" class="form-control form-control-lg fs-6" required placeholder="e.g. Nairobi Agro-Tech Enterprises">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Contact Person Name</label>
                    <input type="text" name="contact_person" class="form-control form-control-lg fs-6" required placeholder="e.g. James Oduor">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Corporate Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg fs-6" required placeholder="e.g. contact@company.com">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Phone / WhatsApp Number</label>
                    <input type="text" name="phone" class="form-control form-control-lg fs-6" required placeholder="e.g. +254 712 345 678">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Business Sector</label>
                    <select name="sector" class="form-select form-select-lg fs-6" required>
                        <option value="">Select Sector...</option>
                        <option value="agriculture">Agribusiness & Food Processing</option>
                        <option value="fintech">Fintech & Financial Services</option>
                        <option value="manufacturing">Manufacturing & FMCG</option>
                        <option value="real_estate">Real Estate & Infrastructure</option>
                        <option value="energy">Oil, Gas & Renewable Energy</option>
                        <option value="other">Other Commercial Sector</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Primary Inquiry Type</label>
                    <select name="inquiry_type" class="form-select form-select-lg fs-6" required>
                        <option value="">Select Inquiry Type...</option>
                        <option value="joint_venture">Joint Venture Partnership</option>
                        <option value="export_import">Export / Import Facilitation</option>
                        <option value="investment">Direct Capital Investment</option>
                        <option value="trade_mission">Bilateral Trade Mission Participation</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold small">Inquiry Brief / Business Proposal Overview</label>
                    <textarea name="proposal_summary" class="form-control" rows="4" required placeholder="Describe your business objective, investment scope, or target partners..."></textarea>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-accent btn-lg px-5 shadow fw-bold">
                        <i class="bi bi-send-fill me-2"></i>Submit Trade Inquiry
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
