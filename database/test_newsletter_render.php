<?php
require_once __DIR__ . '/../src/autoload.php';

$controller = new \App\Controllers\NewsletterController();
ob_start();
$controller->index();
$output = ob_get_clean();

echo "Rendered successfully! Page size: " . strlen($output) . " bytes.\n";
