<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\SendMail;
use App\Models\EmailConfig;
use Illuminate\Support\Facades\Log;

class EmailHelper
{
    /**
     * Get email configuration from database
     *
     * @return EmailConfig|null
     */
    private static function getEmailConfig()
    {
        // Get the first (and probably only) email configuration
        return EmailConfig::first();
    }

    /**
     * Send a generic email using the configured SMTP settings
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $subject
     * @param string $htmlBody
     * @param string|null $plainTextBody
     * @param array $attachments
     * @return bool
     */
    public static function sendGenericEmail($toEmail, $toName, $subject, $htmlBody, $plainTextBody = null, $attachments = [])
    {
        $mail = new PHPMailer(true);
        
        // Get email configuration from database
        $emailConfig = self::getEmailConfig();
        
        if (!$emailConfig) {
            Log::error("Erreur: Aucune configuration email trouvée dans la base de données.");
            return false;
        }

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $emailConfig->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $emailConfig->username;
            $mail->Password   = $emailConfig->password;
            $mail->SMTPSecure = $emailConfig->encryption;
            $mail->Port       = $emailConfig->port;

            // Recipients
            $mail->setFrom($emailConfig->from_address, $emailConfig->from_name);
            $mail->addAddress($toEmail, $toName);

            // Attachments
            foreach ($attachments as $attachment) {
                if (isset($attachment['path']) && isset($attachment['name'])) {
                    $mail->addAttachment($attachment['path'], $attachment['name']);
                } elseif (isset($attachment['path'])) {
                    $mail->addAttachment($attachment['path']);
                }
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = $plainTextBody ?? strip_tags($htmlBody);

            $mail->send();
            
            // Log successful email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => $subject,
                'body' => $htmlBody,
                'alt_body' => $plainTextBody,
                'status' => 'sent',
                'error_message' => null
            ]);
            
