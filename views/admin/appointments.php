<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Biometrics & Consular Appointments Schedule</h3>
        <div class="small text-muted">Manage daily appointment slots, gate verification, and attendance status.</div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Voucher #</th>
                        <th>Applicant</th>
                        <th>Service Category</th>
                        <th>Scheduled Date</th>
                        <th>Time Slot</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $apt): ?>
                        <tr>
                            <td><code><?= Helper::sanitize($apt['voucher_number']) ?></code></td>
                            <td>
                                <div class="fw-bold text-dark"><?= Helper::sanitize($apt['applicant_name']) ?></div>
                                <div class="small text-muted"><?= Helper::sanitize($apt['applicant_email']) ?> | <?= Helper::sanitize($apt['applicant_phone']) ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border text-uppercase"><?= str_replace('_', ' ', $apt['service_category']) ?></span></td>
                            <td class="fw-bold text-dark"><?= Helper::formatDate($apt['appointment_date'], 'd M Y') ?></td>
                            <td class="fw-bold text-success"><?= Helper::sanitize($apt['time_slot']) ?></td>
                            <td><?= Helper::statusBadge($apt['status']) ?></td>
                            <td>
                                <form action="<?= Helper::baseUrl('admin/appointments') ?>" method="POST" class="d-inline">
                                    <?= Helper::csrfField() ?>
                                    <input type="hidden" name="appointment_id" value="<?= $apt['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="confirmed" <?= $apt['status'] === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                        <option value="attended" <?= $apt['status'] === 'attended' ? 'selected' : '' ?>>Attended / Gate Cleared</option>
                                        <option value="rescheduled" <?= $apt['status'] === 'rescheduled' ? 'selected' : '' ?>>Rescheduled</option>
                                        <option value="cancelled" <?= $apt['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
