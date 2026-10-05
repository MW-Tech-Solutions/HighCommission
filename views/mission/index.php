<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">The Mission</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">DIPLOMATIC MANDATE & JURISDICTION</span></div>
        <h1 class="display-6 fw-bold">The High Commission of Nigeria, Nairobi</h1>
        <p class="max-w-700 mx-auto">Representing the sovereign authority, bilateral interests, and diplomatic representation of the Federal Republic of Nigeria in East Africa.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Quick Navigation Bar for Mission Sub-Pages -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <a href="<?= Helper::baseUrl('mission/message') ?>" class="btn btn-outline-emerald btn-sm rounded-pill px-3 fw-semibold"><i class="bi bi-chat-quote me-1.5"></i>Head of Mission's Message</a>
        <a href="<?= Helper::baseUrl('mission/leadership') ?>" class="btn btn-outline-emerald btn-sm rounded-pill px-3 fw-semibold"><i class="bi bi-person-lines-fill me-1.5"></i>Principal Officers</a>
        <a href="<?= Helper::baseUrl('mission/history') ?>" class="btn btn-outline-emerald btn-sm rounded-pill px-3 fw-semibold"><i class="bi bi-clock-history me-1.5"></i>Mission History</a>
        <a href="<?= Helper::baseUrl('mission/friends') ?>" class="btn btn-outline-emerald btn-sm rounded-pill px-3 fw-semibold"><i class="bi bi-hand-thumbs-up me-1.5"></i>Friends of Nigeria</a>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="nhc-card p-4 p-md-5 h-100 bg-white">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="nhc-service-icon bg-gold bg-opacity-20 text-dark">
                        <i class="bi bi-bank2"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Diplomatic Mandate</h3>
                        <span class="small text-muted">Sovereign Representation</span>
                    </div>
                </div>
                <p class="text-body lh-base mb-3">The High Commission is responsible for sustaining bilateral relations between the Federal Republic of Nigeria and the Republic of Kenya, as well as concurrent diplomatic representation to Somalia and Seychelles.</p>
                <p class="text-body lh-base mb-0">Our mission encompasses diplomatic negotiation, trade facilitation, citizen protection, cultural exchange, and permanent representation at the United Nations Environment Programme (UNEP) and UN-Habitat headquarters in Nairobi.</p>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="nhc-card p-4 p-md-5 h-100 bg-white">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="nhc-service-icon bg-emerald-subtle text-emerald">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Core Pillars</h3>
                        <span class="small text-muted">Diplomatic Objectives</span>
                    </div>
                </div>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-emerald text-white p-1 d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 26px; height: 26px;">
                            <i class="bi bi-check-lg fw-bold small"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Citizen Protection & Welfare</strong>
                            <span class="text-muted small">Ensuring the security, legal rights, and welfare of Nigerian citizens residing or traveling in East Africa.</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-emerald text-white p-1 d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 26px; height: 26px;">
                            <i class="bi bi-check-lg fw-bold small"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Bilateral Trade & AfCFTA</strong>
                            <span class="text-muted small">Facilitating cross-border investments, commercial partnerships, and trade missions under AfCFTA.</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-circle bg-emerald text-white p-1 d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 26px; height: 26px;">
                            <i class="bi bi-check-lg fw-bold small"></i>
                        </div>
                        <div>
                            <strong class="text-dark d-block">Consular E-Services</strong>
                            <span class="text-muted small">Delivering secure passport renewals, visa processing guidance, emergency travel documents, and attestations.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
