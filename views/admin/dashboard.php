<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="fw-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif;">High Commission Staff Workspace</h2>
        <div class="small text-muted">Diplomatic Case Management & Editorial Operations</div>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= Helper::baseUrl('admin/requests') ?>" class="btn btn-emerald btn-sm fw-bold">
            <i class="bi bi-inbox-fill me-1"></i>Manage Consular Cases
        </a>
        <a href="<?= Helper::baseUrl('admin/notices') ?>" class="btn btn-outline-emerald btn-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i>Publish Notice
        </a>
    </div>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="admin-stat-card border-start border-4 border-warning">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small fw-bold" style="font-size: 0.78rem;">Pending Consular Cases</span>
                <div class="rounded-circle bg-warning bg-opacity-10 p-1 text-warning d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-hourglass-split fs-6"></i>
                </div>
            </div>
            <div class="fs-3 fw-bold text-dark my-0"><?= $pendingCount ?></div>
            <div class="mt-2 pt-1 border-top">
                <a href="<?= Helper::baseUrl('admin/requests') ?>" class="small text-emerald fw-bold text-decoration-none" style="font-size: 0.78rem;">View Case Queue &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="admin-stat-card border-start border-4 border-danger">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small fw-bold" style="font-size: 0.78rem;">Urgent Distress Alerts</span>
                <div class="rounded-circle bg-danger bg-opacity-10 p-1 text-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-bell-fill fs-6"></i>
                </div>
            </div>
            <div class="fs-3 fw-bold text-danger my-0"><?= $distressCount ?></div>
            <div class="mt-2 pt-1 border-top">
                <a href="<?= Helper::baseUrl('admin/requests') ?>" class="small text-danger fw-bold text-decoration-none" style="font-size: 0.78rem;">Inspect Emergencies &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="admin-stat-card border-start border-4 border-success">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small fw-bold" style="font-size: 0.78rem;">Total Appointments</span>
                <div class="rounded-circle bg-success bg-opacity-10 p-1 text-success d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-calendar-check-fill fs-6"></i>
                </div>
            </div>
            <div class="fs-3 fw-bold text-success my-0"><?= $appointmentCount ?></div>
            <div class="mt-2 pt-1 border-top">
                <a href="<?= Helper::baseUrl('admin/appointments') ?>" class="small text-emerald fw-bold text-decoration-none" style="font-size: 0.78rem;">View Schedule &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="admin-stat-card border-start border-4 border-emerald">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="text-muted small fw-bold" style="font-size: 0.78rem;">Registered Citizens</span>
                <div class="rounded-circle bg-emerald-subtle p-1 text-emerald d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-people-fill fs-6"></i>
                </div>
            </div>
            <div class="fs-3 fw-bold text-emerald my-0"><?= $citizenCount ?></div>
            <div class="mt-2 pt-1 border-top">
                <a href="<?= Helper::baseUrl('admin/citizens') ?>" class="small text-emerald fw-bold text-decoration-none" style="font-size: 0.78rem;">View Registry &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Consular Cases Queue -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-inbox-fill text-emerald me-2"></i>Consular Cases Queue</h5>
        <a href="<?= Helper::baseUrl('admin/requests') ?>" class="btn btn-outline-secondary btn-sm fw-bold">Full Queue</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="text-nowrap ps-3">Reference #</th>
                        <th class="text-nowrap">Applicant</th>
                        <th class="text-nowrap">Service Type</th>
                        <th>Subject</th>
                        <th class="text-nowrap">Status</th>
                        <th class="text-nowrap">Priority</th>
                        <th class="text-nowrap text-end pe-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($requests, 0, 5) as $req): ?>
                        <tr>
                            <td class="ps-3 text-nowrap"><code class="fw-bold text-emerald"><?= Helper::sanitize($req['reference_number']) ?></code></td>
                            <td>
                                <div class="fw-bold text-dark"><?= Helper::sanitize($req['applicant_name']) ?></div>
                                <div class="small text-muted"><?= Helper::sanitize($req['applicant_email']) ?></div>
                            </td>
                            <td class="text-nowrap"><span class="badge bg-light text-dark border text-uppercase px-2 py-1" style="font-size: 0.72rem;"><?= str_replace('_', ' ', $req['service_type']) ?></span></td>
                            <td><div class="fw-semibold text-dark text-truncate" style="max-width: 220px; font-size: 0.84rem;"><?= Helper::sanitize($req['subject']) ?></div></td>
                            <td class="text-nowrap"><?= Helper::statusBadge($req['status']) ?></td>
                            <td class="text-nowrap">
                                <span class="badge bg-<?= $req['priority'] === 'urgent' ? 'danger' : 'secondary' ?> text-uppercase px-2 py-1"><?= $req['priority'] ?></span>
                            </td>
                            <td class="text-nowrap text-end pe-3">
                                <a href="<?= Helper::baseUrl('admin/requests/view?ref=' . $req['reference_number']) ?>" class="btn btn-emerald btn-sm py-1 px-3 fw-bold">
                                    Reply / Action <i class="bi bi-chat-dots ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
