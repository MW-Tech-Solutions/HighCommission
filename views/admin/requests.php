<?php 
use App\Core\Helper; 

$totalCount = count($requests);
$unassignedCount = count(array_filter($requests, fn($r) => empty($r['assigned_officer_id']) || $r['status'] === 'received'));
$myQueueCount = count(array_filter($requests, fn($r) => !empty($r['assigned_officer_id']) || in_array($r['status'], ['under_review', 'info_needed'])));
$urgentCount = count(array_filter($requests, fn($r) => $r['priority'] === 'urgent' || $r['service_type'] === 'emergency_distress'));
$closedCount = count(array_filter($requests, fn($r) => in_array($r['status'], ['closed', 'rejected', 'approved'])));
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif;">Consular Cases & Emergency Desk Queues</h3>
        <div class="small text-muted">Review incoming requests, assign duty officers, record internal notes, and process applicant cases.</div>
    </div>
</div>

<!-- Queue Filter Nav Tabs -->
<ul class="nav nav-pills mb-3 bg-white p-2 rounded-3 border shadow-sm flex-wrap gap-1" id="queueTabs">
    <li class="nav-item">
        <button type="button" class="nav-link active fw-bold px-3 py-1-5 text-nowrap small" data-filter="all">
            <i class="bi bi-collection me-1"></i>All Cases <span class="badge bg-white text-dark ms-1"><?= $totalCount ?></span>
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link fw-bold text-dark px-3 py-1-5 text-nowrap small" data-filter="unassigned">
            <i class="bi bi-clock-history text-warning me-1"></i>Awaiting Assignment <span class="badge bg-warning text-dark ms-1"><?= $unassignedCount ?></span>
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link fw-bold text-dark px-3 py-1-5 text-nowrap small" data-filter="my-queue">
            <i class="bi bi-briefcase text-emerald me-1"></i>My Work Queue <span class="badge bg-success text-white ms-1"><?= $myQueueCount ?></span>
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link fw-bold text-dark px-3 py-1-5 text-nowrap small" data-filter="urgent">
            <i class="bi bi-exclamation-triangle-fill text-danger me-1"></i>Urgent Emergencies <span class="badge bg-danger text-white ms-1"><?= $urgentCount ?></span>
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link fw-bold text-dark px-3 py-1-5 text-nowrap small" data-filter="closed">
            <i class="bi bi-check-circle-fill text-secondary me-1"></i>Resolved / Closed <span class="badge bg-secondary text-white ms-1"><?= $closedCount ?></span>
        </button>
    </li>
</ul>

