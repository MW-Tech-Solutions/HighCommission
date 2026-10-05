<?php use App\Core\Helper; ?>
<div class="container py-5">
    <!-- Header -->
    <div class="text-center max-w-700 mx-auto mb-5">
        <span class="nhc-badge-diplomatic mb-2 d-inline-block">QUEUE MANAGEMENT SYSTEM</span>
        <h1 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Biometrics & Consular Appointment Booking</h1>
        <p class="text-muted">Schedule your official appointment at the High Commission of Nigeria in Kilimani, Nairobi to eliminate long wait times.</p>
    </div>

    <div class="row g-5">
        <!-- Guidance Column -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-4 p-4 h-100 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-clock-history text-emerald me-2"></i>Consular Operating Hours</h4>
                <ul class="list-unstyled text-secondary small mb-4 d-flex flex-column gap-2">
                    <li class="d-flex align-items-center justify-content-between p-2 bg-light rounded-2">
                        <span>Monday - Friday</span>
                        <strong class="text-dark">9:00 AM - 3:00 PM</strong>
                    </li>
                    <li class="d-flex align-items-center justify-content-between p-2 bg-light rounded-2">
                        <span>Saturdays & Sundays</span>
                        <span class="text-danger fw-semibold">CLOSED</span>
                    </li>
                    <li class="d-flex align-items-center justify-content-between p-2 bg-light rounded-2">
                        <span>Public Holidays (Nigeria & Kenya)</span>
                        <span class="text-danger fw-semibold">CLOSED</span>
                    </li>
                </ul>

                <h6 class="fw-bold text-dark mb-2">Important Instructions:</h6>
                <ul class="small text-secondary ps-3 mb-0">
                    <li class="mb-2">Arrive 15 minutes prior to your scheduled time slot.</li>
                    <li class="mb-2">Present your printed Appointment Confirmation Voucher with QR Code at the main gate.</li>
                    <li class="mb-2">Bring all original supporting documents and application payment slips.</li>
                </ul>
            </div>
        </div>

        <!-- Booking Form Column -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                <h4 class="fw-bold text-emerald-dark mb-3"><i class="bi bi-calendar-plus text-emerald me-2"></i>Reserve Your Appointment Slot</h4>
                <p class="small text-muted mb-4">Complete the form below. Slots are limited to ensure smooth consular processing.</p>

                <form action="<?= Helper::baseUrl('appointment') ?>" method="POST">
                    <?= Helper::csrfField() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Applicant Full Name</label>
                            <input type="text" name="applicant_name" class="form-control" required placeholder="e.g. Tunde Emmanuel">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="applicant_email" class="form-control" required placeholder="e.g. tunde@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone / WhatsApp Number</label>
                            <input type="text" name="applicant_phone" class="form-control" required placeholder="+254 700 000 000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Service Category</label>
                            <select name="service_category" class="form-select" required>
                                <option value="biometrics">Passport Biometrics Capture</option>
                                <option value="visa_interview">Visa Application Interview</option>
                                <option value="legalization">Document Legalization / Attestation</option>
                                <option value="etc_pickup">Emergency Travel Cert. Pickup</option>
                                <option value="general_consular">General Consular Enquiry</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Preferred Appointment Date</label>
                            <input type="date" name="appointment_date" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Preferred Time Slot</label>
                            <select name="time_slot" class="form-select" required>
                                <option value="09:30 AM">09:30 AM - 10:00 AM</option>
                                <option value="10:30 AM">10:30 AM - 11:00 AM</option>
                                <option value="11:30 AM">11:30 AM - 12:00 PM</option>
                                <option value="01:30 PM">01:30 PM - 02:00 PM</option>
                                <option value="02:30 PM">02:30 PM - 03:00 PM</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold small">Additional Notes / Application Ref Number (Optional)</label>
                            <input type="text" name="notes" class="form-control" placeholder="e.g. NIS Application Ref: 12345678">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-emerald btn-lg w-100 mt-4 fw-bold">
                        <i class="bi bi-calendar-check-fill me-2"></i>Confirm Appointment & Issue Voucher
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
