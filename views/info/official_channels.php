<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <span class="nhc-badge-diplomatic mb-2 d-inline-block">OFFICIAL DOMAIN & CHANNELS</span>
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Official Channels & Anti-Scam Verification</h1>
        <p class="text-muted">High Commission of the Federal Republic of Nigeria in Nairobi, Kenya.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white max-w-800 mx-auto">
        <h4 class="fw-bold text-dark mb-3"><i class="bi bi-shield-check text-success me-2"></i>Official Domain & Contact Directory</h4>
        <ul class="list-group list-group-flush mb-4">
            <li class="list-group-item py-3">
                <strong>Official Website:</strong> <code class="fs-6">https://nigeriankenya.or.ke/</code>
            </li>
            <li class="list-group-item py-3">
                <strong>Official Consular Email:</strong> <code>info@nigeriankenya.or.ke</code>
            </li>
            <li class="list-group-item py-3">
                <strong>Official Phone Helpline:</strong> <code>+254 795 770 247</code>
            </li>
            <li class="list-group-item py-3">
                <strong>Official Passport & Visa Payment Portals:</strong> <code>passport.immigration.gov.ng</code> / <code>visa.immigration.gov.ng</code>
            </li>
        </ul>

        <div class="alert alert-danger mb-0 border-0">
            <strong>Anti-Scam Notice:</strong> The High Commission never sends emails requesting payments to personal bank accounts, Western Union, or mobile money lines. Always verify receipt codes on our <a href="<?= Helper::baseUrl('verify') ?>" class="fw-bold text-danger">Authenticator Page</a>.
        </div>
    </div>
</div>
