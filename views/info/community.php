<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('diaspora') ?>">Nigerians in Kenya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Community Directory</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">APPROVED COMMUNITY ORGANIZATIONS</span>
        <h1>Nigerian Community Associations in Kenya</h1>
        <p>High Commission verified student associations, professional bodies, and diaspora cultural unions.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4">
        <div class="col-md-6">
            <div class="nhc-card p-4 h-100">
                <h4 class="fw-bold text-emerald-dark mb-2"><i class="bi bi-people-fill text-gold me-2"></i>Association of Nigerian Community in Kenya (ANCK)</h4>
                <p class="text-muted small">The umbrella body representing Nigerian residents, business executives, and families living in Kenya.</p>
                <div class="small text-secondary">Contact: <a href="mailto:info@nigeriankenya.or.ke">info@nigeriankenya.or.ke</a></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="nhc-card p-4 h-100">
                <h4 class="fw-bold text-emerald-dark mb-2"><i class="bi bi-mortarboard-fill text-gold me-2"></i>Nigerian Students Union in Kenya (NSUK)</h4>
                <p class="text-muted small">Representing undergraduate and postgraduate scholars enrolled across Kenyan universities (UoN, USIU, Kenyatta University).</p>
                <div class="small text-secondary">Contact: <a href="mailto:info@nigeriankenya.or.ke">info@nigeriankenya.or.ke</a></div>
            </div>
        </div>
    </div>
</div>
