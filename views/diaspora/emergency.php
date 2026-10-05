<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header" style="background: linear-gradient(135deg, #991B1B 0%, #450A0A 100%); border-bottom-color: #EF4444;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('diaspora') ?>">Nigerians in Kenya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Emergency Distress Beacon</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic" style="background: #EF4444; color: #FFFFFF;">24/7 CONSULAR EMERGENCY</span>
        <h1>Emergency Distress Beacon</h1>
        <p>High Commission of the Federal Republic of Nigeria, Nairobi — Emergency Response Desk.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4 mb-5">
        <div class="col-lg-4">
            <div class="card shadow-sm border-danger border-2 rounded-4 p-4 h-100 bg-white">
                <h4 class="fw-bold text-danger mb-3"><i class="bi bi-telephone-outbound-fill me-2"></i>Emergency Hotline</h4>
                <div class="p-3 bg-danger bg-opacity-10 text-danger rounded-3 mb-3 text-center">
                    <div class="fs-4 fw-bold">+254 795 770 247</div>
                    <div class="small fw-semibold">24 Hours Diplomatic Duty Desk</div>
                </div>
                <p class="text-muted small">Use this beacon for urgent situations involving medical emergencies, arrests, severe accidents, or life-safety distress affecting Nigerian citizens in Kenya, Somalia, or Seychelles.</p>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
                <h4 class="fw-bold text-danger mb-3"><i class="bi bi-broadcast me-2"></i>Transmit Urgent Distress Signal</h4>
                <p class="small text-muted mb-4">Submitting this form immediately flags your emergency to consular duty officers on call.</p>

                <form action="<?= Helper::baseUrl('diaspora/emergency') ?>" method="POST">
                    <?= Helper::csrfField() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Your Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Tunde Emmanuel">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone Number in Kenya</label>
                            <input type="text" name="phone" class="form-control" required placeholder="+254 700 000 000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="e.g. tunde@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Category of Emergency</label>
                            <select name="distress_type" class="form-select" required>
                                <option value="Medical Emergency">Medical Crisis / Hospitalization</option>
                                <option value="Legal Distress">Police Detention / Legal Distress</option>
                                <option value="Accident">Severe Accident</option>
                                <option value="Stranded Citizen">Stranded / Lost Documentation</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Current Precise Location in Kenya</label>
                            <input type="text" name="location" class="form-control" required placeholder="Hospital name, police station, or street address in Kenya">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Details of Emergency Situation</label>
                            <textarea name="details" class="form-control" rows="4" required placeholder="Describe what has happened and what immediate assistance is required..."></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger btn-lg w-100 mt-4 fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Transmit Emergency Distress Signal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