            return true;
        } catch (Exception $e) {
            // Log failed email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => $subject,
                'body' => $htmlBody,
                'alt_body' => $plainTextBody,
                'status' => 'failed',
                'error_message' => $mail->ErrorInfo
            ]);
            
            Log::error("Erreur lors de l'envoi de l'email: {$mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Send acceptance email to the applicant.
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $interviewDate
     * @param string|null $customMessage
     * @return bool
     */
    public static function sendAcceptanceEmail($toEmail, $toName, $interviewDate, $customMessage = null)
    {
        $mail = new PHPMailer(true);
        
        // Get email configuration from database
        $emailConfig = self::getEmailConfig();
        
        if (!$emailConfig) {
            Log::error("Erreur: Aucune configuration email trouvée dans la base de données.");
            return false;
        }

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $emailConfig->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $emailConfig->username;
            $mail->Password   = $emailConfig->password;
            $mail->SMTPSecure = $emailConfig->encryption;
            $mail->Port       = $emailConfig->port;

            // Recipients
            $mail->setFrom($emailConfig->from_address, $emailConfig->from_name);
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Votre candidature a été acceptée';
            $mail->Body    = self::generateAcceptanceEmailBody($toName, $interviewDate, $customMessage);
            $mail->AltBody = self::generateAcceptanceEmailPlainText($toName, $interviewDate, $customMessage);

            $mail->send();
            
            // Log successful email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => $mail->Subject,
                'body' => $mail->Body,
                'alt_body' => $mail->AltBody,
                'status' => 'sent',
                'error_message' => null
            ]);
            
            return true;
        } catch (Exception $e) {
            // Log failed email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => 'Votre candidature a été acceptée',
                'body' => self::generateAcceptanceEmailBody($toName, $interviewDate, $customMessage),
                'alt_body' => self::generateAcceptanceEmailPlainText($toName, $interviewDate, $customMessage),
                'status' => 'failed',
                'error_message' => $mail->ErrorInfo
            ]);
            
            Log::error("Erreur lors de l'envoi de l'email d'acceptation: {$mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Send rejection email to the applicant.
     *
     * @param string $toEmail
     * @param string $toName
     * @param string $rejectReason
     * @param string|null $customMessage
     * @return bool
     */
    public static function sendRejectionEmail($toEmail, $toName, $rejectReason, $customMessage = null)
    {
        $mail = new PHPMailer(true);
        
        // Get email configuration from database
        $emailConfig = self::getEmailConfig();
        
        if (!$emailConfig) {
            Log::error("Erreur: Aucune configuration email trouvée dans la base de données.");
            return false;
        }

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = $emailConfig->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $emailConfig->username;
            $mail->Password   = $emailConfig->password;
            $mail->SMTPSecure = $emailConfig->encryption;
            $mail->Port       = $emailConfig->port;

            // Recipients
            $mail->setFrom($emailConfig->from_address, $emailConfig->from_name);
            $mail->addAddress($toEmail, $toName);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Votre candidature a été examinée';
            $mail->Body    = self::generateRejectionEmailBody($toName, $rejectReason, $customMessage);
            $mail->AltBody = self::generateRejectionEmailPlainText($toName, $rejectReason, $customMessage);

            $mail->send();
            
            // Log successful email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => $mail->Subject,
                'body' => $mail->Body,
                'alt_body' => $mail->AltBody,
                'status' => 'sent',
                'error_message' => null
            ]);
            
            return true;
        } catch (Exception $e) {
            // Log failed email sending
            SendMail::create([
                'to_email' => $toEmail,
                'to_name' => $toName,
                'subject' => 'Votre candidature a été examinée',
                'body' => self::generateRejectionEmailBody($toName, $rejectReason, $customMessage),
                'alt_body' => self::generateRejectionEmailPlainText($toName, $rejectReason, $customMessage),
                'status' => 'failed',
                'error_message' => $mail->ErrorInfo
            ]);
            
            Log::error("Erreur lors de l'envoi de l'email de rejet: {$mail->ErrorInfo}");
            return false;
        }
    }

    /**
     * Generate HTML body for acceptance email.
     *
     * @param string $toName
     * @param string $interviewDate
     * @param string|null $customMessage
     * @return string
     */
    private static function generateAcceptanceEmailBody($toName, $interviewDate, $customMessage = null)
    {
        $body = "
        <html>
        <head>
            <title>Votre candidature a été acceptée</title>
        </head>
        <body>
            <h2>Bonjour {$toName},</h2>
            <p>Nous avons le plaisir de vous informer que votre candidature a été acceptée.</p>
            <p>Vous êtes cordialement invité(e) à passer un entretien le <strong>" . date('d/m/Y à H:i', strtotime($interviewDate)) . "</strong>.</p>
        ";

        if ($customMessage) {
            $body .= "<p>{$customMessage}</p>";
        }

        $body .= "
            <p>Merci de confirmer votre présence à cet entretien.</p>
            <p>Cordialement,<br>L'équipe de recrutement</p>
        </body>
        </html>
        ";

        return $body;
    }

    /**
     * Generate plain text body for acceptance email.
     *
     * @param string $toName
     * @param string $interviewDate
     * @param string|null $customMessage
     * @return string
     */
    private static function generateAcceptanceEmailPlainText($toName, $interviewDate, $customMessage = null)
    {
        $body = "Bonjour {$toName},\n\n";
        $body .= "Nous avons le plaisir de vous informer que votre candidature a été acceptée.\n\n";
        $body .= "Vous êtes cordialement invité(e) à passer un entretien le " . date('d/m/Y à H:i', strtotime($interviewDate)) . ".\n\n";

        if ($customMessage) {
            $body .= "{$customMessage}\n\n";
        }

        $body .= "Merci de confirmer votre présence à cet entretien.\n\n";
        $body .= "Cordialement,\nL'équipe de recrutement";

        return $body;
    }

    /**
     * Generate HTML body for rejection email.
     *
     * @param string $toName
     * @param string $rejectReason
     * @param string|null $customMessage
     * @return string
     */
    private static function generateRejectionEmailBody($toName, $rejectReason, $customMessage = null)
    {
        $body = "
        <html>
        <head>
            <title>Votre candidature a été examinée</title>
        </head>
        <body>
            <h2>Bonjour {$toName},</h2>
            <p>Nous vous remercions pour l'intérêt que vous portez à notre entreprise et pour votre candidature.</p>
            <p>Après examen attentif de votre dossier, nous sommes au regret de vous informer que nous ne pouvons donner suite favorable à votre candidature pour le moment.</p>
            <p><strong>Motif du rejet :</strong> {$rejectReason}</p>
        ";

        if ($customMessage) {
            $body .= "<p>{$customMessage}</p>";
        }

        $body .= "
            <p>Nous conserverons votre dossier dans notre base de données et nous vous contacterons si une opportunité correspondant à votre profil venait à se présenter.</p>
            <p>Nous vous souhaitons bonne chance dans vos recherches futures.</p>
            <p>Cordialement,<br>L'équipe de recrutement</p>
        </body>
        </html>
        ";

        return $body;
    }

    /**
     * Generate plain text body for rejection email.
     *
     * @param string $toName
     * @param string $rejectReason
     * @param string|null $customMessage
     * @return string
     */
    private static function generateRejectionEmailPlainText($toName, $rejectReason, $customMessage = null)
    {
        $body = "Bonjour {$toName},\n\n";
        $body .= "Nous vous remercions pour l'intérêt que vous portez à notre entreprise et pour votre candidature.\n\n";
        $body .= "Après examen attentif de votre dossier, nous sommes au regret de vous informer que nous ne pouvons donner suite favorable à votre candidature pour le moment.\n\n";
        $body .= "Motif du rejet : {$rejectReason}\n\n";

        if ($customMessage) {
            $body .= "{$customMessage}\n\n";
        }

        $body .= "Nous conserverons votre dossier dans notre base de données et nous vous contacterons si une opportunité correspondant à votre profil venait à se présenter.\n\n";
        $body .= "Nous vous souhaitons bonne chance dans vos recherches futures.\n\n";
        $body .= "Cordialement,\nL'équipe de recrutement";

        return $body;
    }
}