<?php
use App\Core\Helper;
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="h3 fw-bold text-heading mb-1">User & Staff Role Administration</h2>
        <p class="text-muted mb-0">Configure staff roles, citizen clearances, and dynamic RBAC assignments.</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">User ID</th>
                        <th>Full Name & Email</th>
                        <th>Identities</th>
                        <th>Role / Clearance</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="ps-3 font-monospace">#<?= $u['id'] ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= Helper::sanitize($u['full_name']) ?></div>
                            <div class="small text-muted"><?= Helper::sanitize($u['email']) ?></div>
                        </td>
                        <td class="small">
                            <?php if ($u['nin_number']): ?>
                                <span class="d-block">NIN: <code><?= Helper::sanitize($u['nin_number']) ?></code></span>
                            <?php endif; ?>
                            <?php if ($u['passport_number']): ?>
                                <span class="d-block">Passport: <code><?= Helper::sanitize($u['passport_number']) ?></code></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge bg-dark px-2 py-1"><?= Helper::sanitize($u['role_name'] ?? ucwords(str_replace('_', ' ', $u['role']))) ?></span>
                        </td>
                        <td>
                            <?= Helper::statusBadge($u['status']) ?>
                        </td>
                        <td class="small text-muted">
                            <?= Helper::formatDate($u['created_at'], 'd M Y') ?>
                        </td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $u['id'] ?>">
                                <i class="bi bi-shield-lock me-1"></i> Edit Clearance
                            </button>
                        </td>
                    </tr>

                    <!-- Edit User Clearance Modal -->
                    <div class="modal fade" id="editUserModal<?= $u['id'] ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?= Helper::baseUrl('admin/users') ?>" method="POST">
                                    <?= Helper::csrfField() ?>
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Manage Clearance: <?= Helper::sanitize($u['full_name']) ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Assigned Role</label>
                                            <select name="role" class="form-select">
                                                <?php foreach ($roles as $r): ?>
                                                    <option value="<?= $r['slug'] ?>" <?= $u['role'] === $r['slug'] ? 'selected' : '' ?>>
                                                        <?= Helper::sanitize($r['name']) ?> (<?= Helper::sanitize($r['slug']) ?>)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Account Status</label>
                                            <select name="status" class="form-select">
                                                <option value="active" <?= $u['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                                <option value="pending" <?= $u['status'] === 'pending' ? 'selected' : '' ?>>Pending Verification</option>
                                                <option value="suspended" <?= $u['status'] === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Save Clearance Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
