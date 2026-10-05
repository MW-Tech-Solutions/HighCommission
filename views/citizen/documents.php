<?php use App\Core\Helper; ?>
<div class="container py-5">
    <div class="max-w-700 mx-auto">
        <h2 class="fw-bold text-emerald-dark mb-4" style="font-family: 'Playfair Display', serif;">My Submitted Applicant Documents</h2>
        
        <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white mb-4">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-cloud-arrow-up text-emerald me-2"></i>Upload Supporting Document</h5>
            <form action="<?= Helper::baseUrl('portal/documents') ?>" method="POST" enctype="multipart/form-data">
                <?= Helper::csrfField() ?>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Document Title / Category</label>
                    <select name="doc_category" class="form-select" required>
                        <option value="police_abstract">Police Loss Abstract Report</option>
                        <option value="passport_copy">Passport Data Page Photocopy</option>
                        <option value="affidavit">Sworn Affidavit of Loss</option>
                        <option value="attestation_doc">Document for Attestation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small">Select File (PDF / JPG / PNG, Max 5MB)</label>
                    <input type="file" name="document_file" class="form-control" required accept=".pdf,.jpg,.jpeg,.png">
                </div>
                <button type="submit" class="btn btn-emerald fw-bold">Upload to Applicant File</button>
            </form>
        </div>
    </div>
</div>
