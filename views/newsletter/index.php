<?php 
use App\Core\Helper; 
?>

<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header bg-emerald-dark text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #002B19 0%, #004D2C 100%);">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>" class="text-gold-light text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Newsletter & Public Advisories</li>
            </ol>
        </nav>
        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(212, 175, 55, 0.15); border: 1px solid #D4AF37;">
            <i class="bi bi-bell-fill text-gold"></i>
            <span class="small fw-bold text-gold text-uppercase tracking-wider">Official Dispatch Service</span>
        </div>
        <h1 class="display-5 fw-bold text-white mb-2" style="font-family: 'Playfair Display', serif;">
            High Commission Advisory Network
        </h1>
        <p class="lead text-white-80 max-w-700">
            Subscribe to receive direct diplomatic dispatches, public advisories, consular schedule updates, and bilateral economic reports in your inbox.
        </p>
    </div>
</div>

<div class="container py-5">
    

    <div class="row g-5">
        
        <!-- Left Column: Subscription Form Card -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="card-header bg-emerald text-white p-4 p-md-5 position-relative" style="background: linear-gradient(135deg, #004D2C 0%, #008751 100%); border-bottom: 4px solid #D4AF37;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white text-emerald rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 54px; height: 54px; font-size: 1.6rem;">
                            <i class="bi bi-envelope-paper-heart-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1 text-white" style="font-family: 'Montserrat', sans-serif;">Subscribe to Official Dispatches</h4>
                            <p class="small text-white-80 mb-0">Direct, verified communications from the Federal Republic of Nigeria in Nairobi.</p>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="<?= Helper::baseUrl('newsletter/subscribe') ?>" method="POST" id="newsletterPageForm">
                        <input type="hidden" name="csrf_token" value="<?= Helper::csrfToken() ?>">
                        
                        <div class="mb-4">
                            <label for="newsletter_full_name" class="form-label fw-bold text-dark">Full Name <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-emerald"><i class="bi bi-person"></i></span>
                                <input type="text" name="full_name" id="newsletter_full_name" class="form-control form-control-lg" placeholder="e.g. Dr. Olusegun Adebayo">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="newsletter_email" class="form-label fw-bold text-dark">Official Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-emerald"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="newsletter_email" class="form-control form-control-lg" placeholder="your.name@example.com" required>
                            </div>
                            <div class="form-text mt-2">
                                <i class="bi bi-shield-check text-success me-1"></i> Your privacy is protected. Unsubscribe at any time with a single click.
                            </div>
                        </div>

                        <div class="mb-4 bg-light rounded-3 p-3 border">
                            <div class="fw-bold text-dark mb-2 small"><i class="bi bi-check2-square text-emerald me-1"></i> Standard Email Dispatch Topics Included:</div>
                            <div class="row g-2 small text-muted">
                                <div class="col-sm-6"><i class="bi bi-check-circle-fill text-success me-1"></i> Public Advisories & Scam Warnings</div>
                                <div class="col-sm-6"><i class="bi bi-check-circle-fill text-success me-1"></i> Holiday Closures & Consular Hours</div>
                                <div class="col-sm-6"><i class="bi bi-check-circle-fill text-success me-1"></i> Nigeria-Kenya Trade & Investments</div>
                                <div class="col-sm-6"><i class="bi bi-check-circle-fill text-success me-1"></i> Diaspora Community Events</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-emerald btn-lg w-100 fw-bold py-3 shadow-sm rounded-3">
                            <i class="bi bi-send-fill me-2"></i> Complete Newsletter Subscription
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column: Information & Recent Dispatches -->
        <div class="col-lg-5">
            <div class="d-flex flex-column gap-4">
                
                <!-- Trust & Verification Card -->
                <div class="card border rounded-4 p-4 shadow-sm bg-white border-top-emerald">
                    <h5 class="fw-bold text-emerald-dark mb-3">Why Subscribe?</h5>
                    
                    <div class="d-flex gap-3 mb-3">
                        <div class="text-gold fs-3"><i class="bi bi-shield-lock"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Official Direct Source</h6>
                            <p class="small text-muted mb-0">Eliminate third-party rumors. Receive authenticated advisories issued directly under seal by the High Commission.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="text-gold fs-3"><i class="bi bi-calendar2-event"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Consular Calendar Updates</h6>
                            <p class="small text-muted mb-0">Timely notices on public holiday closures in both Nigeria and Kenya to plan your visits smoothly.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="text-gold fs-3"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1 text-dark">Economic & AfCFTA Opportunities</h6>
                            <p class="small text-muted mb-0">Key trade matchmaking briefings, bilateral business forums, and investment opportunities in East Africa.</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Dispatches Preview -->
                <div class="card border rounded-4 p-4 shadow-sm bg-white">
                    <h6 class="fw-bold text-dark text-uppercase tracking-wider mb-3" style="font-size: 0.85rem;">
                        <i class="bi bi-journal-text me-2 text-emerald"></i> Recent Public Notices
                    </h6>
                    
                    <?php if (!empty($recentNotices)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentNotices as $notice): ?>
                                <a href="<?= Helper::baseUrl('news/view?id=' . $notice['id']) ?>" class="list-group-item list-group-item-action px-0 py-2.5 border-bottom">
                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                        <span class="badge bg-emerald-subtle text-emerald fw-bold rounded-pill" style="font-size: 0.7rem;">
                                            <?= Helper::sanitize($notice['category'] ?? 'Notice') ?>
                                        </span>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <?= date('M d, Y', strtotime($notice['published_at'])) ?>
                                        </small>
                                    </div>
                                    <h6 class="mb-1 text-dark fw-bold small lh-base"><?= Helper::sanitize($notice['title']) ?></h6>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="small text-muted mb-0">No public notices published recently.</p>
                    <?php endif; ?>

                    <div class="mt-3 text-center">
                        <a href="<?= Helper::baseUrl('news') ?>" class="btn btn-outline-emerald btn-sm rounded-pill px-3 fw-semibold">
                            View All News & Advisories &rarr;
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
