<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Diaspora Citizens Registry Management</h3>
        <div class="small text-muted">Review online registration records of Nigerian residents in Kenya, Somalia, and Seychelles.</div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <table class="table table-hover align-middle mb-0" style="min-width: 900px;">
                <thead class="table-light small">
                    <tr>
                        <th>Reg Number</th>
                        <th>Citizen Name</th>
                        <th>Passport & NIN</th>
                        <th>Kenya Address & County</th>
                        <th>Occupation / State</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citizens as $cit): ?>
                        <tr>
                            <td><code><?= Helper::sanitize($cit['registration_number']) ?></code></td>
                            <td>
                                <div class="fw-bold text-dark"><?= Helper::sanitize($cit['full_name']) ?></div>
                                <div class="small text-muted">Gender: <?= ucfirst($cit['gender']) ?></div>
                            </td>
                            <td>
                                <div>Pass: <code><?= Helper::sanitize($cit['passport_number']) ?></code></div>
                                <div class="small text-muted">NIN: <?= Helper::sanitize($cit['nin'] ?? 'N/A') ?></div>
                            </td>
                            <td>
                                <div><?= Helper::sanitize($cit['kenya_address']) ?></div>
                                <div class="small text-emerald fw-semibold"><?= Helper::sanitize($cit['kenya_county']) ?> County</div>
                            </td>
                            <td>
                                <div><?= Helper::sanitize($cit['occupation']) ?></div>
                                <div class="small text-muted"><?= Helper::sanitize($cit['state_of_origin']) ?> State</div>
                            </td>
                            <td><?= Helper::statusBadge($cit['status']) ?></td>
                            <td>
                                <form action="<?= Helper::baseUrl('admin/citizens') ?>" method="POST" class="d-inline">
                                    <?= Helper::csrfField() ?>
                                    <input type="hidden" name="citizen_id" value="<?= $cit['id'] ?>">
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="submitted" <?= $cit['status'] === 'submitted' ? 'selected' : '' ?>>Submitted</option>
                                        <option value="verified" <?= $cit['status'] === 'verified' ? 'selected' : '' ?>>Verified & Approved</option>
                                        <option value="flagged" <?= $cit['status'] === 'flagged' ? 'selected' : '' ?>>Flagged / Under Review</option>
                                        <option value="rejected" <?= $cit['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
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
