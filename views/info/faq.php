<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <span class="nhc-badge-diplomatic mb-2 d-inline-block">FREQUENTLY ASKED QUESTIONS</span>
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Consular & Public FAQs</h1>
        <p class="text-muted">Answers to common questions regarding passport renewals, visas, appointments, and diaspora support.</p>
    </div>

    <div class="accordion shadow-sm rounded-4 overflow-hidden" id="faqAccordion">
        <div class="accordion-item border-0">
            <h2 class="accordion-header" id="faq1">
                <button class="accordion-button fw-bold text-emerald-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq1">
                    How do I renew my Nigerian passport in Nairobi?
                </button>
            </h2>
            <div id="collapseFaq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-secondary small">
                    First complete your application and payment on the official NIS portal (passport.immigration.gov.ng). Then book a biometrics appointment slot on this website and visit the High Commission in Kilimani with your NIN slip, payment printout, and existing passport booklet.
                </div>
            </div>
        </div>

        <div class="accordion-item border-0 border-top">
            <h2 class="accordion-header" id="faq2">
                <button class="accordion-button collapsed fw-bold text-emerald-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq2">
                    Are consular fees payable in cash at the embassy?
                </button>
            </h2>
            <div id="collapseFaq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body text-secondary small">
                    No. All statutory passport and visa fees are processed strictly online through the official NIS / Remita portals. The High Commission never accepts cash payments or mobile money transfers to personal phone numbers.
                </div>
            </div>
        </div>
    </div>
</div>
