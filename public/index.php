<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../src/autoload.php';

use App\Core\Router;
use App\Core\Request;
use App\Controllers\HomeController;
use App\Controllers\ConsularController;
use App\Controllers\ServicesController;
use App\Controllers\AppointmentController;
use App\Controllers\VerificationController;
use App\Controllers\DiasporaController;
use App\Controllers\TradeController;
use App\Controllers\NigeriaController;
use App\Controllers\NewsController;
use App\Controllers\ContactController;
use App\Controllers\CitizenPortalController;
use App\Controllers\AdminController;
use App\Controllers\TrackController;
use App\Controllers\MissionController;
use App\Controllers\InformationController;
use App\Controllers\FileController;
use App\Controllers\HealthController;
use App\Controllers\NewsletterController;

$request = new Request();


$router = new Router();

// Public Homepage
$router->get('/', [HomeController::class, 'index']);

// Consular Services Routes
$router->get('/services', [ServicesController::class, 'index']);
$router->get('/services/passport', [ConsularController::class, 'passport']);
$router->get('/services/visa', [ConsularController::class, 'visa']);
$router->get('/services/emergency-travel', [ConsularController::class, 'etc']);
$router->post('/services/emergency-travel', [ConsularController::class, 'etc']);
$router->get('/services/document-support', [ConsularController::class, 'legalization']);
$router->get('/services/fees', [ServicesController::class, 'fees']);
$router->get('/services/appointments', [ServicesController::class, 'appointments']);

// Consular Short Aliases
$router->get('/consular', [ConsularController::class, 'index']);
$router->get('/consular/passport', [ConsularController::class, 'passport']);
$router->get('/consular/visa', [ConsularController::class, 'visa']);
$router->get('/consular/etc', [ConsularController::class, 'etc']);
$router->post('/consular/etc', [ConsularController::class, 'etc']);
$router->get('/consular/legalization', [ConsularController::class, 'legalization']);

// Appointment Booking & Voucher
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->post('/appointment', [AppointmentController::class, 'index']);
$router->get('/appointment/voucher', [AppointmentController::class, 'voucher']);

// Tracking & Authenticator
$router->get('/track', [TrackController::class, 'index']);
$router->post('/track', [TrackController::class, 'index']);
$router->get('/verify', [VerificationController::class, 'index']);
$router->post('/verify', [VerificationController::class, 'index']);

// Diaspora Citizens Hub & Emergency Distress
$router->get('/diaspora', [DiasporaController::class, 'index']);
$router->get('/diaspora/register', [DiasporaController::class, 'register']);
$router->post('/diaspora/register', [DiasporaController::class, 'register']);
$router->get('/diaspora/emergency', [DiasporaController::class, 'emergency']);
$router->post('/diaspora/emergency', [DiasporaController::class, 'emergency']);

// Nigerians in Kenya Routes
$router->get('/nigerians-in-kenya', [DiasporaController::class, 'index']);
$router->get('/nigerians-in-kenya/register', [DiasporaController::class, 'register']);
$router->post('/nigerians-in-kenya/register', [DiasporaController::class, 'register']);
$router->get('/nigerians-in-kenya/community', [InformationController::class, 'community']);
$router->get('/emergency', [DiasporaController::class, 'emergency']);
$router->post('/emergency', [DiasporaController::class, 'emergency']);

// Bilateral Trade & Investment
$router->get('/trade', [TradeController::class, 'index']);
$router->post('/trade', [TradeController::class, 'index']);
$router->get('/trade/enquiry', [TradeController::class, 'index']);
$router->post('/trade/enquiry', [TradeController::class, 'index']);

// Discover Nigeria & 36 States Map
$router->get('/discover-nigeria', [NigeriaController::class, 'map']);
$router->get('/discover-nigeria/states', [NigeriaController::class, 'map']);
$router->get('/discover-nigeria/government', [InformationController::class, 'government']);
$router->get('/nigeria/map', [NigeriaController::class, 'map']);

// The Mission Routes
$router->get('/mission', [MissionController::class, 'index']);
$router->get('/mission/leadership', [MissionController::class, 'leadership']);
$router->get('/mission/history', [MissionController::class, 'history']);
$router->get('/mission/message', [MissionController::class, 'message']);
$router->get('/mission/friends-of-nigeria', [MissionController::class, 'friends']);

// News, Notices, Events, Media & Downloads
$router->get('/news', [NewsController::class, 'index']);
$router->get('/news/view', [NewsController::class, 'view']);
$router->get('/notices', [NewsController::class, 'index']);
$router->get('/events', [InformationController::class, 'events']);
$router->get('/gallery', [InformationController::class, 'gallery']);
$router->get('/downloads', [InformationController::class, 'downloads']);
$router->get('/faq', [InformationController::class, 'faq']);
$router->get('/search', [InformationController::class, 'search']);
$router->get('/api/search', [InformationController::class, 'apiSearch']);
$router->get('/newsletter', [NewsletterController::class, 'index']);
$router->post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
$router->get('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe']);

