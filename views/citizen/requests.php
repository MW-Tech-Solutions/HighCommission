<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold text-emerald-dark mb-0" style="font-family: 'Playfair Display', serif;">My Consular Cases & Enquiries</h2>
        <a href="<?= Helper::baseUrl('contact') ?>" class="btn btn-emerald btn-sm"><i class="bi bi-plus-lg me-1"></i>New Enquiry</a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th>Reference #</th>
                            <th>Service Category</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Assigned Officer</th>
                            <th>Date Logged</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($requests as $req): ?>
                            <tr>
                                <td><code><?= Helper::sanitize($req['reference_number']) ?></code></td>
                                <td><span class="badge bg-light text-dark border text-uppercase"><?= str_replace('_', ' ', $req['service_type']) ?></span></td>
                                <td class="fw-semibold text-dark"><?= Helper::sanitize($req['subject']) ?></td>
                                <td><?= Helper::statusBadge($req['status']) ?></td>
                                <td class="small text-muted"><?= Helper::sanitize($req['officer_name'] ?? 'Assigned to Duty Desk') ?></td>
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
        </div>
    </div>
</div>
