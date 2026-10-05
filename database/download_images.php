<?php

$url = "https://nigeriankenya.or.ke/";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
$html = curl_exec($ch);
curl_close($ch);

if (!$html) {
    echo "Failed to fetch HTML from {$url}\n";
    exit(1);
}

echo "Fetched HTML successfully (" . strlen($html) . " bytes).\n";

$dom = new DOMDocument();
@$dom->loadHTML($html);

$images = [];

// 1. Extract <img> tags
$imgTags = $dom->getElementsByTagName('img');
foreach ($imgTags as $img) {
    $src = $img->getAttribute('src');
    if ($src) {
        $images[] = $src;
    }
}

// 2. Extract CSS background images and links
preg_match_all('/url\((["\']?)([^"\')]+)\1\)/i', $html, $bgMatches);
if (!empty($bgMatches[2])) {
    foreach ($bgMatches[2] as $bgSrc) {
        $images[] = $bgSrc;
    }
}

// 3. Extract hrefs ending in image extensions
preg_match_all('/href=["\']([^"\']+\.(?:png|jpg|jpeg|webp|gif|svg))["\']/i', $html, $hrefMatches);
if (!empty($hrefMatches[1])) {
    foreach ($hrefMatches[1] as $hrefSrc) {
        $images[] = $hrefSrc;
    }
}

$images = array_unique($images);
echo "Found " . count($images) . " unique image references.\n";

$targetDir = __DIR__ . '/../public/assets/images/hero';
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$downloaded = 0;
foreach ($images as $imgUrl) {
    if (strpos($imgUrl, 'data:image') === 0) continue;

    // Make absolute URL
    if (preg_match('#^https?://#i', $imgUrl)) {
        $absUrl = $imgUrl;
    } elseif (strpos($imgUrl, '/') === 0) {
        $absUrl = "https://nigeriankenya.or.ke" . $imgUrl;
    } else {
        $absUrl = "https://nigeriankenya.or.ke/" . $imgUrl;
    }

    $fileName = basename(parse_url($absUrl, PHP_URL_PATH));
    if (empty($fileName) || !preg_match('/\.(png|jpg|jpeg|webp|gif|svg|ico)$/i', $fileName)) {
        continue;
    }

    $savePath = $targetDir . '/' . $fileName;

    echo "Downloading {$absUrl} -> {$fileName}... ";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $absUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64)");
    $imgData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200 && !empty($imgData)) {
        file_put_contents($savePath, $imgData);
        echo "OK (" . round(strlen($imgData)/1024, 1) . " KB)\n";
        $downloaded++;
    } else {
        echo "FAILED (HTTP {$httpCode})\n";
    }
}

echo "Successfully downloaded {$downloaded} images to public/assets/images/hero/\n";
