<?php use App\Core\Helper; ?>

<div class="mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-1">
            <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('admin/dashboard') ?>" class="text-decoration-none text-emerald"><i class="bi bi-speedometer2 me-1"></i>Workspace</a></li>
            <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('admin/requests') ?>" class="text-decoration-none text-emerald">Consular Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= Helper::sanitize($req['reference_number']) ?></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h3 class="fw-bold text-dark mb-0" style="font-family: 'Montserrat', sans-serif;">
                Case #<?= Helper::sanitize($req['reference_number']) ?>
            </h3>
            <div class="small text-muted">
                Submitted by <strong class="text-dark"><?= Helper::sanitize($req['applicant_name']) ?></strong> on <?= Helper::formatDate($req['created_at'], 'd M Y, h:i A') ?>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= Helper::baseUrl('admin/requests') ?>" class="btn btn-outline-secondary btn-sm fw-bold">
                <i class="bi bi-arrow-left me-1"></i>Back to Cases Queue
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Main Left Column: Details & Thread -->
    <div class="col-lg-8">
        <!-- Case Summary Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-emerald-dark text-white p-3 rounded-top-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-white" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-file-text me-2 text-gold"></i>Case Particulars</h6>
                <div>
                    <span class="badge bg-light text-dark text-uppercase me-1"><?= str_replace('_', ' ', $req['service_type']) ?></span>
                    <?= Helper::statusBadge($req['status']) ?>
                </div>
            </div>
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3"><?= Helper::sanitize($req['subject']) ?></h5>
                
                <div class="bg-light p-3 rounded-3 border mb-3">
                    <div class="small text-muted fw-bold text-uppercase mb-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">Applicant Description & Enquiries</div>
                    <div class="text-dark" style="white-space: pre-line; line-height: 1.6;"><?= Helper::sanitize($req['details']) ?></div>
                </div>

                <?php if (!empty($req['attached_document'])): ?>
                    <div class="d-flex align-items-center gap-2 p-2 px-3 bg-white border rounded-3 text-emerald">
                        <i class="bi bi-paperclip fs-5"></i>
                        <div class="small flex-grow-1">
                            <strong class="d-block text-dark">Attached Documentation</strong>
                            <a href="<?= Helper::baseUrl($req['attached_document']) ?>" target="_blank" class="text-emerald text-decoration-underline small">Download / View Attachment</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Conversation & Officer Thread -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-dark" style="font-family: 'Montserrat', sans-serif;">
                    <i class="bi bi-chat-left-dots text-emerald me-2"></i>Official Case Communication Thread
                </h6>
                <span class="badge bg-secondary rounded-pill"><?= count($messages) ?> Messages</span>
            </div>
            <div class="card-body p-4" style="background-color: #F8FAFC;">
                <?php if (empty($messages)): ?>
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-chat-square-dots fs-2 text-secondary opacity-50 d-block mb-2"></i>
                        <p class="mb-0 small">No official messages recorded in this case thread yet. Use the reply box below to send instructions or requests to the applicant.</p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3 mb-4">
                        <?php foreach ($messages as $msg): ?>
                            <?php $isStaff = ($msg['sender_type'] === 'staff'); ?>
                            <div class="d-flex <?= $isStaff ? 'justify-content-end' : 'justify-content-start' ?>">
                                <div class="card border-0 shadow-sm rounded-4 p-3" style="max-width: 85%; background-color: <?= $isStaff ? '#004D2C' : '#FFFFFF' ?>; color: <?= $isStaff ? '#FFFFFF' : '#1E293B' ?>;">
                                    <div class="d-flex align-items-center justify-content-between gap-3 border-bottom pb-2 mb-2" style="border-color: <?= $isStaff ? 'rgba(255,255,255,0.2)' : '#E2E8F0' ?> !important;">
                                        <div class="small fw-bold">
                                            <i class="bi bi-<?= $isStaff ? 'shield-check text-gold' : 'person-circle text-emerald' ?> me-1"></i>
                                            <?= Helper::sanitize($msg['sender_name'] ?? ($isStaff ? 'High Commission Duty Officer' : $req['applicant_name'])) ?>
                                        </div>
                                        <div class="small <?= $isStaff ? 'text-white-50' : 'text-muted' ?>" style="font-size: 0.75rem;">
                                            <?= Helper::formatDate($msg['created_at'], 'd M, h:i A') ?>
                                        </div>
                                    </div>
                                    <div style="white-space: pre-line; line-height: 1.5; font-size: 0.92rem;"><?= Helper::sanitize($msg['message']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Staff Reply Form -->
                <div class="bg-white p-3 rounded-4 border shadow-sm mt-3">
                    <form action="<?= Helper::baseUrl('admin/requests/view?ref=' . $req['reference_number']) ?>" method="POST">
                        <?= Helper::csrfField() ?>
                        <input type="hidden" name="action" value="post_message">
                        
                        <label class="form-label fw-bold text-dark small mb-2">
                            <i class="bi bi-reply-fill me-1 text-emerald"></i>Post Official Reply / Officer Directive
                        </label>
                        <textarea name="message" class="form-control mb-3" rows="4" placeholder="Type official response or instructions for applicant..." required></textarea>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-muted d-none d-md-block">
                                <i class="bi bi-info-circle me-1"></i>Messages posted here will be immediately visible on applicant's dashboard thread.
                            </div>
                            <button type="submit" class="btn btn-emerald btn-sm px-4 fw-bold">
                                <i class="bi bi-send-fill me-1"></i>Send Response
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar: Officer Controls & Status -->
    <div class="col-lg-4">
        <!-- Applicant Info Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white p-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-person-badge text-emerald me-2"></i>Applicant Details</h6>
            </div>
            <div class="card-body p-3">
                <div class="mb-3">
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Full Name</div>
                    <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($req['applicant_name']) ?></div>
                </div>
                <div class="mb-3">
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Email Address</div>
                    <div class="text-dark"><a href="mailto:<?= Helper::sanitize($req['applicant_email']) ?>" class="text-decoration-none text-emerald"><?= Helper::sanitize($req['applicant_email']) ?></a></div>
                </div>
                <div class="mb-3">
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Phone Contact</div>
                    <div class="text-dark"><?= Helper::sanitize($req['applicant_phone']) ?></div>
                </div>
                <div>
                    <div class="small text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Assigned Duty Officer</div>
                    <div class="fw-bold text-emerald">
                        <i class="bi bi-person-check me-1"></i><?= Helper::sanitize($req['officer_name'] ?? 'Unassigned') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Case Processing Controls Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white p-3 border-bottom">
                <h6 class="fw-bold mb-0 text-dark" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-sliders text-emerald me-2"></i>Officer Case Management</h6>
            </div>
            <div class="card-body p-3">
                <form action="<?= Helper::baseUrl('admin/requests/view?ref=' . $req['reference_number']) ?>" method="POST">
                    <?= Helper::csrfField() ?>
                    <input type="hidden" name="action" value="update_status">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Processing Status</label>
                        <select name="status" class="form-select form-select-sm" required>
                            <option value="received" <?= $req['status'] === 'received' ? 'selected' : '' ?>>Received</option>
                            <option value="under_review" <?= $req['status'] === 'under_review' ? 'selected' : '' ?>>Under Review</option>
                            <option value="info_needed" <?= $req['status'] === 'info_needed' ? 'selected' : '' ?>>More Info Requested</option>
                            <option value="approved" <?= $req['status'] === 'approved' ? 'selected' : '' ?>>Approved / Processed</option>
                            <option value="closed" <?= $req['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="rejected" <?= $req['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">Internal Officer Notes (Confidential)</label>
                        <textarea name="internal_notes" class="form-control form-control-sm" rows="4" placeholder="Confidential clearance notes, reference numbers, or internal remarks..."><?= Helper::sanitize($req['internal_notes'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-emerald w-100 btn-sm fw-bold">
                        <i class="bi bi-save me-1"></i>Update Processing Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
