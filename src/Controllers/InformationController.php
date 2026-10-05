<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Helper;
use PDO;

class InformationController extends Controller {
    public function search(Request $request): void {
        $q = trim((string)$request->get('q'));
        $results = [];

        if (!empty($q)) {
            $db = \App\Core\Database::getConnection();

            // 1. Search published public notices & advisories ONLY
            $stmt = $db->prepare("
                SELECT id, title, slug, category, content, published_at 
                FROM notices 
                WHERE is_published = 1 AND (title LIKE :q OR content LIKE :q) 
                ORDER BY published_at DESC LIMIT 10
            ");
            $stmt->execute([':q' => "%{$q}%"]);
            $notices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($notices as $n) {
                $results[] = [
                    'title' => $n['title'],
                    'url' => Helper::baseUrl('news/view?slug=' . urlencode($n['slug'])),
                    'category' => 'Public Advisory / News',
                    'snippet' => substr(strip_tags($n['content']), 0, 180) . '...'
                ];
            }

            // 2. Search Static Core Public Service Topics
            $publicTopics = [
                ['title' => 'E-Passport Renewal & Biometrics Guidance', 'url' => Helper::baseUrl('consular/passport'), 'category' => 'Consular Service', 'keywords' => ['passport', 'renewal', 'biometrics', 'nin', 'etc']],
                ['title' => 'Visa Categories, Requirements & Eligibility', 'url' => Helper::baseUrl('consular/visa'), 'category' => 'Consular Service', 'keywords' => ['visa', 'tourist', 'business', 'str', 'twp', 'entry']],
                ['title' => 'Emergency Travel Certificate (ETC) Intake', 'url' => Helper::baseUrl('consular/etc'), 'category' => 'Consular Service', 'keywords' => ['etc', 'emergency', 'travel', 'certificate', 'lost passport']],
                ['title' => 'Document Authentication & Legalization', 'url' => Helper::baseUrl('consular/legalization'), 'category' => 'Consular Service', 'keywords' => ['legalization', 'attestation', 'marriage', 'birth certificate']],
                ['title' => 'Diaspora Citizen Registration Hub', 'url' => Helper::baseUrl('diaspora/register'), 'category' => 'Diaspora Hub', 'keywords' => ['diaspora', 'register', 'citizen', 'registry', 'kenya']],
                ['title' => 'Official Seal & Receipt Authenticator', 'url' => Helper::baseUrl('verify'), 'category' => 'Verification', 'keywords' => ['verify', 'authenticator', 'seal', 'receipt', 'code']],
                ['title' => 'Discover Nigeria & 36 States Map', 'url' => Helper::baseUrl('discover-nigeria'), 'category' => 'Culture & Geography', 'keywords' => ['nigeria', 'states', 'map', 'abuja', 'culture', 'tourism']]
            ];

            foreach ($publicTopics as $topic) {
                foreach ($topic['keywords'] as $kw) {
                    if (stripos($kw, $q) !== false || stripos($topic['title'], $q) !== false) {
                        $results[] = [
                            'title' => $topic['title'],
                            'url' => $topic['url'],
                            'category' => $topic['category'],
                            'snippet' => 'Official public guidance on ' . strtolower($topic['title']) . '.'
                        ];
                        break;
                    }
                }
            }
        }

        $this->render('info/search', ['q' => $q, 'results' => $results]);
    }


    public function fees(Request $request): void {
        $this->render('info/fees');
    }

    public function community(Request $request): void {
        $this->render('info/community');
    }

    public function government(Request $request): void {
        $this->render('info/government');
    }

    public function events(Request $request): void {
        $this->render('info/events');
    }

    public function gallery(Request $request): void {
        $this->render('info/gallery');
    }

    public function downloads(Request $request): void {
        $this->render('info/downloads');
    }

    public function faq(Request $request): void {
        $this->render('info/faq');
    }

    public function feedback(Request $request): void {
        if ($request->getMethod() === 'POST') {
            Helper::setFlash('success', 'Thank you! Your feedback has been submitted to the High Commission quality assurance desk.');
            $this->redirect('feedback');
        }
        $this->render('info/feedback');
    }

    public function officialChannels(Request $request): void {
        $this->render('info/official_channels');
    }

    public function reportSuspicious(Request $request): void {
        if ($request->getMethod() === 'POST') {
            Helper::setFlash('success', 'Thank you! Your report regarding suspicious activity has been lodged with the security team.');
            $this->redirect('report-suspicious');
        }
        $this->render('info/report_suspicious');
    }

    public function privacy(Request $request): void {
        $this->render('info/privacy');
    }

    public function terms(Request $request): void {
        $this->render('info/terms');
    }

    public function accessibility(Request $request): void {
        $this->render('info/accessibility');
    }

    public function cookies(Request $request): void {
        $this->render('info/cookies');
    }

    public function sitemap(Request $request): void {
        $this->render('info/sitemap');
    }

    public function sitemapXml(Request $request): void {
        header('Content-Type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>' . Helper::baseUrl('/') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/services') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/services/passport') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/services/visa') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/verify') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/diaspora') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/trade') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/discover-nigeria') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/news') . '</loc></url>
    <url><loc>' . Helper::baseUrl('/contact') . '</loc></url>
