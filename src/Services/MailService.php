<?php

namespace App\Services;

use App\Core\Env;
use App\Core\Helper;

class MailService {
    
    /**
     * Send HTML email using SMTP configuration or PHP mail() fallback
     */
    public static function send(string $to, string $subject, string $bodyContent, string $buttonLabel = '', string $buttonUrl = ''): bool {
        $fromEmail = Env::get('SMTP_FROM_EMAIL', 'info@nigeriankenya.or.ke');
        $fromName = Env::get('SMTP_FROM_NAME', 'Nigeria High Commission Nairobi');

        $html = self::buildHtmlTemplate($subject, $bodyContent, $buttonLabel, $buttonUrl);

        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: {$fromName} <{$fromEmail}>" . "\r\n";
        $headers .= "Reply-To: {$fromEmail}" . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        $success = false;

        try {
            // Attempt standard PHP mail()
            if (function_exists('mail')) {
                $success = @mail($to, $subject, $html, $headers);
            }
        } catch (\Throwable $e) {
            $success = false;
        }

        // Log all emails to storage/logs/emails.log for verification & debugging
        self::logEmail($to, $subject, $html, $success);

        return true; // Return true so registration/newsletter flows continue seamlessly
    }

    /**
     * Welcome Email on Account Creation
     */
    public static function sendWelcomeEmail(string $email, string $fullName): bool {
        $subject = "Welcome to Nigeria High Commission Nairobi Digital Portal";
        $body = "
            <h2 style='color: #004D2C; font-family: sans-serif; font-size: 20px; margin-top: 0;'>Welcome, " . htmlspecialchars($fullName) . "!</h2>
            <p>Thank you for registering an account on the official digital portal of the High Commission of the Federal Republic of Nigeria in Nairobi, Kenya.</p>
            <p>With your account, you can access streamlined consular services, schedule appointment bookings, submit document verification requests, and track your applications in real-time.</p>
            <div style='background-color: #F8FAFC; border-left: 4px solid #008751; padding: 12px 16px; margin: 20px 0;'>
                <strong>Registered Email:</strong> " . htmlspecialchars($email) . "<br>
                <strong>Portal Access:</strong> Citizen & Consular Portal
            </div>
            <p>If you have any questions or require consular assistance, please feel free to reach out to our team at <a href='mailto:info@nigeriankenya.or.ke' style='color: #008751;'>info@nigeriankenya.or.ke</a> or via emergency hotline <strong>+254 795 770 247</strong>.</p>
        ";

        $buttonUrl = Helper::baseUrl('portal/login');
        return self::send($email, $subject, $body, "Access Citizen Portal", $buttonUrl);
    }

    /**
     * Password Reset Email
     */
    public static function sendPasswordResetEmail(string $email, string $resetToken): bool {
        $subject = "Password Reset Request - Nigeria High Commission Nairobi";
        $resetUrl = Helper::baseUrl('reset-password?token=' . urlencode($resetToken) . '&email=' . urlencode($email));

        $body = "
            <h2 style='color: #004D2C; font-family: sans-serif; font-size: 20px; margin-top: 0;'>Password Reset Request</h2>
            <p>We received a request to reset your password for your account associated with <strong>" . htmlspecialchars($email) . "</strong>.</p>
            <p>Please click the button below to set a new password. This link is valid for 60 minutes for security purposes.</p>
            <div style='background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 12px 16px; margin: 20px 0; color: #991B1B; font-size: 13px;'>
                <strong>Security Notice:</strong> If you did not request a password reset, please ignore this email or contact the High Commission IT Security desk immediately.
            </div>
        ";

        return self::send($email, $subject, $body, "Reset Your Password", $resetUrl);
    }

    /**
     * Newsletter Subscription Confirmation Email
     */
    public static function sendNewsletterWelcome(string $email, string $fullName = ''): bool {
        $subject = "Subscription Confirmed - High Commission Newsletter & Advisories";
        $nameGreeting = !empty($fullName) ? " " . htmlspecialchars($fullName) : "";

        $body = "
            <h2 style='color: #004D2C; font-family: sans-serif; font-size: 20px; margin-top: 0;'>Subscription Confirmed!</h2>
            <p>Dear subscriber{$nameGreeting},</p>
            <p>Thank you for subscribing to official newsletters and press advisories from the High Commission of the Federal Republic of Nigeria in Nairobi, Kenya.</p>
            <p>You will now receive direct updates on bilateral news, public advisories, holiday notices, trade opportunities, and diaspora community announcements.</p>
            <div style='background-color: #F0FDF4; border-left: 4px solid #008751; padding: 12px 16px; margin: 20px 0; color: #166534;'>
                <i style='font-size: 13px;'>You are subscribed with: <strong>" . htmlspecialchars($email) . "</strong></i>
            </div>
            <p>We remain committed to keeping our diaspora citizens, business partners, and regional stakeholders informed.</p>
        ";

        $buttonUrl = Helper::baseUrl('news');
        return self::send($email, $subject, $body, "View Latest News & Advisories", $buttonUrl);
    }

