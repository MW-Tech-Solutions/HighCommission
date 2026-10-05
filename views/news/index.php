<?php use App\Core\Helper; ?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container text-center">
        <nav aria-label="breadcrumb" class="d-inline-block">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Newsroom</li>
            </ol>
        </nav>
        <div><span class="nhc-badge-diplomatic">OFFICIAL NEWSROOM & ADVISORIES</span></div>
        <h1 class="display-6 fw-bold">Diplomatic Bulletins & Press Releases</h1>
        <p class="max-w-700 mx-auto">Official press releases, diplomatic announcements, consular advisories, and national observances from the High Commission of Nigeria in Nairobi.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="row g-4">
        <?php foreach ($notices as $notice): ?>
            <?php 
                $img = !empty($notice['featured_image']) ? (preg_match('#^https?://#i', $notice['featured_image']) ? $notice['featured_image'] : Helper::baseUrl($notice['featured_image'])) : '';
                if (empty($img)) {
                    $cat = strtolower($notice['category'] ?? '');
                    if (str_contains($cat, 'trade') || str_contains($cat, 'business')) {
                        $img = 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=600&q=80';
                    } elseif (str_contains($cat, 'cultural') || str_contains($cat, 'event') || str_contains($cat, 'holiday')) {
                        $img = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80';
                    } else {
                        $img = 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=600&q=80';
                    }
                }
            ?>
            <div class="col-md-6 col-lg-4">
                <div class="nhc-card overflow-hidden h-100 d-flex flex-column bg-white border rounded-4 shadow-sm p-0">
                    <div class="position-relative">
                        <img src="<?= Helper::sanitize($img) ?>" alt="<?= Helper::sanitize($notice['title']) ?>" class="w-100" style="height: 160px; object-fit: cover;">
                        <span class="badge bg-gold text-dark position-absolute top-0 start-0 m-3 fw-bold small"><i class="bi bi-calendar3 me-1"></i><?= Helper::formatDate($notice['published_at'], 'd M Y') ?></span>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <?php if ($notice['is_urgent']): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-1 small fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>Urgent Advisory</span>
                            <?php else: ?>
                                <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle text-capitalize rounded-pill px-3 py-1 small fw-semibold"><?= str_replace('_', ' ', $notice['category']) ?></span>
                            <?php endif; ?>
                        </div>
                        <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);"><?= Helper::sanitize($notice['title']) ?></h5>
                        <p class="text-muted small flex-grow-1 lh-base"><?= Helper::sanitize(substr(strip_tags($notice['content']), 0, 140)) ?>...</p>
                        <a href="<?= Helper::baseUrl('news/view?slug=' . $notice['slug']) ?>" class="btn btn-emerald btn-sm w-100 mt-3 fw-bold">
                            Read Full Article <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