// Contact, Feedback, Policy & Security Routes
$router->get('/contact', [ContactController::class, 'index']);
$router->post('/contact', [ContactController::class, 'index']);
$router->get('/feedback', [InformationController::class, 'feedback']);
$router->post('/feedback', [InformationController::class, 'feedback']);
$router->get('/official-channels', [InformationController::class, 'officialChannels']);
$router->get('/report-suspicious', [InformationController::class, 'reportSuspicious']);
$router->post('/report-suspicious', [InformationController::class, 'reportSuspicious']);
$router->get('/privacy', [InformationController::class, 'privacy']);
$router->get('/terms', [InformationController::class, 'terms']);
$router->get('/accessibility', [InformationController::class, 'accessibility']);
$router->get('/cookies', [InformationController::class, 'cookies']);
$router->get('/sitemap', [InformationController::class, 'sitemap']);
$router->get('/sitemap.xml', [InformationController::class, 'sitemapXml']);

// Citizen / Applicant Portal
$router->get('/login', [CitizenPortalController::class, 'login']);
$router->post('/login', [CitizenPortalController::class, 'login']);
$router->get('/register', [CitizenPortalController::class, 'register']);
$router->post('/register', [CitizenPortalController::class, 'register']);
$router->get('/forgot-password', [CitizenPortalController::class, 'forgotPassword']);
$router->post('/forgot-password', [CitizenPortalController::class, 'forgotPassword']);
$router->get('/reset-password', [CitizenPortalController::class, 'resetPassword']);
$router->post('/reset-password', [CitizenPortalController::class, 'resetPassword']);
$router->get('/portal/login', [CitizenPortalController::class, 'login']);
$router->post('/portal/login', [CitizenPortalController::class, 'login']);
$router->get('/portal/register', [CitizenPortalController::class, 'register']);
$router->post('/portal/register', [CitizenPortalController::class, 'register']);
$router->get('/portal/logout', [CitizenPortalController::class, 'logout']);
$router->get('/portal/dashboard', [CitizenPortalController::class, 'dashboard']);
$router->get('/portal/profile', [CitizenPortalController::class, 'profile']);
$router->post('/portal/profile', [CitizenPortalController::class, 'profile']);
$router->get('/portal/requests', [CitizenPortalController::class, 'requests']);
$router->get('/portal/appointments', [CitizenPortalController::class, 'appointments']);
$router->get('/portal/documents', [CitizenPortalController::class, 'documents']);
$router->post('/portal/documents', [CitizenPortalController::class, 'documents']);
$router->get('/portal/notifications', [CitizenPortalController::class, 'notifications']);
$router->get('/portal/request', [CitizenPortalController::class, 'requestDetail']);
$router->post('/portal/request', [CitizenPortalController::class, 'requestDetail']);

// Files & PDF Receipts

$router->get('/files/download', [FileController::class, 'download']);
$router->post('/files/upload', [FileController::class, 'upload']);
$router->get('/portal/receipt', [FileController::class, 'printReceipt']);

// Staff Workspace & CMS Admin
$router->get('/admin/login', [AdminController::class, 'login']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/dashboard', [AdminController::class, 'dashboard']);
$router->get('/admin/requests', [AdminController::class, 'requests']);
$router->post('/admin/requests', [AdminController::class, 'requests']);
$router->get('/admin/requests/view', [AdminController::class, 'requestDetail']);
$router->post('/admin/requests/view', [AdminController::class, 'requestDetail']);
$router->get('/admin/appointments', [AdminController::class, 'appointments']);
$router->post('/admin/appointments', [AdminController::class, 'appointments']);
$router->get('/admin/citizens', [AdminController::class, 'citizens']);
$router->post('/admin/citizens', [AdminController::class, 'citizens']);
$router->get('/admin/notices', [AdminController::class, 'notices']);
$router->post('/admin/notices', [AdminController::class, 'notices']);
$router->get('/admin/verification', [AdminController::class, 'verification']);
$router->post('/admin/verification', [AdminController::class, 'verification']);
$router->get('/admin/trade', [AdminController::class, 'trade']);
$router->get('/admin/audit', [AdminController::class, 'audit']);
$router->get('/admin/users', [AdminController::class, 'users']);
$router->post('/admin/users', [AdminController::class, 'users']);
$router->get('/admin/settings', [AdminController::class, 'settings']);
$router->post('/admin/settings', [AdminController::class, 'settings']);
$router->get('/admin/reports', [AdminController::class, 'reports']);
$router->get('/admin/export', [AdminController::class, 'export']);
$router->get('/admin/hero', [AdminController::class, 'hero']);
$router->post('/admin/hero', [AdminController::class, 'hero']);
$router->get('/health', [HealthController::class, 'index']);


// Dispatch Request

$router->dispatch($request);