<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="requestsTable" style="font-size: 0.86rem;">
                <thead class="table-light small text-uppercase fw-bold text-muted">
                    <tr>
                        <th class="ps-3 py-2 text-nowrap">Reference #</th>
                        <th class="py-2 text-nowrap">Applicant Details</th>
                        <th class="py-2 text-nowrap">Category</th>
                        <th class="py-2">Subject</th>
                        <th class="py-2 text-nowrap">Priority</th>
                        <th class="py-2 text-nowrap">Status</th>
                        <th class="py-2 text-nowrap">Assigned Officer</th>
                        <th class="py-2 text-end pe-3 text-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr id="emptyStateRow">
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                No consular cases recorded in the workspace.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $req): ?>
                            <tr class="request-row"
                                data-status="<?= Helper::sanitize($req['status']) ?>"
                                data-priority="<?= Helper::sanitize($req['priority']) ?>"
                                data-service="<?= Helper::sanitize($req['service_type']) ?>"
                                data-officer="<?= empty($req['assigned_officer_id']) ? 'unassigned' : 'assigned' ?>">
                                <td class="ps-3 text-nowrap">
                                    <span class="badge bg-light text-emerald border border-emerald-subtle font-monospace px-2 py-1" style="font-size: 0.78rem;">
                                        <?= Helper::sanitize($req['reference_number']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark text-nowrap" style="font-size: 0.85rem;"><?= Helper::sanitize($req['applicant_name']) ?></div>
                                    <div class="text-muted text-nowrap" style="font-size: 0.75rem;">
                                        <?= Helper::sanitize($req['applicant_email']) ?>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-light text-dark border text-uppercase px-2 py-1" style="font-size: 0.7rem;">
                                        <?= str_replace('_', ' ', $req['service_type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark text-truncate" style="max-width: 220px; font-size: 0.83rem;"><?= Helper::sanitize($req['subject']) ?></div>
                                </td>
                                <td class="text-nowrap">
                                    <span class="badge bg-<?= $req['priority'] === 'urgent' ? 'danger' : 'secondary' ?> text-uppercase px-2 py-1" style="font-size: 0.68rem;">
                                        <?= $req['priority'] ?>
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <?= Helper::statusBadge($req['status']) ?>
                                </td>
                                <td class="text-nowrap small text-muted">
                                    <?php if (!empty($req['officer_name'])): ?>
                                        <span class="fw-bold text-dark" style="font-size: 0.8rem;"><i class="bi bi-person-check text-emerald me-1"></i><?= Helper::sanitize($req['officer_name']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle" style="font-size: 0.7rem;"><i class="bi bi-person-exclamation me-1"></i>Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-nowrap text-end pe-3">
                                    <div class="d-inline-flex gap-1">
                                        <a href="<?= Helper::baseUrl('admin/requests/view?ref=' . $req['reference_number']) ?>" class="btn btn-emerald btn-sm fw-bold py-1 px-2 text-nowrap" style="font-size: 0.78rem;" title="Open Official Case Workspace & Reply">
                                            Reply / Action <i class="bi bi-chat-dots ms-1"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-secondary btn-sm py-1 px-2" data-bs-toggle="modal" data-bs-target="#statusModal<?= $req['id'] ?>" title="Quick Status Update">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Status Update Modal -->
                            <div class="modal fade" id="statusModal<?= $req['id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0">
                                        <form action="<?= Helper::baseUrl('admin/requests') ?>" method="POST">
                                            <?= Helper::csrfField() ?>
                                            <input type="hidden" name="request_id" value="<?= $req['id'] ?>">
                                            <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                                                <h5 class="modal-title fw-bold" style="font-family: 'Montserrat', sans-serif;">Update Case #<?= Helper::sanitize($req['reference_number']) ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Processing Status</label>
                                                    <select name="status" class="form-select" required>
                                                        <option value="received" <?= $req['status'] === 'received' ? 'selected' : '' ?>>Received</option>
                                                        <option value="under_review" <?= $req['status'] === 'under_review' ? 'selected' : '' ?>>Under Review</option>
                                                        <option value="info_needed" <?= $req['status'] === 'info_needed' ? 'selected' : '' ?>>More Information Requested</option>
                                                        <option value="approved" <?= $req['status'] === 'approved' ? 'selected' : '' ?>>Approved / Processed</option>
                                                        <option value="closed" <?= $req['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                                                        <option value="rejected" <?= $req['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small">Internal Officer Notes (Invisible to Citizen)</label>
                                                    <textarea name="internal_notes" class="form-control" rows="3" placeholder="Add confidential officer remarks or clearance details..."><?= Helper::sanitize($req['internal_notes'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-emerald btn-sm fw-bold">Save Status & Notes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <tr id="noMatchRow" style="display: none;">
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-funnel fs-2 d-block mb-2 text-secondary opacity-50"></i>
                            No consular cases match the selected tab queue filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('#queueTabs button[data-filter]');
    const rows = document.querySelectorAll('.request-row');
    const noMatchRow = document.getElementById('noMatchRow');

    function filterQueue(filterKey) {
        let visibleCount = 0;
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const priority = row.getAttribute('data-priority');
            const service = row.getAttribute('data-service');
            const officer = row.getAttribute('data-officer');

            let show = false;
            if (filterKey === 'all') {
                show = true;
            } else if (filterKey === 'unassigned') {
                show = (officer === 'unassigned' || status === 'received');
            } else if (filterKey === 'my-queue') {
                show = (officer === 'assigned' || status === 'under_review' || status === 'info_needed');
            } else if (filterKey === 'urgent') {
                show = (priority === 'urgent' || service === 'emergency_distress');
            } else if (filterKey === 'closed') {
                show = ['closed', 'rejected', 'approved'].includes(status);
            }

            if (show) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (noMatchRow) {
            noMatchRow.style.display = (visibleCount === 0 && rows.length > 0) ? '' : 'none';
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            tabButtons.forEach(b => {
                b.classList.remove('active', 'bg-emerald-dark', 'text-white');
            });
            this.classList.add('active');
            const filter = this.getAttribute('data-filter');
            filterQueue(filter);
        });
    });
});
</script>