</urlset>';
        exit();
    }

    public function apiSearch(Request $request): void {
        $q = trim((string)$request->get('q'));
        $results = [];

        if (!empty($q)) {
            $db = \App\Core\Database::getConnection();

            // 1. Search published public notices & advisories
            $stmt = $db->prepare("
                SELECT id, title, slug, category, content, published_at 
                FROM notices 
                WHERE is_published = 1 AND (title LIKE :q OR content LIKE :q) 
                ORDER BY published_at DESC LIMIT 5
            ");
            $stmt->execute([':q' => "%{$q}%"]);
            $notices = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($notices as $n) {
                $results[] = [
                    'title' => $n['title'],
                    'url' => Helper::baseUrl('news/view?slug=' . urlencode($n['slug'])),
                    'category' => 'Public Advisory / News',
                    'snippet' => substr(strip_tags($n['content']), 0, 90) . '...'
                ];
            }

            // 2. Search Static Core Public Service Topics & Features
            $publicTopics = [
                ['title' => 'E-Passport Renewal & Biometrics Guidance', 'url' => Helper::baseUrl('consular/passport'), 'category' => 'Consular Service', 'keywords' => ['passport', 'renewal', 'biometrics', 'nin', 'etc', 'epassport']],
                ['title' => 'Visa Categories, Requirements & Eligibility', 'url' => Helper::baseUrl('consular/visa'), 'category' => 'Consular Service', 'keywords' => ['visa', 'tourist', 'business', 'str', 'twp', 'entry', 'visitor']],
                ['title' => 'Emergency Travel Certificate (ETC) Intake', 'url' => Helper::baseUrl('consular/etc'), 'category' => 'Consular Service', 'keywords' => ['etc', 'emergency', 'travel', 'certificate', 'lost passport', 'flight']],
                ['title' => 'Document Authentication & Legalization', 'url' => Helper::baseUrl('consular/legalization'), 'category' => 'Consular Service', 'keywords' => ['legalization', 'attestation', 'marriage', 'birth certificate', 'notary']],
                ['title' => 'Diaspora Citizen Registration Hub', 'url' => Helper::baseUrl('diaspora/register'), 'category' => 'Diaspora Hub', 'keywords' => ['diaspora', 'register', 'citizen', 'registry', 'kenya', 'diaspora hub']],
                ['title' => '24/7 Emergency Distress Assistance', 'url' => Helper::baseUrl('emergency'), 'category' => 'Emergency Desk', 'keywords' => ['emergency', 'distress', 'help', 'urgent', 'police', 'hospital']],
                ['title' => 'Official Seal & Receipt Authenticator', 'url' => Helper::baseUrl('verify'), 'category' => 'Verification', 'keywords' => ['verify', 'authenticator', 'seal', 'receipt', 'code', 'qrcode']],
                ['title' => 'Track Application & Appointment Voucher', 'url' => Helper::baseUrl('track'), 'category' => 'Status Tracker', 'keywords' => ['track', 'status', 'reference', 'voucher', 'appointment']],
                ['title' => 'Bilateral Trade & Investment Enquiries', 'url' => Helper::baseUrl('trade'), 'category' => 'Trade & Business', 'keywords' => ['trade', 'investment', 'business', 'commerce', 'nairobi', 'enquiry']],
                ['title' => 'Discover Nigeria & 36 States Interactive Map', 'url' => Helper::baseUrl('discover-nigeria'), 'category' => 'Culture & Tourism', 'keywords' => ['nigeria', 'states', 'map', 'abuja', 'culture', 'tourism', 'geography']],
                ['title' => 'Contact the Mission & Office Hours', 'url' => Helper::baseUrl('contact'), 'category' => 'Contact', 'keywords' => ['contact', 'address', 'phone', 'email', 'hours', 'location', 'map']]
            ];

            foreach ($publicTopics as $topic) {
                foreach ($topic['keywords'] as $kw) {
                    if (stripos($kw, $q) !== false || stripos($topic['title'], $q) !== false) {
                        $results[] = [
                            'title' => $topic['title'],
                            'url' => $topic['url'],
                            'category' => $topic['category'],
                            'snippet' => 'Official guidance on ' . strtolower($topic['title'])
                        ];
                        break;
                    }
                }
            }
        }

        $this->json($results);
    }
}
