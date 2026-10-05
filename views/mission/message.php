<?php 
use App\Core\Helper; 
use App\Models\SystemSetting;

$hcName = SystemSetting::get('high_commissioner_name', 'H.E. Amb. Danlami Ibrahim');
$hcTitle = SystemSetting::get('high_commissioner_title', 'High Commissioner');
$hcQuote = SystemSetting::get('high_commissioner_quote', 'It is my distinct honor to welcome you to the official digital portal of the High Commission of the Federal Republic of Nigeria in Nairobi, Kenya. Our mission is dedicated to providing efficient, transparent, and dignified consular service to our citizens while fostering economic, cultural, and political partnerships across East Africa.');
$hcPhoto = SystemSetting::getAssetUrl('high_commissioner_photo');
if (empty($hcPhoto)) {
    $hcPhoto = 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80';
}
?>
<!-- DIPLOMATIC HERO HEADER -->
<div class="nhc-page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('/') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= Helper::baseUrl('mission') ?>">The Mission</a></li>
                <li class="breadcrumb-item active" aria-current="page">Message</li>
            </ol>
        </nav>
        <span class="nhc-badge-diplomatic">DIPLOMATIC ADDRESS</span>
        <h1>High Commissioner's Welcome Address</h1>
        <p>Message to Nigerian citizens, host government partners, and global visitors.</p>
    </div>
</div>

<div class="container pb-5">

    <div class="card shadow-sm border-0 rounded-4 p-4 p-md-5 bg-white">
        <div class="row align-items-center g-4">
            <div class="col-md-4 text-center">
                <div class="rounded-4 overflow-hidden shadow border border-emerald border-2">
                    <img src="<?= Helper::sanitize($hcPhoto) ?>" alt="<?= Helper::sanitize($hcName) ?>" class="img-fluid w-100" style="object-fit: cover; max-height: 320px;">
                </div>
            </div>
            <div class="col-md-8">
                <div class="quote-icon text-gold fs-1 mb-2"><i class="bi bi-quote"></i></div>
                <blockquote class="blockquote lead text-dark lh-lg mb-4 fs-5" style="font-family: 'Playfair Display', serif;">
                    <?= Helper::sanitize($hcQuote) ?>
                </blockquote>
                <div class="fw-bold text-emerald-dark fs-5"><?= Helper::sanitize($hcName) ?></div>
                <div class="small text-muted fw-semibold"><?= Helper::sanitize($hcTitle) ?> &bull; High Commission of Nigeria, Nairobi, Kenya</div>
            </div>
        </div>
    </div>
</div>
