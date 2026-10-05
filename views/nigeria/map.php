<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('discover-nigeria') ?>">Discover Nigeria</a></li>
                <li class="breadcrumb-item active" aria-current="page">36 States Explorer</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">CULTURAL & GEOGRAPHIC SHOWCASE</span></div>
        <h1 class="display-6 fw-bold">Discover Nigeria: 36 States & FCT Explorer</h1>
        <p class="max-w-700 mx-auto">Explore the heritage, economic hubs, capital cities, natural resources, and world-class tourist landmarks across the 36 States and Federal Capital Territory of the Federal Republic of Nigeria.</p>
    </div>
</div>

<div class="container pb-5">

    <!-- Geopolitical Zone Filter Buttons -->
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
        <button type="button" class="btn btn-emerald active state-zone-btn rounded-pill px-3 fw-semibold" data-zone="all">All 36 States + FCT</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="north_west">North West</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="north_east">North East</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="north_central">North Central</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="south_west">South West</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="south_east">South East</button>
        <button type="button" class="btn btn-outline-emerald state-zone-btn rounded-pill px-3 fw-semibold" data-zone="south_south">South South</button>
    </div>

    <!-- State Cards Grid -->
    <div class="row g-4" id="statesGrid">
        <?php foreach ($states as $index => $state): ?>
            <div class="col-md-4 col-lg-3 state-card-item" data-zone="<?= Helper::sanitize($state['zone']) ?>">
                <div class="nhc-card p-4 h-100 d-flex flex-column bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-gold text-dark font-monospace">STATE #<?= sprintf('%02d', $index + 1) ?></span>
                        <span class="badge bg-emerald-subtle text-emerald text-capitalize small border border-emerald-subtle"><?= str_replace('_', ' ', $state['zone']) ?></span>
                    </div>
                    <h4 class="fw-bold text-emerald-dark mb-1" style="font-family: var(--font-heading);"><?= Helper::sanitize($state['name']) ?></h4>
                    <div class="small text-muted mb-3"><i class="bi bi-geo-alt-fill text-gold me-1"></i>Capital: <strong class="text-dark"><?= Helper::sanitize($state['capital']) ?></strong></div>

                    <div class="small mb-2">
                        <span class="text-secondary">Hub:</span> <strong class="text-dark"><?= Helper::sanitize($state['hub']) ?></strong>
                    </div>
                    <div class="small mb-3 flex-grow-1">
                        <span class="text-secondary">Landmark:</span> <strong class="text-dark"><?= Helper::sanitize($state['landmark']) ?></strong>
                    </div>

                    <button type="button" class="btn btn-emerald btn-sm w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#stateModal<?= $index ?>">
                        View Details <i class="bi bi-info-circle ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- State Details Modal -->
            <div class="modal fade" id="stateModal<?= $index ?>" tabindex="-1" aria-labelledby="stateModalLabel<?= $index ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header bg-emerald text-white rounded-top-4">
                            <h5 class="modal-header-title fw-bold mb-0 text-white" id="stateModalLabel<?= $index ?>" style="font-family: var(--font-heading);">
                                <?= Helper::sanitize($state['name']) ?> State — Federal Republic of Nigeria
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <span class="badge bg-emerald me-2"><?= str_replace('_', ' ', strtoupper($state['zone'])) ?> ZONE</span>
                                <span class="badge bg-gold text-dark">CAPITAL: <?= Helper::sanitize(strtoupper($state['capital'])) ?></span>
                            </div>
                            <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Economic Hub & Key Industries:</h6>
                            <p class="text-body small mb-3"><?= Helper::sanitize($state['hub']) ?></p>
                            
                            <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Famous Cultural Landmark:</h6>
                            <p class="text-body small mb-0"><?= Helper::sanitize($state['landmark']) ?></p>
                        </div>
                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-outline-secondary btn-sm rounded-3" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.state-zone-btn');
    const items = document.querySelectorAll('.state-card-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            buttons.forEach(b => b.classList.remove('active', 'btn-emerald'));
            buttons.forEach(b => b.classList.add('btn-outline-emerald'));
            
            this.classList.remove('btn-outline-emerald');
            this.classList.add('active', 'btn-emerald');

            const zone = this.getAttribute('data-zone');
            items.forEach(item => {
                if (zone === 'all' || item.getAttribute('data-zone') === zone) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
