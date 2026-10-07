<?php
use App\Core\Helper;
?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif;">Staff Roles & Permissions Governance</h3>
        <div class="small text-muted">Manage staff roles, configure role-based access permissions (RBAC), and assign staff officers.</div>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-emerald fw-bold" data-bs-toggle="modal" data-bs-target="#createRoleModal">
            <i class="bi bi-shield-plus me-1"></i> Add Custom Role
        </button>
        <button class="btn btn-emerald fw-bold" data-bs-toggle="modal" data-bs-target="#createStaffModal">
            <i class="bi bi-person-plus-fill me-1"></i> Register Staff Officer
        </button>
    </div>
</div>

<!-- Role Stats Overview -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-emerald-subtle text-emerald">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Defined Roles</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= count($roles) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-primary-subtle text-primary">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Active Staff Officers</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= count($staffUsers) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-warning-subtle text-warning-emphasis">
                    <i class="bi bi-key-fill"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">System Permissions</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= count($allPermissions) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Roles Table / Cards -->
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-list-stars me-2 text-emerald"></i>System Roles & Access Matrix</h5>
        <span class="badge bg-light text-dark border">RBAC Configured</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-hover align-middle mb-0" style="min-width: 900px; font-size: 0.88rem;">
                <thead class="table-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="ps-3 py-3" style="width: 200px;">Role Name</th>
                        <th class="py-3" style="width: 130px;">Slug</th>
                        <th class="py-3">Description & Scope</th>
                        <th class="py-3 text-center" style="width: 110px;">Staff Count</th>
                        <th class="py-3" style="width: 280px;">Assigned Permissions</th>
                        <th class="py-3 text-end pe-3" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $r): ?>
                        <tr>
                            <td class="ps-3">
                                <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($r['name']) ?></div>
                                <?php if ($r['is_system']): ?>
                                    <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">System Role</span>
                                <?php else: ?>
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle" style="font-size: 0.68rem;">Custom Role</span>
                                <?php endif; ?>
                            </td>
                            <td><code class="text-emerald fw-bold"><?= Helper::sanitize($r['slug']) ?></code></td>
                            <td class="small text-secondary">
                                <?= Helper::sanitize($r['description']) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light text-dark border px-3 py-1 fw-bold fs-6">
                                    <?= $r['user_count'] ?? 0 ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1" style="max-height: 70px; overflow-y: auto;">
                                    <?php if (empty($r['permissions'])): ?>
                                        <span class="badge bg-light text-muted border">No special permissions</span>
                                    <?php else: ?>
                                        <?php foreach (array_slice($r['permissions'], 0, 5) as $perm): ?>
                                            <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle" style="font-size: 0.7rem;">
                                                <?= Helper::sanitize($perm['name']) ?>
                                            </span>
                                        <?php endforeach; ?>
                                        <?php if (count($r['permissions']) > 5): ?>
                                            <span class="badge bg-secondary text-white" style="font-size: 0.68rem;">
                                                +<?= count($r['permissions']) - 5 ?> more
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-end pe-3">
                                <button type="button" class="btn btn-outline-emerald btn-sm fw-bold py-1 px-2" data-bs-toggle="modal" data-bs-target="#editRolePermModal<?= $r['id'] ?>" title="Manage Permissions">
                                    <i class="bi bi-shield-lock me-1"></i> Permissions
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Role Permissions Modal -->
                        <div class="modal fade" id="editRolePermModal<?= $r['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content rounded-4 border-0">
                                    <form action="<?= Helper::baseUrl('admin/roles') ?>" method="POST">
                                        <?= Helper::csrfField() ?>
                                        <input type="hidden" name="action" value="update_permissions">
                                        <input type="hidden" name="role_id" value="<?= $r['id'] ?>">
                                        <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-shield-lock me-1"></i> Permissions Matrix: <?= Helper::sanitize($r['name']) ?>
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="small text-muted mb-3">
                                                Select permissions to assign to role <strong><?= Helper::sanitize($r['name']) ?></strong> (<code><?= Helper::sanitize($r['slug']) ?></code>).
                                            </p>
                                            <?php 
                                                $assignedPermIds = array_column($r['permissions'] ?? [], 'id');
                                                $grouped = [];
                                                foreach ($allPermissions as $p) {
                                                    $grouped[$p['module']][] = $p;
                                                }
                                            ?>
                                            <?php foreach ($grouped as $module => $perms): ?>
                                                <div class="card border mb-3 rounded-3">
                                                    <div class="card-header bg-light py-2 px-3 fw-bold text-uppercase small text-emerald-dark">
                                                        <i class="bi bi-folder2-open me-1"></i> Module: <?= Helper::sanitize($module) ?>
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <div class="row g-2">
                                                            <?php foreach ($perms as $p): ?>
                                                                <div class="col-md-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="<?= $p['id'] ?>" id="perm_<?= $r['id'] ?>_<?= $p['id'] ?>" <?= in_array($p['id'], $assignedPermIds) ? 'checked' : '' ?>>
                                                                        <label class="form-check-label small" for="perm_<?= $r['id'] ?>_<?= $p['id'] ?>">
                                                                            <span class="fw-bold text-dark d-block"><?= Helper::sanitize($p['name']) ?></span>
                                                                            <span class="text-muted" style="font-size: 0.74rem;"><?= Helper::sanitize($p['description']) ?></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="modal-footer bg-light rounded-bottom-4">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-emerald btn-sm fw-bold">Save Role Permissions</button>
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

