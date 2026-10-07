<?php
use App\Core\Helper;

$totalCount = count($users);
$citizenCount = count(array_filter($users, fn($u) => $u['role'] === 'citizen' || $u['role'] === 'public_visitor'));
$staffCount = count(array_filter($users, fn($u) => in_array($u['role'], ['admin', 'officer', 'consular_officer', 'editor', 'publisher', 'supervisor', 'super_admin', 'auditor', 'trade_officer', 'registry_welfare_officer', 'appointment_officer'])));
$suspendedCount = count(array_filter($users, fn($u) => in_array($u['status'], ['suspended', 'pending'])));
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif;">User Account Management</h3>
        <div class="small text-muted">Manage registered citizen portal accounts, applicant profiles, and system access clearances.</div>
    </div>
    <div>
        <button class="btn btn-emerald fw-bold" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="bi bi-person-plus-fill me-1"></i> Create User Account
        </button>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-emerald-subtle text-emerald">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">Total Accounts</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= $totalCount ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-primary-subtle text-primary">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">Citizen Portal Users</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= $citizenCount ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-success-subtle text-success">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">Staff Officers</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= $staffCount ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-danger-subtle text-danger">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">Suspended / Pending</div>
                    <div class="fs-4 fw-bold text-dark mb-0"><?= $suspendedCount ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Nav Pills & Search Bar -->
<div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <ul class="nav nav-pills flex-nowrap overflow-auto pb-1 pb-md-0 gap-2" id="userFilterTabs" style="max-width: 100%;">
                <li class="nav-item">
                    <button type="button" class="nav-link active fw-bold px-3 py-2 text-nowrap small" data-filter="all">
                        All Users <span class="badge bg-white text-dark ms-1"><?= $totalCount ?></span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link fw-bold text-dark px-3 py-2 text-nowrap small" data-filter="citizens">
                        Citizens & Applicants <span class="badge bg-primary text-white ms-1"><?= $citizenCount ?></span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link fw-bold text-dark px-3 py-2 text-nowrap small" data-filter="staff">
                        Staff Officers <span class="badge bg-success text-white ms-1"><?= $staffCount ?></span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link fw-bold text-dark px-3 py-2 text-nowrap small" data-filter="suspended">
                        Suspended / Pending <span class="badge bg-danger text-white ms-1"><?= $suspendedCount ?></span>
                    </button>
                </li>
            </ul>
            <div style="min-width: 260px; max-width: 340px;" class="flex-grow-1 flex-md-grow-0">
                <div class="input-group input-group-sm rounded-pill overflow-hidden border">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="userSearchInput" class="form-control border-0 bg-light" placeholder="Search name, email, NIN, passport...">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User Accounts Table -->
