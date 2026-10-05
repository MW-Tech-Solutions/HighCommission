<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold text-emerald-dark" style="font-family: 'Playfair Display', serif;">Search Published Mission Content</h2>
        <p class="text-muted">Public Search Results for: <strong>"<?= Helper::sanitize($q ?? '') ?>"</strong></p>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white max-w-800 mx-auto">
        <form action="<?= Helper::baseUrl('search') ?>" method="GET" class="mb-4">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control" placeholder="Search passport, visa, registration, advisories..." value="<?= Helper::sanitize($q ?? '') ?>" required>
                <button type="submit" class="btn btn-emerald px-4"><i class="bi bi-search me-1"></i>Search</button>
            </div>
        </form>

        <?php if (!empty($q)): ?>
            <?php if (empty($results)): ?>
                <div class="text-center py-4">
                    <i class="bi bi-search display-4 text-muted d-block mb-3"></i>
                    <h5 class="fw-bold text-dark">No published public content matches your query</h5>
                    <p class="text-muted small">Try searching for keywords like <em>passport, visa, diaspora, advisory, or verification</em>.</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($results as $item): ?>
                    <a href="<?= $item['url'] ?>" class="list-group-item list-group-item-action py-3">
                        <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                            <h5 class="fw-bold text-emerald mb-0"><?= Helper::sanitize($item['title']) ?></h5>
                            <span class="badge bg-light text-dark border"><?= Helper::sanitize($item['category']) ?></span>
                        </div>
                        <p class="text-muted small mb-0"><?= Helper::sanitize($item['snippet']) ?></p>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center text-muted py-4">
                Enter a keyword above to search public consular guidance, published advisories, and official downloads.
            </div>
        <?php endif; ?>
    </div>
</div>
