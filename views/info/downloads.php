<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <span class="nhc-badge-diplomatic mb-2 d-inline-block">PUBLIC FORMS & DOCUMENTS</span>
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Official Downloads & Consular Forms</h1>
        <p class="text-muted">High Commission official forms, emergency travel certificate checklists, and public advisories.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
        <div class="list-group list-group-flush">
            <div class="list-group-item d-flex align-items-center justify-content-between py-3">
                <div>
                    <h6 class="fw-bold mb-1"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Citizen Online Registration Offline Form</h6>
                    <div class="small text-muted">PDF Document | Version 2.0</div>
                </div>
                <a href="<?= Helper::baseUrl('diaspora/register') ?>" class="btn btn-outline-emerald btn-sm"><i class="bi bi-download me-1"></i>Download PDF</a>
            </div>
            <div class="list-group-item d-flex align-items-center justify-content-between py-3">
                <div>
                    <h6 class="fw-bold mb-1"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Emergency Travel Certificate Checklist & Requirements</h6>
                    <div class="small text-muted">PDF Document | Version 1.8</div>
                </div>
                <a href="<?= Helper::baseUrl('consular/etc') ?>" class="btn btn-outline-emerald btn-sm"><i class="bi bi-download me-1"></i>Download PDF</a>
            </div>
        </div>
    </div>
</div>
