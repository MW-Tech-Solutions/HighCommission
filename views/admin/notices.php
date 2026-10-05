<?php use App\Core\Helper; ?>
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h3 class="fw-bold text-dark mb-0" style="font-family: 'Playfair Display', serif;">CMS Newsroom & Public Advisories Management</h3>
        <div class="small text-muted">Publish press releases, official notices, event announcements, and urgent advisories with custom images.</div>
    </div>
    <button type="button" class="btn btn-emerald btn-sm" data-bs-toggle="modal" data-bs-target="#createNoticeModal">
        <i class="bi bi-plus-lg me-1"></i>Publish New Notice / Event
    </button>
</div>

<!-- Modal: Publish New Notice -->
<div class="modal fade" id="createNoticeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <form action="<?= Helper::baseUrl('admin/notices') ?>" method="POST" enctype="multipart/form-data">
                <?= Helper::csrfField() ?>
                <input type="hidden" name="action" value="create">
                <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                    <h5 class="modal-title fw-bold" style="font-family: 'Playfair Display', serif;">Publish Diplomatic Communique / Notice</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Notice Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. PUBLIC ADVISORY: Official Payment Policy">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="public_advisory">Public Advisory</option>
                                <option value="holiday_announcement">Holiday Announcement</option>
                                <option value="diplomatic_news">Diplomatic News</option>
                                <option value="press_release">Press Release</option>
                                <option value="consular_update">Consular Service Update</option>
                                <option value="event">Official Event</option>
                                <option value="trade">Trade & Business Event</option>
                                <option value="cultural_event">Cultural Festival / Event</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Flag Urgent?</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_urgent" value="1" id="urgentSwitch">
                                <label class="form-check-input-label small text-danger fw-bold" for="urgentSwitch">Urgent Banner</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Publish Immediately?</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="publishSwitch" checked>
                                <label class="form-check-input-label small text-success fw-bold" for="publishSwitch">Live on Site</label>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image Upload & URL -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Upload Featured Image Asset</label>
                            <input type="file" name="featured_image" class="form-control form-control-sm" accept="image/*">
                            <div class="form-text extra-small">Upload image file (JPG, PNG, WEBP, SVG). Max 5MB.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Or External Image URL</label>
                            <input type="url" name="featured_image_url" class="form-control form-control-sm" placeholder="https://images.unsplash.com/photo-...">
                            <div class="form-text extra-small">Direct image link (optional if file is uploaded).</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Full Content Body</label>
                        <textarea name="content" class="form-control" rows="5" required placeholder="Write the full announcement text..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-emerald btn-sm fw-bold">Publish to Website</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light small">
                    <tr>
                        <th>ID</th>
                        <th>Preview Image</th>
                        <th>Title & Slug</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notices as $n): ?>
                        <?php 
                            $img = !empty($n['featured_image']) ? (preg_match('#^https?://#i', $n['featured_image']) ? $n['featured_image'] : Helper::baseUrl($n['featured_image'])) : '';
                        ?>
                        <tr>
                            <td>#<?= $n['id'] ?></td>
                            <td style="width: 80px;">
                                <?php if (!empty($img)): ?>
                                    <img src="<?= Helper::sanitize($img) ?>" alt="Notice Image" style="width: 64px; height: 44px; object-fit: cover; border-radius: 6px;" class="border">
                                <?php else: ?>
                                    <div class="badge bg-light text-muted border p-2" style="font-size: 0.75rem;"><i class="bi bi-image"></i> Default</div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= Helper::sanitize($n['title']) ?></div>
                                <div class="small text-muted font-monospace"><?= Helper::sanitize($n['slug']) ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border text-capitalize"><?= str_replace('_', ' ', $n['category']) ?></span></td>
                            <td>
                                <?php if ($n['is_urgent']): ?>
                                    <span class="badge bg-danger">Urgent Banner</span>
                                <?php elseif ($n['is_published']): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="small text-muted"><?= Helper::sanitize($n['author_name'] ?? 'Editor Desk') ?></td>
                            <td class="small text-muted"><?= Helper::formatDate($n['published_at'], 'd M Y') ?></td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-emerald btn-sm" data-bs-toggle="modal" data-bs-target="#editNoticeModal<?= $n['id'] ?>">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </button>
                                    <form action="<?= Helper::baseUrl('admin/notices') ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this notice?');" class="d-inline">
                                        <?= Helper::csrfField() ?>
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="notice_id" value="<?= $n['id'] ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal: Edit Notice -->
                        <div class="modal fade" id="editNoticeModal<?= $n['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content rounded-4 border-0">
                                    <form action="<?= Helper::baseUrl('admin/notices') ?>" method="POST" enctype="multipart/form-data">
                                        <?= Helper::csrfField() ?>
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="notice_id" value="<?= $n['id'] ?>">
                                        
                                        <div class="modal-header bg-emerald-dark text-white rounded-top-4">
                                            <h5 class="modal-title fw-bold" style="font-family: 'Playfair Display', serif;">Edit Notice #<?= $n['id'] ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Notice Title</label>
                                                <input type="text" name="title" class="form-control" value="<?= Helper::sanitize($n['title']) ?>" required>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Category</label>
                                                    <select name="category" class="form-select" required>
                                                        <option value="public_advisory" <?= $n['category'] === 'public_advisory' ? 'selected' : '' ?>>Public Advisory</option>
                                                        <option value="holiday_announcement" <?= $n['category'] === 'holiday_announcement' ? 'selected' : '' ?>>Holiday Announcement</option>
                                                        <option value="diplomatic_news" <?= $n['category'] === 'diplomatic_news' ? 'selected' : '' ?>>Diplomatic News</option>
                                                        <option value="press_release" <?= $n['category'] === 'press_release' ? 'selected' : '' ?>>Press Release</option>
                                                        <option value="consular_update" <?= $n['category'] === 'consular_update' ? 'selected' : '' ?>>Consular Service Update</option>
                                                        <option value="event" <?= $n['category'] === 'event' ? 'selected' : '' ?>>Official Event</option>
                                                        <option value="trade" <?= $n['category'] === 'trade' ? 'selected' : '' ?>>Trade & Business Event</option>
                                                        <option value="cultural_event" <?= $n['category'] === 'cultural_event' ? 'selected' : '' ?>>Cultural Festival / Event</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold small">Flag Urgent?</label>
                                                    <div class="form-check form-switch mt-2">
                                                        <input class="form-check-input" type="checkbox" name="is_urgent" value="1" id="urgentSwitchEdit<?= $n['id'] ?>" <?= $n['is_urgent'] ? 'checked' : '' ?>>
                                                        <label class="form-check-input-label small text-danger fw-bold" for="urgentSwitchEdit<?= $n['id'] ?>">Urgent Banner</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-bold small">Live on Site?</label>
                                                    <div class="form-check form-switch mt-2">
                                                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="publishSwitchEdit<?= $n['id'] ?>" <?= $n['is_published'] ? 'checked' : '' ?>>
                                                        <label class="form-check-input-label small text-success fw-bold" for="publishSwitchEdit<?= $n['id'] ?>">Published</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Upload New Image Asset (Optional)</label>
                                                    <input type="file" name="featured_image" class="form-control form-control-sm" accept="image/*">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold small">Or External Image URL</label>
                                                    <input type="url" name="featured_image_url" class="form-control form-control-sm" value="<?= Helper::sanitize($n['featured_image']) ?>" placeholder="https://...">
                                                </div>
                                            </div>

                                            <?php if (!empty($n['featured_image'])): ?>
                                                <div class="p-2 border rounded bg-light mb-3 d-flex align-items-center gap-3">
                                                    <img src="<?= Helper::sanitize($img) ?>" alt="Current Image" style="height: 50px; width: 80px; object-fit: cover; border-radius: 6px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="delete_featured_image" value="1" id="del_img_<?= $n['id'] ?>">
                                                        <label class="form-check-label text-danger small fw-bold" for="del_img_<?= $n['id'] ?>">Remove featured image</label>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold small">Full Content Body</label>
                                                <textarea name="content" class="form-control" rows="5" required><?= Helper::sanitize($n['content']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light rounded-bottom-4">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-emerald btn-sm fw-bold">Save Changes</button>
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
