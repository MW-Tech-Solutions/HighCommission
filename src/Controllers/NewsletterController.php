<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Helper;
use App\Services\MailService;
use PDO;

class NewsletterController extends Controller {

    /**
     * Dedicated Newsletter Landing & Management Page
     */
    public function index(): void {
        $db = Database::getConnection();
        
        // Fetch recent advisories / notices for preview
        $recentNotices = $db->query("SELECT * FROM notices WHERE is_published = 1 ORDER BY published_at DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'pageTitle' => 'Diplomatic Newsletter & Public Advisory Network',
            'recentNotices' => $recentNotices
        ];

        $this->render('newsletter/index', $data);
    }

    /**
     * Handle Subscribe Form Submission (AJAX or standard POST)
     */
    public function subscribe(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('newsletter');
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $fullName = trim($_POST['full_name'] ?? '');
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || isset($_POST['ajax']);

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if ($isAjax) {
                $this->json(['success' => false, 'message' => 'Please provide a valid email address.'], 400);
                return;
            }
            Helper::setFlash('danger', 'Please provide a valid email address.');
            $this->redirect('newsletter');
            return;
        }

        $db = Database::getConnection();
        $token = bin2hex(random_bytes(16));

        // Check if already subscribed
        $stmt = $db->prepare("SELECT id, status FROM newsletter_subscriptions WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            if ($existing['status'] === 'subscribed') {
                $msg = 'You are already subscribed to the High Commission newsletter & advisory network.';
                if ($isAjax) {
                    $this->json(['success' => true, 'message' => $msg]);
                    return;
                }
                Helper::setFlash('info', $msg);
                $this->redirect('newsletter');
                return;
            } else {
                // Re-subscribe
                $update = $db->prepare("UPDATE newsletter_subscriptions SET status = 'subscribed', full_name = :name, updated_at = NOW() WHERE id = :id");
                $update->execute([':name' => $fullName, ':id' => $existing['id']]);
            }
        } else {
            // New subscription
            $insert = $db->prepare("INSERT INTO newsletter_subscriptions (email, full_name, status, token, source) VALUES (:email, :name, 'subscribed', :token, 'website')");
            $insert->execute([
                ':email' => $email,
                ':name' => $fullName,
                ':token' => $token
            ]);
        }

        // Send Classy Confirmation HTML Email
        MailService::sendNewsletterWelcome($email, $fullName);

        $successMsg = 'Thank you for subscribing! A confirmation email has been dispatched to ' . htmlspecialchars($email) . '.';

        if ($isAjax) {
            $this->json(['success' => true, 'message' => $successMsg]);
            return;
        }

        Helper::setFlash('success', $successMsg);
        $this->redirect('newsletter');
    }

    /**
     * Handle Unsubscribe Request
     */
    public function unsubscribe(): void {
        $email = trim($_GET['email'] ?? '');

        if (!empty($email)) {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE newsletter_subscriptions SET status = 'unsubscribed' WHERE email = :email");
            $stmt->execute([':email' => $email]);
            Helper::setFlash('info', 'You have been unsubscribed from newsletter updates.');
        }

        $this->redirect('newsletter');
    }
}
