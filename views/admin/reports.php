<?php
use App\Core\Helper;
use App\Core\Auth;
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="h3 fw-bold text-heading mb-1">Mission Analytics & Operational Reports</h2>
        <p class="text-muted mb-0">Generate scoped reports for consular workload, diaspora registrations, and appointment metrics.</p>
    </div>
    <div>
        <a href="<?= Helper::baseUrl('admin/export?type=' . urlencode($reportType) . '&format=csv') ?>" class="btn btn-outline-success fw-bold">
            <i class="bi bi-file-earmark-spreadsheet me-2"></i> Export Sanitized CSV
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= Helper::baseUrl('admin/reports') ?>" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Report Type</label>
                <select name="type" class="form-select">
                    <option value="consular_workload" <?= $reportType === 'consular_workload' ? 'selected' : '' ?>>Consular Workload & Cases</option>
                    <option value="diaspora_registry" <?= $reportType === 'diaspora_registry' ? 'selected' : '' ?>>Diaspora Citizen Registrations</option>
                    <option value="appointments_attendance" <?= $reportType === 'appointments_attendance' ? 'selected' : '' ?>>Appointments & Attendance</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= Helper::sanitize($startDate) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?= Helper::sanitize($endDate) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100 fw-bold">
                    <i class="bi bi-filter me-1"></i> Filter Report
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Metric Summary Cards -->
<div class="row g-3 mb-4">
    <?php foreach ($summary as $key => $val): ?>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-white p-3">
            <span class="text-muted small text-uppercase font-monospace fw-bold"><?= str_replace('_', ' ', $key) ?></span>
            <h2 class="display-6 fw-bold text-success mb-0"><?= number_format($val) ?></h2>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title fw-bold mb-0 text-heading">Report Detailed Records (<?= count($reportData) ?> items)</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Reference / ID</th>
                        <th>Name / Applicant</th>
                        <th>Category / Type</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reportData)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No records match the selected date range and report filter.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($reportData as $row): ?>
                        <tr>
                            <td class="ps-3 font-monospace fw-bold">
                                <?= Helper::sanitize($row['reference_number'] ?? $row['registration_number'] ?? $row['voucher_number'] ?? '#' . $row['id']) ?>
                            </td>
                            <td>
                                <?= Helper::sanitize($row['applicant_name'] ?? $row['full_name'] ?? 'N/A') ?>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border"><?= Helper::sanitize($row['service_type'] ?? $row['service_category'] ?? $row['occupation'] ?? 'General') ?></span>
                            </td>
                            <td>
                                <?= Helper::statusBadge($row['status'] ?? 'active') ?>
                            </td>
                            <td class="text-end pe-3 small text-muted">
                                <?= Helper::formatDate($row['created_at'] ?? $row['appointment_date'] ?? null) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
