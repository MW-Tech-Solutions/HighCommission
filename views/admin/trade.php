<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">Trade & Investment Matchmaking Submissions</h3>
        <div class="small text-muted">Review corporate enquiries from Kenyan and Nigerian economic partners.</div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>Ref Code</th>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Origin & Sector</th>
                        <th>Business Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $sub): ?>
                        <tr>
                            <td><code><?= Helper::sanitize($sub['reference_code']) ?></code></td>
                            <td class="fw-bold text-dark"><?= Helper::sanitize($sub['company_name']) ?></td>
                            <td>
                                <div><?= Helper::sanitize($sub['contact_person']) ?></div>
                                <div class="small text-muted"><?= Helper::sanitize($sub['email']) ?> | <?= Helper::sanitize($sub['phone']) ?></div>
                            </td>
                            <td>
                                <span class="badge bg-gold text-dark me-1"><?= Helper::sanitize($sub['country_origin']) ?></span>
                                <span class="badge bg-light text-dark border"><?= Helper::sanitize($sub['sector']) ?></span>
                            </td>
                            <td class="small text-secondary max-w-300"><?= Helper::sanitize($sub['business_description']) ?></td>
                            <td class="small text-muted"><?= Helper::formatDate($sub['created_at'], 'd M Y') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
