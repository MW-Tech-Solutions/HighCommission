<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('diaspora') ?>">Nigerians in Kenya</a></li>
                <li class="breadcrumb-item active" aria-current="page">Online Registration</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic mb-2 d-inline-block">OFFICIAL DIASPORA REGISTRY</span>
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Nigerian Citizen Online Registration</h1>
        <p class="text-muted">High Commission of the Federal Republic of Nigeria, Nairobi — Citizen Welfare Desk.</p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white max-w-900 mx-auto">
        <form action="<?= Helper::baseUrl('diaspora/register') ?>" method="POST">
            <?= Helper::csrfField() ?>

            <!-- Section 1: Personal Data -->
            <h5 class="fw-bold text-emerald-dark mb-3 border-bottom pb-2">
                <i class="bi bi-person-lines-fill me-2"></i>1. Personal Identification
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Full Name (as in Passport)</label>
                    <input type="text" name="full_name" class="form-control" required placeholder="e.g. Tunde Emmanuel">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Date of Birth</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Nigerian Passport Number</label>
                    <input type="text" name="passport_number" class="form-control" required placeholder="e.g. A00123456">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">National Identification Number (NIN)</label>
                    <input type="text" name="nin" class="form-control" placeholder="11-digit NIN Number">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">State of Origin (Nigeria)</label>
                    <input type="text" name="state_of_origin" class="form-control" required placeholder="e.g. Lagos / Kano / Enugu / Rivers">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Local Government Area (LGA)</label>
                    <input type="text" name="lga" class="form-control" placeholder="e.g. Ikeja / Kano Municipal">
                </div>
            </div>

            <!-- Section 2: Kenya Residence Data -->
            <h5 class="fw-bold text-emerald-dark mb-3 border-bottom pb-2">
                <i class="bi bi-geo-alt-fill me-2"></i>2. Residence & Employment in Kenya
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <label class="form-label fw-bold small">Physical Street Address in Kenya</label>
                    <input type="text" name="kenya_address" class="form-control" required placeholder="e.g. House 4B, Woodavenue Apartments, Kilimani">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small">County in Kenya</label>
                    <select name="kenya_county" class="form-select" required>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Mombasa">Mombasa</option>
                        <option value="Kisumu">Kisumu</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Uasin Gishu">Uasin Gishu (Eldoret)</option>
                        <option value="Kiambu">Kiambu</option>
                        <option value="Machakos">Machakos</option>
                        <option value="Kajiado">Kajiado</option>
                        <option value="Kilifi">Kilifi</option>
                        <option value="Other">Other County</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Occupation / Status</label>
                    <input type="text" name="occupation" class="form-control" required placeholder="e.g. Software Engineer / Student / Businessman">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Employer or Educational Institution</label>
                    <input type="text" name="employer_institution" class="form-control" placeholder="e.g. University of Nairobi / Tech Company">
                </div>
            </div>

            <!-- Section 3: Emergency Contacts -->
            <h5 class="fw-bold text-emerald-dark mb-3 border-bottom pb-2">
                <i class="bi bi-telephone-fill me-2"></i>3. Emergency Next-of-Kin Contacts
            </h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Emergency Contact in Kenya (Name)</label>
                    <input type="text" name="emergency_contact_kenya" class="form-control" required placeholder="Name of next of kin in Kenya">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Emergency Contact Phone (Kenya)</label>
                    <input type="text" name="emergency_phone_kenya" class="form-control" required placeholder="+254 700 000 000">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Emergency Contact in Nigeria (Name)</label>
                    <input type="text" name="emergency_contact_nigeria" class="form-control" required placeholder="Name of family contact in Nigeria">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Emergency Contact Phone (Nigeria)</label>
                    <input type="text" name="emergency_phone_nigeria" class="form-control" required placeholder="+234 800 000 0000">
                </div>
            </div>

            <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold">
                <i class="bi bi-check-circle-fill me-2"></i>Submit Citizen Registration
            </button>
        </form>
    </div>
</div>