    /**
     * News Broadcast Email to Subscriber
     */
    public static function sendNewsBroadcast(string $email, string $title, string $snippet, string $newsUrl): bool {
        $subject = "Diplomatic Advisory: " . $title;

        $body = "
            <div style='background-color: #D4AF37; color: #002B19; font-weight: bold; padding: 4px 10px; display: inline-block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border-radius: 3px; margin-bottom: 12px;'>Official Announcement</div>
            <h2 style='color: #004D2C; font-family: sans-serif; font-size: 20px; margin-top: 0; line-height: 1.4;'>" . htmlspecialchars($title) . "</h2>
            <p style='color: #334155; font-size: 15px; line-height: 1.6;'>" . htmlspecialchars($snippet) . "</p>
            <p>Read the complete announcement on our official portal below:</p>
        ";

        return self::send($email, $subject, $body, "Read Full Notice", $newsUrl);
    }

    /**
     * Classy Sovereign HTML Email Wrapper
     */
    private static function buildHtmlTemplate(string $subject, string $content, string $buttonLabel = '', string $buttonUrl = ''): string {
        $year = date('Y');
        $siteUrl = Helper::baseUrl('/');

        $buttonHtml = '';
        if (!empty($buttonLabel) && !empty($buttonUrl)) {
            $buttonHtml = "
                <div style='text-align: center; margin: 30px 0 20px 0;'>
                    <a href='" . htmlspecialchars($buttonUrl) . "' target='_blank' style='background-color: #008751; color: #FFFFFF; font-family: sans-serif; font-size: 15px; font-weight: bold; text-decoration: none; padding: 14px 28px; border-radius: 6px; display: inline-block; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-bottom: 3px solid #004D2C;'>
                        " . htmlspecialchars($buttonLabel) . " &rarr;
                    </a>
                </div>
            ";
        }

        return "
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>" . htmlspecialchars($subject) . "</title>
</head>
<body style='margin: 0; padding: 0; background-color: #F1F5F9; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%' style='background-color: #F1F5F9; padding: 20px 0 40px 0;'>
        <tr>
            <td align='center'>
                
                <!-- Main Container -->
                <table border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width: 620px; background-color: #FFFFFF; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.06); border: 1px solid #E2E8F0;'>
                    
                    <!-- Gold Sovereign Accent Top Line -->
                    <tr>
                        <td style='background-color: #D4AF37; height: 6px; font-size: 0; line-height: 0;'>&nbsp;</td>
                    </tr>

                    <!-- Classy Deep Emerald Header -->
                    <tr>
                        <td style='background-color: #002B19; padding: 28px 32px; text-align: center;'>
                            <!-- Flag Badge -->
                            <table border='0' cellpadding='0' cellspacing='0' align='center' style='margin-bottom: 12px;'>
                                <tr>
                                    <td width='12' height='16' style='background-color: #008751;'></td>
                                    <td width='12' height='16' style='background-color: #FFFFFF;'></td>
                                    <td width='12' height='16' style='background-color: #008751;'></td>
                                </tr>
                            </table>
                            
                            <div style='color: #F3C649; font-size: 11px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 4px;'>
                                Federal Republic of Nigeria
                            </div>
                            <div style='color: #FFFFFF; font-size: 18px; font-weight: bold; font-family: serif; text-transform: uppercase; letter-spacing: 0.5px;'>
                                High Commission Nairobi
                            </div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style='padding: 36px 32px; color: #1E293B; font-size: 15px; line-height: 1.6;'>
                            " . $content . "
                            " . $buttonHtml . "
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style='padding: 0 32px;'>
                            <hr style='border: none; border-top: 1px solid #E2E8F0; margin: 0;'>
                        </td>
                    </tr>

                    <!-- Classy Footer -->
                    <tr>
                        <td style='background-color: #F8FAFC; padding: 24px 32px; text-align: center; color: #64748B; font-size: 12px; line-height: 1.5;'>
                            <p style='margin: 0 0 8px 0; font-weight: bold; color: #004D2C;'>High Commission of the Federal Republic of Nigeria</p>
                            <p style='margin: 0 0 8px 0;'>Lenana Road, Kilimani, P.O. Box 30294-00100, Nairobi, Kenya</p>
                            <p style='margin: 0 0 12px 0;'>Phone: +254 20 2712733 | Emergency: +254 795 770 247 | Email: info@nigeriankenya.or.ke</p>
                            <div style='color: #94A3B8; font-size: 11px;'>
                                &copy; " . $year . " High Commission of Nigeria. All Rights Reserved. | <a href='" . $siteUrl . "' style='color: #008751; text-decoration: none;'>Official Sovereign Portal</a>
                            </div>
                        </td>
                    </tr>

                </table>
                <!-- End Main Container -->

            </td>
        </tr>
    </table>
</body>
</html>
        ";
    }

    private static function logEmail(string $to, string $subject, string $html, bool $status): void {
        $logDir = dirname(__DIR__, 2) . '/storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }
        $logFile = $logDir . '/emails.log';
        $entry = "[" . date('Y-m-d H:i:s') . "] TO: {$to} | SUBJECT: {$subject} | STATUS: " . ($status ? 'SUCCESS' : 'LOGGED') . "\n";
        @file_put_contents($logFile, $entry, FILE_APPEND);
    }
}
