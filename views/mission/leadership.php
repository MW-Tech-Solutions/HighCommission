<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('mission') ?>">The Mission</a></li>
                <li class="breadcrumb-item active" aria-current="page">Leadership</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">MISSION LEADERSHIP</span>
        <h1>High Commission Leadership & Principal Officers</h1>
        <p>High Commission of the Federal Republic of Nigeria, Nairobi, Kenya.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4">
        <div class="col-md-6">
            <div class="nhc-card p-4 d-flex align-items-center gap-4">
                <div class="nhc-crest-badge" style="width: 70px; height: 70px; font-size: 2rem;">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <span class="badge bg-gold text-dark mb-1">HEAD OF MISSION</span>
                    <h4 class="fw-bold text-dark mb-1">His Excellency the High Commissioner</h4>
                    <p class="text-muted small mb-0">Extraordinary and Plenipotentiary Representative of the Federal Republic of Nigeria to the Republic of Kenya.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="nhc-card p-4 d-flex align-items-center gap-4">
                <div class="nhc-crest-badge" style="width: 70px; height: 70px; font-size: 2rem;">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <span class="badge bg-emerald text-white mb-1">DEPUTY HEAD OF MISSION</span>
                    <h4 class="fw-bold text-dark mb-1">Minister / Deputy Head of Mission</h4>
                    <p class="text-muted small mb-0">Overseeing diplomatic policy coordination, bilateral political affairs, and mission administration.</p>
                </div>
            </div>
        </div>
    </div>
</div>
