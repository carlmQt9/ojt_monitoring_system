<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

class MailHelper
{
    private static function isEnabled(): bool
    {
        return (bool) cache('settings.email_notifications', true);
    }

    private static function mailer(): PHPMailer
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = env('MAIL_HOST', 'smtp.gmail.com');
        $mail->SMTPAuth   = true;
        $mail->Username   = env('MAIL_USERNAME');
        $mail->Password   = env('MAIL_PASSWORD');
        $mail->SMTPSecure = env('MAIL_ENCRYPTION', PHPMailer::ENCRYPTION_STARTTLS);
        $mail->Port       = (int) env('MAIL_PORT', 587);
        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'OJT Monitoring System'));
        $mail->isHTML(true);
        return $mail;
    }

    public static function sendWelcome(string $toEmail, string $toName, bool $needsApproval = false): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);

        if ($needsApproval) {
            $mail->Subject = 'Registration Received - PRMSU OJT Monitoring System';
            $mail->Body    = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                        <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                    </div>
                    <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                        <h3 style='color:#1e3a5f;'>Hi {$toName},</h3>
                        <p style='color:#374151;'>Thank you for registering at the <strong>PRMSU OJT Monitoring System</strong>!</p>
                        <p style='color:#374151;'>Your account has been successfully created. However, please note that your account requires <strong>approval from the CCIT Head</strong> before you can log in.</p>
                        <div style='background:#fef9c3;border:1px solid #fde047;border-radius:8px;padding:16px;margin:20px 0;'>
                            <p style='color:#854d0e;margin:0;'>⏳ <strong>Please wait</strong> — the CCIT Head will review and approve your account shortly. You will receive another email once your account is approved.</p>
                        </div>
                        <p style='color:#6b7280;font-size:13px;'>If you did not register for this account, please ignore this email.</p>
                        <br>
                        <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                    </div>
                </div>
            ";
        } else {
            $mail->Subject = 'Welcome to PRMSU OJT Monitoring System';
            $mail->Body    = "
                <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                    <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                        <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                    </div>
                    <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                        <h3 style='color:#1e3a5f;'>Welcome, {$toName}!</h3>
                        <p style='color:#374151;'>Thank you for registering at the <strong>PRMSU OJT Monitoring System</strong>.</p>
                        <p style='color:#374151;'>Your account has been created successfully. You can now log in and start tracking your OJT progress.</p>
                        <div style='text-align:center;margin:24px 0;'>
                            <a href='" . config('app.url') . "/login' style='background:#1e3a5f;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;'>Log In Now</a>
                        </div>
                        <br>
                        <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                    </div>
                </div>
            ";
        }
        $mail->send();
    }

    public static function sendApproved(string $toEmail, string $toName): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Account Approved - PRMSU OJT Monitoring System';
        $mail->Body    = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                </div>
                <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                    <h3 style='color:#1e3a5f;'>Hi {$toName},</h3>
                    <div style='background:#dcfce7;border:1px solid #86efac;border-radius:8px;padding:16px;margin:16px 0;'>
                        <p style='color:#166534;margin:0;font-weight:bold;'>✅ Your account has been approved!</p>
                    </div>
                    <p style='color:#374151;'>The CCIT Head has reviewed and approved your account. You can now log in to the <strong>PRMSU OJT Monitoring System</strong>.</p>
                    <div style='text-align:center;margin:24px 0;'>
                        <a href='" . config('app.url') . "/login' style='background:#16a34a;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;'>Log In Now</a>
                    </div>
                    <br>
                    <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                </div>
            </div>
        ";
        $mail->send();
    }

    public static function sendDenied(string $toEmail, string $toName): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Account Registration Denied - PRMSU OJT Monitoring System';
        $mail->Body    = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                </div>
                <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                    <h3 style='color:#1e3a5f;'>Hi {$toName},</h3>
                    <div style='background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:16px;margin:16px 0;'>
                        <p style='color:#991b1b;margin:0;font-weight:bold;'>❌ Your account registration has been denied.</p>
                    </div>
                    <p style='color:#374151;'>Unfortunately, the CCIT Head has denied your registration request for the <strong>PRMSU OJT Monitoring System</strong>.</p>
                    <p style='color:#374151;'>If you believe this is a mistake, please contact your coordinator or the CCIT Head directly.</p>
                    <br>
                    <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                </div>
            </div>
        ";
        $mail->send();
    }

    public static function sendRequirementApproved(string $toEmail, string $toName, string $title, string $feedback): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Requirement Approved - PRMSU OJT Monitoring System';
        $mail->Body    = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                </div>
                <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                    <h3 style='color:#1e3a5f;'>Hi {$toName},</h3>
                    <div style='background:#dcfce7;border:1px solid #86efac;border-radius:8px;padding:16px;margin:16px 0;'>
                        <p style='color:#166534;margin:0;font-weight:bold;'>&#10003; Your requirement has been <strong>Approved</strong>!</p>
                    </div>
                    <p style='color:#374151;'>Your submitted requirement <strong>&ldquo;{$title}&rdquo;</strong> has been reviewed and approved by the coordinator.</p>
                    <div style='background:#f0fdf4;border-left:4px solid #16a34a;padding:12px 16px;margin:16px 0;border-radius:4px;'>
                        <p style='color:#374151;margin:0;'><strong>Feedback:</strong> {$feedback}</p>
                    </div>
                    <div style='text-align:center;margin:24px 0;'>
                        <a href='" . config('app.url') . "/login' style='background:#16a34a;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;'>View Dashboard</a>
                    </div>
                    <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                </div>
            </div>
        ";
        $mail->send();
    }

    public static function sendRequirementDenied(string $toEmail, string $toName, string $title, string $feedback): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Requirement Denied - Action Required - PRMSU OJT Monitoring System';
        $mail->Body    = "
            <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
                <div style='background:#1e3a5f;padding:24px;border-radius:8px 8px 0 0;text-align:center;'>
                    <h2 style='color:#fff;margin:0;'>PRMSU OJT Monitoring System</h2>
                </div>
                <div style='background:#f9fafb;padding:32px;border-radius:0 0 8px 8px;border:1px solid #e5e7eb;'>
                    <h3 style='color:#1e3a5f;'>Hi {$toName},</h3>
                    <div style='background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:16px;margin:16px 0;'>
                        <p style='color:#991b1b;margin:0;font-weight:bold;'>&#10007; Your requirement has been <strong>Denied</strong>.</p>
                    </div>
                    <p style='color:#374151;'>Your submitted requirement <strong>&ldquo;{$title}&rdquo;</strong> was reviewed and denied by the coordinator.</p>
                    <div style='background:#fff7ed;border-left:4px solid #ea580c;padding:12px 16px;margin:16px 0;border-radius:4px;'>
                        <p style='color:#374151;margin:0;'><strong>Reason:</strong> {$feedback}</p>
                    </div>
                    <p style='color:#374151;'><strong>Action Required:</strong> Please log in to your dashboard and resubmit this requirement with the necessary corrections.</p>
                    <div style='text-align:center;margin:24px 0;'>
                        <a href='" . config('app.url') . "/login' style='background:#ea580c;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;'>Resubmit Now</a>
                    </div>
                    <p style='color:#374151;'>Best regards,<br><strong>PRMSU OJT Team</strong></p>
                </div>
            </div>
        ";
        $mail->send();
    }

    public static function sendPasswordReset(string $toEmail, string $toName, string $resetUrl): void
    {
        if (!self::isEnabled()) return;
        $mail = self::mailer();
        $mail->addAddress($toEmail, $toName);
        $mail->Subject = 'Password Reset - PRMSU OJT Monitoring System';
        $mail->Body    = "
            <h2>Password Reset Request</h2>
            <p>Hi {$toName},</p>
            <p>We received a request to reset your password. Click the button below to set a new password:</p>
            <p style='margin:24px 0;'>
                <a href='{$resetUrl}' style='background:#3b82f6;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;font-weight:bold;'>Reset Password</a>
            </p>
            <p>This link expires in <strong>60 minutes</strong>. If you did not request a password reset, please ignore this email.</p>
            <br>
            <p>Best regards,<br>PRMSU OJT Team</p>
        ";
        $mail->send();
    }
}
