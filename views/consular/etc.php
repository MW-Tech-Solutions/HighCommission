<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('services') ?>">Consular Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">Emergency Travel Certificate</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic" style="background-color: #DC2626; color: #FFFFFF;">EMERGENCY TRAVEL DOCUMENT</span>
        <h1>Emergency Travel Certificate (ETC) Request</h1>
        <p>Issued strictly for one-way emergency travel back to Nigeria for Nigerian citizens in Kenya with lost or expired documents.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-5">
        <!-- Guidance Column -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-info-circle-fill text-emerald me-2"></i>ETC Guidelines</h4>
                <p class="text-muted small">An Emergency Travel Certificate (ETC) is a temporary single-journey travel document that allows stranded Nigerian nationals to return home immediately.</p>

                <h6 class="fw-bold text-dark mt-3 mb-2">Prerequisites:</h6>
                <ul class="small text-secondary ps-3 mb-4">
                    <li class="mb-2">Must be a verified Nigerian citizen.</li>
                    <li class="mb-2">Police Report / Loss Abstract (if replacing a lost passport).</li>
                    <li class="mb-2">Copy of lost passport data page or birth certificate / NIN.</li>
                    <li class="mb-2">Confirmed flight itinerary to Nigeria.</li>
                    <li class="mb-2">Two (2) passport-sized photographs.</li>
                </ul>

                <div class="alert alert-info py-2 px-3 small border-0 rounded-3 mb-0">
                    <i class="bi bi-clock me-1"></i><strong>Processing Estimate:</strong> 24 to 48 hours upon physical identity verification at the High Commission in Kilimani, Nairobi.
                </div>
            </div>
        </div>

        <!-- Form Column -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-pencil-square text-emerald me-2"></i>Submit ETC Online Application Draft</h4>
                <p class="small text-muted mb-4">Fill in your details below to register your ETC request with consular officers before visiting the embassy.</p>

                <form action="<?= Helper::baseUrl('consular/etc') ?>" method="POST">
                    <?= Helper::csrfField() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Full Name (as in Passport/NIN)</label>
                            <input type="text" name="applicant_name" class="form-control" required placeholder="e.g. Tunde Emmanuel">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="applicant_email" class="form-control" required placeholder="e.g. tunde@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone / WhatsApp Number in Kenya</label>
                            <input type="text" name="applicant_phone" class="form-control" required placeholder="+254 700 000 000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Reason for ETC</label>
                            <select name="reason" class="form-select" required>
                                <option value="Lost Passport">Lost Passport Booklet</option>
                                <option value="Expired Passport">Expired Passport (Urgent Travel)</option>
                                <option value="Damaged Passport">Damaged / Unusable Passport</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Intended Date of Flight</label>
                            <input type="date" name="travel_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Destination Airport in Nigeria</label>
                            <input type="text" name="destination" class="form-control" required placeholder="e.g. Nnamdi Azikiwe Airport Abuja / MMIA Lagos">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Details of Emergency Situation</label>
                            <textarea name="details" class="form-control" rows="4" required placeholder="Describe the circumstances surrounding your lost/expired passport and urgent flight details..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-emerald btn-lg w-100 mt-4 fw-bold">
                        <i class="bi bi-send-fill me-2"></i>Transmit ETC Draft Application
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