<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-hover align-middle mb-0" id="usersTable" style="min-width: 900px; font-size: 0.88rem;">
                <thead class="table-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="ps-3 py-3" style="width: 80px;">User ID</th>
                        <th class="py-3" style="width: 220px;">Full Name & Contact</th>
                        <th class="py-3" style="width: 180px;">Identities</th>
                        <th class="py-3" style="width: 150px;">Role / Clearance</th>
                        <th class="py-3" style="width: 120px;">Status</th>
                        <th class="py-3" style="width: 130px;">Registered</th>
                        <th class="py-3 text-end pe-3" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No user accounts found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <?php 
                                $isStaff = in_array($u['role'], ['admin', 'officer', 'consular_officer', 'editor', 'publisher', 'supervisor', 'super_admin', 'auditor', 'trade_officer', 'registry_welfare_officer', 'appointment_officer']);
                            ?>
                            <tr class="user-row" 
                                data-role="<?= $isStaff ? 'staff' : 'citizens' ?>" 
                                data-status="<?= Helper::sanitize($u['status']) ?>"
                                data-search="<?= strtolower(Helper::sanitize($u['full_name'] . ' ' . $u['email'] . ' ' . ($u['nin_number'] ?? '') . ' ' . ($u['passport_number'] ?? ''))) ?>">
                                <td class="ps-3 font-monospace fw-bold text-emerald">#<?= $u['id'] ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= Helper::sanitize($u['full_name']) ?></div>
                                    <div class="small text-muted"><?= Helper::sanitize($u['email']) ?></div>
                                    <?php if (!empty($u['phone'])): ?>
                                        <div class="small text-muted"><i class="bi bi-telephone me-1"></i><?= Helper::sanitize($u['phone']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <?php if (!empty($u['nin_number'])): ?>
                                        <div>NIN: <code><?= Helper::sanitize($u['nin_number']) ?></code></div>
                                    <?php endif; ?>
                                    <?php if (!empty($u['passport_number'])): ?>
                                        <div>Passport: <code><?= Helper::sanitize($u['passport_number']) ?></code></div>
                                    <?php endif; ?>
                                    <?php if (empty($u['nin_number']) && empty($u['passport_number'])): ?>
                                        <span class="text-muted opacity-75">No identity linked</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge <?= $isStaff ? 'bg-dark' : 'bg-primary' ?> px-2 py-1">
                                        <?= Helper::sanitize($u['role_name'] ?? ucwords(str_replace('_', ' ', $u['role']))) ?>
                                    </span>
                                </td>
                                <td>
                                    <?= Helper::statusBadge($u['status']) ?>
                                </td>
                                <td class="small text-muted">
                                    <?= Helper::formatDate($u['created_at'], 'd M Y') ?>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <button class="btn btn-sm btn-outline-emerald fw-bold py-1 px-2" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $u['id'] ?>" title="Edit User Clearance">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary py-1 px-2" data-bs-toggle="modal" data-bs-target="#resetPassModal<?= $u['id'] ?>" title="Reset Password">
                                            <i class="bi bi-key"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Edit User Modal -->
                            <div class="modal fade" id="editUserModal<?= $u['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content rounded-4 border-0">
                                        <form action="<?= Helper::baseUrl('admin/users') ?>" method="POST">
                                            <?= Helper::csrfField() ?>
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                            <div class="modal-header bg-emerald text-white rounded-top-4">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-person-gear me-1"></i> Manage User Account #<?= $u['id'] ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">Full Name</label>
                                                        <input type="text" name="full_name" class="form-control" value="<?= Helper::sanitize($u['full_name']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">Email Address</label>
                                                        <input type="email" name="email" class="form-control" value="<?= Helper::sanitize($u['email']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">Phone Number</label>
                                                        <input type="text" name="phone" class="form-control" value="<?= Helper::sanitize($u['phone'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">Assigned Role</label>
                                                        <select name="role" class="form-select" required>
                                                            <?php foreach ($roles as $r): ?>
                                                                <option value="<?= $r['slug'] ?>" <?= $u['role'] === $r['slug'] ? 'selected' : '' ?>>
                                                                    <?= Helper::sanitize($r['name']) ?> (<?= Helper::sanitize($r['slug']) ?>)
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">National Identity Number (NIN)</label>
                                                        <input type="text" name="nin_number" class="form-control" value="<?= Helper::sanitize($u['nin_number'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-bold small">International Passport Number</label>
                                                        <input type="text" name="passport_number" class="form-control" value="<?= Helper::sanitize($u['passport_number'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-bold small">Account Clearance Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="active" <?= $u['status'] === 'active' ? 'selected' : '' ?>>Active / Cleared</option>
                                                            <option value="pending" <?= $u['status'] === 'pending' ? 'selected' : '' ?>>Pending Verification</option>
                                                            <option value="suspended" <?= $u['status'] === 'suspended' ? 'selected' : '' ?>>Suspended / Restricted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-emerald btn-sm fw-bold">Save Account Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reset Password Modal -->
                            <div class="modal fade" id="resetPassModal<?= $u['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content rounded-4 border-0">
                                        <form action="<?= Helper::baseUrl('admin/users') ?>" method="POST">
                                            <?= Helper::csrfField() ?>
                                            <input type="hidden" name="action" value="reset_password">
                                            <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                            <div class="modal-header bg-dark text-white rounded-top-4">
                                                <h5 class="modal-title fw-bold"><i class="bi bi-key-fill me-1"></i> Reset Password for <?= Helper::sanitize($u['full_name']) ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">New Password</label>
                                                    <input type="password" name="password" class="form-control" required minlength="6" placeholder="Enter new password for user">
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-dark btn-sm fw-bold">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0">
            <form action="<?= Helper::baseUrl('admin/users') ?>" method="POST">
                <?= Helper::csrfField() ?>
                <input type="hidden" name="action" value="create">
                <div class="modal-header bg-emerald text-white rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-person-plus-fill me-1"></i> Create New User Account</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Full Name</label>
                            <input type="text" name="full_name" class="form-control" required placeholder="e.g. Chukwudi Okon">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email Address</label>
                            <input type="email" name="email" class="form-control" required placeholder="user@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+254 700 000000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Initial Password</label>
                            <input type="password" name="password" class="form-control" required minlength="6" placeholder="Account password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Account Role</label>
                            <select name="role" class="form-select" required>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['slug'] ?>" <?= $r['slug'] === 'citizen' ? 'selected' : '' ?>>
                                        <?= Helper::sanitize($r['name']) ?> (<?= Helper::sanitize($r['slug']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Clearance Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active / Cleared</option>
                                <option value="pending">Pending Verification</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">NIN Number (Optional)</label>
                            <input type="text" name="nin_number" class="form-control" placeholder="11-digit NIN">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Passport Number (Optional)</label>
                            <input type="text" name="passport_number" class="form-control" placeholder="A00000000">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald btn-sm fw-bold">Create User Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('#userFilterTabs button[data-filter]');
    const rows = document.querySelectorAll('.user-row');
    const searchInput = document.getElementById('userSearchInput');

    let currentFilter = 'all';

    function filterUsers() {
        const query = searchInput.value.toLowerCase().trim();

        rows.forEach(row => {
            const roleCategory = row.getAttribute('data-role');
            const status = row.getAttribute('data-status');
            const searchData = row.getAttribute('data-search');

            let matchesTab = false;
            if (currentFilter === 'all') {
                matchesTab = true;
            } else if (currentFilter === 'citizens') {
                matchesTab = (roleCategory === 'citizens');
            } else if (currentFilter === 'staff') {
                matchesTab = (roleCategory === 'staff');
            } else if (currentFilter === 'suspended') {
                matchesTab = (status === 'suspended' || status === 'pending');
            }

            let matchesSearch = (query === '' || searchData.includes(query));

            if (matchesTab && matchesSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tabButtons.forEach(b => b.classList.remove('active', 'bg-emerald-dark', 'text-white'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            filterUsers();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', filterUsers);
    }
});
</script>
