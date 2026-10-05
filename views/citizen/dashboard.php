<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <span class="nhc-badge-diplomatic bg-gold text-dark mb-1 d-inline-block">CITIZEN PORTAL DASHBOARD</span>
            <h2 class="fw-bold text-emerald-dark mb-0" style="font-family: 'Playfair Display', serif;">Welcome, <?= Helper::sanitize($user['full_name']) ?></h2>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= Helper::baseUrl('appointment') ?>" class="btn btn-emerald btn-sm">
                <i class="bi bi-calendar-plus me-1"></i>Book New Appointment
            </a>
            <a href="<?= Helper::baseUrl('consular/etc') ?>" class="btn btn-outline-emerald btn-sm">
                <i class="bi bi-file-earmark-medical me-1"></i>Apply for ETC
            </a>
        </div>
    </div>

    <!-- Stats Summary Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-white rounded-4 border-start border-4 border-emerald">
                <div class="small text-muted mb-1">Submitted Consular Cases</div>
                <div class="fs-2 fw-bold text-emerald-dark"><?= count($requests) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-white rounded-4 border-start border-4 border-gold">
                <div class="small text-muted mb-1">Confirmed Appointments</div>
                <div class="fs-2 fw-bold text-dark"><?= count($appointments) ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 border-0 shadow-sm bg-white rounded-4 border-start border-4 border-info">
                <div class="small text-muted mb-1">Diaspora Registration Status</div>
                <div class="fs-5 fw-bold text-dark mt-2">
                    <?= $diasporaProfile ? Helper::statusBadge($diasporaProfile['status']) : '<a href="' . Helper::baseUrl('diaspora/register') . '" class="btn btn-warning btn-sm">Not Registered — Complete Form</a>' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- 1. Active Consular Requests & Case Tracking -->
    <div class="card shadow-sm border-0 rounded-4 mb-5 bg-white">
        <div class="card-header bg-emerald-dark text-white p-3 rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="font-family: 'Playfair Display', serif;"><i class="bi bi-journal-text me-2"></i>My Consular Cases & Enquiries</h5>
            <a href="<?= Helper::baseUrl('contact') ?>" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg me-1"></i>New Enquiry</a>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($requests)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>Reference #</th>
                                <th>Service Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Assigned Officer</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $req): ?>
                                <tr>
                                    <td><code class="fw-bold"><?= Helper::sanitize($req['reference_number']) ?></code></td>
                                    <td><span class="badge bg-light text-dark border text-uppercase"><?= str_replace('_', ' ', $req['service_type']) ?></span></td>
                                    <td class="fw-semibold text-dark"><?= Helper::sanitize($req['subject']) ?></td>
                                    <td><?= Helper::statusBadge($req['status']) ?></td>
                                    <td class="small text-muted"><?= Helper::sanitize($req['officer_name'] ?? 'Pending Assignment') ?></td>
                                    <td class="small text-muted"><?= Helper::formatDate($req['created_at'], 'd M Y') ?></td>
                                    <td>
                                        <a href="<?= Helper::baseUrl('portal/request?ref=' . $req['reference_number']) ?>" class="btn btn-outline-emerald btn-sm py-1 px-2">
                                            View Thread <i class="bi bi-chat-left-text ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-inbox fs-2 mb-2 d-block text-secondary"></i>
                    No consular cases or enquiries submitted yet.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2. Appointments List -->
    <div class="card shadow-sm border-0 rounded-4 mb-5 bg-white">
        <div class="card-header bg-dark text-white p-3 rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-gold" style="font-family: 'Playfair Display', serif;"><i class="bi bi-calendar-check me-2"></i>My Booked Appointments</h5>
        </div>
        <div class="card-body p-0">
            <?php if (!empty($appointments)): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>Voucher #</th>
                                <th>Category</th>
                                <th>Scheduled Date</th>
                                <th>Time Slot</th>
                                <th>Status</th>
                                <th>Voucher</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $apt): ?>
                                <tr>
                                    <td><code><?= Helper::sanitize($apt['voucher_number']) ?></code></td>
                                    <td class="fw-semibold text-uppercase"><?= str_replace('_', ' ', $apt['service_category']) ?></td>
                                    <td><?= Helper::formatDate($apt['appointment_date'], 'd M Y') ?></td>
                                    <td class="fw-bold text-success"><?= Helper::sanitize($apt['time_slot']) ?></td>
                                    <td><?= Helper::statusBadge($apt['status']) ?></td>
                                    <td>
                                        <a href="<?= Helper::baseUrl('appointment/voucher?code=' . $apt['voucher_number']) ?>" class="btn btn-gold btn-sm py-1 px-2">
                                            <i class="bi bi-ticket-perforated me-1"></i>Voucher
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-calendar-x fs-2 mb-2 d-block text-secondary"></i>
                    No upcoming biometric or consular appointments reserved.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