<!-- Active Staff Officers List -->
<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-people me-2 text-emerald"></i>Assigned Staff Officers</h5>
        <span class="badge bg-emerald text-white"><?= count($staffUsers) ?> Active Officers</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-hover align-middle mb-0" style="min-width: 800px; font-size: 0.88rem;">
                <thead class="table-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="ps-3 py-3">Staff Name</th>
                        <th class="py-3">Email Address</th>
                        <th class="py-3">Assigned Role</th>
                        <th class="py-3">Account Status</th>
                        <th class="py-3">Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($staffUsers)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No staff officers assigned. Use "Register Staff Officer" button above to add team members.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($staffUsers as $su): ?>
                            <tr>
                                <td class="ps-3 fw-bold text-dark">
                                    <i class="bi bi-person-badge text-emerald me-2"></i><?= Helper::sanitize($su['full_name']) ?>
                                </td>
                                <td><?= Helper::sanitize($su['email']) ?></td>
                                <td>
                                    <span class="badge bg-dark px-2 py-1"><?= Helper::sanitize($su['role_name'] ?? ucwords(str_replace('_', ' ', $su['role']))) ?></span>
                                </td>
                                <td><?= Helper::statusBadge($su['status']) ?></td>
                                <td class="small text-muted"><?= Helper::formatDate($su['created_at'], 'd M Y') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Staff Modal -->
<div class="modal fade" id="createStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <form action="<?= Helper::baseUrl('admin/roles') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <input type="hidden" name="action" value="create_staff">
                <div class="modal-header bg-emerald text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-1"></i> Register New Staff Officer</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required placeholder="e.g. Inspector Grace Ojo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email Address</label>
                        <input type="email" name="email" class="form-control" required placeholder="staff.name@highcommission.gov.ng">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Phone Number (Optional)</label>
                        <input type="text" name="phone" class="form-control" placeholder="+254 700 000000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Initial Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6" placeholder="Set temporary staff password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Staff Role Assignment</label>
                        <select name="role" class="form-select" required>
                            <?php foreach ($roles as $r): ?>
                                <?php if ($r['slug'] !== 'citizen' && $r['slug'] !== 'public_visitor'): ?>
                                    <option value="<?= $r['slug'] ?>"><?= Helper::sanitize($r['name']) ?> (<?= Helper::sanitize($r['slug']) ?>)</option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald btn-sm fw-bold">Register Staff Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <form action="<?= Helper::baseUrl('admin/roles') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <input type="hidden" name="action" value="create_role">
                <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-shield-plus me-1"></i> Add Custom Staff Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Role Title / Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Senior Protocol Officer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Role Slug Identifier</label>
                        <input type="text" name="slug" class="form-control" required placeholder="e.g. protocol_officer">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Role Description & Scope</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Briefly describe what this role is authorized to process..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald btn-sm fw-bold">Create Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
