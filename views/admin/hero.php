<?php
use App\Core\Helper;
?>
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="h3 fw-bold text-heading mb-1">Homepage Hero Slideshow Management</h2>
        <p class="text-muted mb-0">Manage, preview, reorder, and publish dynamic responsive hero slides for the public website.</p>
    </div>
    <div>
        <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#createSlideModal">
            <i class="bi bi-plus-lg me-1"></i> Add New Hero Slide
        </button>
    </div>
</div>

<!-- Slides List Table -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Order</th>
                        <th style="width: 120px;">Preview</th>
                        <th>Slide Details & Content</th>
                        <th>Caption Theme</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($slides)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            No hero slides found. Click "Add New Hero Slide" above to create one.
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($slides as $s): ?>
                        <tr>
                            <td class="ps-3 font-monospace fw-bold text-success fs-5">#<?= $s['display_order'] ?></td>
                            <td>
                                <img src="<?= Helper::baseUrl($s['image_desktop']) ?>" alt="<?= Helper::sanitize($s['image_alt']) ?>" class="rounded shadow-sm border" style="width: 100px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6"><?= Helper::sanitize($s['heading']) ?></div>
                                <div class="small text-muted text-truncate" style="max-width: 380px;"><?= Helper::sanitize($s['subheading']) ?></div>
                                <div class="small mt-1">
                                    <span class="badge bg-light text-dark border me-1">Alt: <?= Helper::sanitize($s['image_alt']) ?></span>
                                    <?php if (!empty($s['cta_primary_label'])): ?>
                                        <span class="badge bg-success">CTA: <?= Helper::sanitize($s['cta_primary_label']) ?> &rarr; <?= Helper::sanitize($s['cta_primary_url']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $s['caption_theme'] === 'dark_on_light' ? 'bg-light text-dark border' : 'bg-dark text-white' ?>">
                                    <?= $s['caption_theme'] === 'dark_on_light' ? 'Dark on Light' : 'Light on Dark' ?>
                                </span>
                            </td>
                            <td>
                                <form action="<?= Helper::baseUrl('admin/hero') ?>" method="POST" class="d-inline">
                                    <?= Helper::csrfField() ?>
                                    <input type="hidden" name="action" value="toggle">
                                    <input type="hidden" name="slide_id" value="<?= $s['id'] ?>">
                                    <input type="hidden" name="is_enabled" value="<?= $s['is_enabled'] ? 0 : 1 ?>">
                                    <button type="submit" class="btn btn-sm <?= $s['is_enabled'] ? 'btn-success' : 'btn-outline-secondary' ?>">
                                        <i class="bi <?= $s['is_enabled'] ? 'bi-eye-fill me-1' : 'bi-eye-slash-fill me-1' ?>"></i>
                                        <?= $s['is_enabled'] ? 'Published / Enabled' : 'Disabled / Hidden' ?>
                                    </button>
                                </form>
                            </td>
                            <td class="text-end pe-3">
                                <button class="btn btn-sm btn-outline-emerald me-1" data-bs-toggle="modal" data-bs-target="#editSlideModal<?= $s['id'] ?>">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </button>
                                <form action="<?= Helper::baseUrl('admin/hero') ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this hero slide?');">
                                    <?= Helper::csrfField() ?>
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="slide_id" value="<?= $s['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Slide Modal -->
                        <div class="modal fade" id="editSlideModal<?= $s['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="<?= Helper::baseUrl('admin/hero') ?>" method="POST" enctype="multipart/form-data">
                                        <?= Helper::csrfField() ?>
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="slide_id" value="<?= $s['id'] ?>">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Edit Hero Slide #<?= $s['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <label class="form-label fw-bold">Headline Title</label>
                                                    <input type="text" name="heading" class="form-control" value="<?= Helper::sanitize($s['heading']) ?>" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Display Order</label>
                                                    <input type="number" name="display_order" class="form-control" value="<?= $s['display_order'] ?>" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Subheading / Supporting Copy</label>
                                                    <textarea name="subheading" class="form-control" rows="2"><?= Helper::sanitize($s['subheading']) ?></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Desktop Image Path</label>
                                                    <input type="text" name="image_desktop" class="form-control mb-2" value="<?= Helper::sanitize($s['image_desktop']) ?>" required>
                                                    <input type="file" name="desktop_image_file" class="form-control form-control-sm" accept="image/*">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Mobile Image Path (Optional)</label>
                                                    <input type="text" name="image_mobile" class="form-control" value="<?= Helper::sanitize($s['image_mobile']) ?>">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Image Alt Text (Accessible Description)</label>
                                                    <input type="text" name="image_alt" class="form-control" value="<?= Helper::sanitize($s['image_alt']) ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Primary CTA Label</label>
                                                    <input type="text" name="cta_primary_label" class="form-control" value="<?= Helper::sanitize($s['cta_primary_label']) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Primary CTA Destination URL</label>
                                                    <input type="text" name="cta_primary_url" class="form-control" value="<?= Helper::sanitize($s['cta_primary_url']) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Secondary CTA Label</label>
                                                    <input type="text" name="cta_secondary_label" class="form-control" value="<?= Helper::sanitize($s['cta_secondary_label']) ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold">Secondary CTA Destination URL</label>
                                                    <input type="text" name="cta_secondary_url" class="form-control" value="<?= Helper::sanitize($s['cta_secondary_url']) ?>">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Caption Theme</label>
                                                    <select name="caption_theme" class="form-select">
                                                        <option value="light_on_dark" <?= $s['caption_theme'] === 'light_on_dark' ? 'selected' : '' ?>>Light Text on Dark Surface</option>
                                                        <option value="dark_on_light" <?= $s['caption_theme'] === 'dark_on_light' ? 'selected' : '' ?>>Dark Text on Light Surface</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Text Alignment</label>
                                                    <select name="text_align" class="form-select">
                                                        <option value="left" <?= $s['text_align'] === 'left' ? 'selected' : '' ?>>Left Aligned</option>
                                                        <option value="center" <?= $s['text_align'] === 'center' ? 'selected' : '' ?>>Center Aligned</option>
                                                        <option value="right" <?= $s['text_align'] === 'right' ? 'selected' : '' ?>>Right Aligned</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Visibility State</label>
                                                    <select name="is_enabled" class="form-select">
                                                        <option value="1" <?= $s['is_enabled'] == 1 ? 'selected' : '' ?>>Published / Enabled</option>
                                                        <option value="0" <?= $s['is_enabled'] == 0 ? 'selected' : '' ?>>Disabled / Draft</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success fw-bold">Save Slide Changes</button>
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

<!-- Create Slide Modal -->
<div class="modal fade" id="createSlideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= Helper::baseUrl('admin/hero') ?>" method="POST" enctype="multipart/form-data">
                <?= Helper::csrfField() ?>
                <input type="hidden" name="action" value="create">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-success"><i class="bi bi-plus-circle me-1"></i> Add New Hero Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Headline Title</label>
                            <input type="text" name="heading" class="form-control" placeholder="e.g. Consular Services and Support, Made Easier" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Display Order</label>
                            <input type="number" name="display_order" class="form-control" value="<?= count($slides) + 1 ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Subheading / Supporting Copy</label>
                            <textarea name="subheading" class="form-control" rows="2" placeholder="Serving Nigerian citizens and visitors across Kenya with transparent guidance..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Desktop Image Path / Upload</label>
                            <input type="text" name="image_desktop" class="form-control mb-2" value="assets/images/hero-diplomatic.jpg" required>
                            <input type="file" name="desktop_image_file" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mobile Image Path (Optional)</label>
                            <input type="text" name="image_mobile" class="form-control" placeholder="assets/images/hero-mobile.jpg">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Image Alt Text (Accessible Description)</label>
                            <input type="text" name="image_alt" class="form-control" placeholder="Description of image for screen readers" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Primary CTA Label</label>
                            <input type="text" name="cta_primary_label" class="form-control" placeholder="Find a Service">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Primary CTA Destination URL</label>
                            <input type="text" name="cta_primary_url" class="form-control" placeholder="/services">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Secondary CTA Label</label>
                            <input type="text" name="cta_secondary_label" class="form-control" placeholder="Register as Nigerian">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Secondary CTA Destination URL</label>
                            <input type="text" name="cta_secondary_url" class="form-control" placeholder="/diaspora/register">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Caption Theme</label>
                            <select name="caption_theme" class="form-select">
                                <option value="light_on_dark">Light Text on Dark Surface</option>
                                <option value="dark_on_light">Dark Text on Light Surface</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Text Alignment</label>
                            <select name="text_align" class="form-select">
                                <option value="left">Left Aligned</option>
                                <option value="center">Center Aligned</option>
                                <option value="right">Right Aligned</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Visibility State</label>
                            <select name="is_enabled" class="form-select">
                                <option value="1">Published / Enabled</option>
                                <option value="0">Disabled / Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold">Create & Publish Slide</button>
                </div>
            </form>
        </div>
    </div>
</div>
