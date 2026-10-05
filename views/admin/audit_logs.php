<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Security & Operations Audit Trail</h3>
        <div class="small text-muted">Immutable log of staff authentications, status changes, CMS updates, and system operations.</div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Timestamp</th>
                        <th>User Email</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="small text-muted font-monospace"><?= Helper::formatDate($log['created_at'], 'd M Y, h:i:s A') ?></td>
                            <td class="fw-semibold text-dark"><?= Helper::sanitize($log['user_email'] ?? 'System / Anonymous') ?></td>
                            <td><span class="badge bg-dark text-white font-monospace"><?= Helper::sanitize($log['action']) ?></span></td>
                            <td class="small text-secondary"><?= Helper::sanitize($log['details']) ?></td>
                            <td class="small font-monospace text-muted"><?= Helper::sanitize($log['ip_address']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
