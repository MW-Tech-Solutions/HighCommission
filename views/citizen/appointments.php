<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold text-emerald-dark mb-0" style="font-family: 'Playfair Display', serif;">My Reserved Appointments</h2>
        <a href="<?= Helper::baseUrl('services/appointments') ?>" class="btn btn-emerald btn-sm"><i class="bi bi-calendar-plus me-1"></i>Book Appointment Slot</a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th>Voucher #</th>
                            <th>Category</th>
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
        </div>
    </div>
</div>
