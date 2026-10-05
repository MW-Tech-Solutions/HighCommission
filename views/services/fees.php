<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('services') ?>">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Consular Fees</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">OFFICIAL SERVICE CHARGES</span>
        <h1>Approved Consular Fees & Payment Rules</h1>
        <p>High Commission of the Federal Republic of Nigeria, Nairobi, Kenya.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="alert alert-warning border-0 p-4 rounded-3 mb-4">
        <h5 class="fw-bold text-dark"><i class="bi bi-shield-exclamation me-2"></i>Official Payment Protocol Notice</h5>
        <p class="mb-0 text-secondary small">Statutory passport and visa fees are paid strictly through the official Nigeria Immigration Service (NIS) / Remita payment portal. The High Commission NEVER requests cash transfers to personal accounts or mobile money (M-Pesa). Official consular administrative charges, if applicable, are payable only via official embassy point-of-sale or bank draft.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Service Type</th>
                    <th>Category / Description</th>
                    <th>Approved Currency</th>
                    <th>Payment Channel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="fw-bold">E-Passport Renewal (Standard 32 Pages)</td>
                    <td>Statutory NIS Passport Fee</td>
                    <td>USD / NGN</td>
                    <td>Official NIS / Remita Portal</td>
                </tr>
                <tr>
                    <td class="fw-bold">E-Passport Renewal (64 Pages)</td>
                    <td>Statutory NIS Passport Fee</td>
                    <td>USD / NGN</td>
                    <td>Official NIS / Remita Portal</td>
                </tr>
                <tr>
                    <td class="fw-bold">Tourist / Business Visa</td>
                    <td>Statutory NIS Visa Fee</td>
                    <td>USD (Category dependent)</td>
                    <td>Official NIS Visa Portal</td>
                </tr>
                <tr>
                    <td class="fw-bold">Emergency Travel Certificate (ETC)</td>
                    <td>Emergency Travel Document</td>
                    <td>KES / USD</td>
                    <td>High Commission Consular Account</td>
                </tr>
                <tr>
                    <td class="fw-bold">Document Legalization / Attestation</td>
                    <td>Notary & Diplomatic Seal</td>
                    <td>KES / USD</td>
                    <td>High Commission Consular Account</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
