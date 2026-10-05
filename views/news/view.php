<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-800 mx-auto">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('news') ?>">Newsroom</a></li>
                <li class="breadcrumb-item active" aria-current="page">Article</li>
            </ol>
        </nav>

        <div class="mb-3">
            <?php if ($notice['is_urgent']): ?>
                <span class="badge bg-danger text-white me-2 fs-6"><i class="bi bi-exclamation-triangle-fill me-1"></i>Urgent Advisory</span>
            <?php endif; ?>
            <span class="badge bg-emerald text-white text-capitalize fs-6"><?= str_replace('_', ' ', $notice['category']) ?></span>
            <span class="text-muted small ms-2"><i class="bi bi-calendar3 me-1"></i>Published: <?= Helper::formatDate($notice['published_at'], 'F d, Y') ?></span>
        </div>

        <h1 class="fw-bold text-emerald-dark mb-4" style="font-family: 'Playfair Display', serif;"><?= Helper::sanitize($notice['title']) ?></h1>

        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white lead text-dark lh-lg">
            <?= nl2br(Helper::sanitize($notice['content'])) ?>
        </div>

        <div class="mt-4 text-center">
            <a href="<?= Helper::baseUrl('news') ?>" class="btn btn-outline-emerald">
                <i class="bi bi-arrow-left me-1"></i>Back to All News & Notices
            </a>
        </div>
    </div>
</div>
