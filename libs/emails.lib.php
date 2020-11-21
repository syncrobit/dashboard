<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SB_EMAILS{
    public static function activationEmail($email, $hash){
        $url = SB_CORE::getSetting('base_uri')."verify/?email=".$email."&hash=".$hash;
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = SB_CORE::getSetting('smtp_server');
            $mail->SMTPAuth   = true;
            $mail->Username   = SB_CORE::getSetting('smtp_user');
            $mail->Password   = SB_CORE::getSetting('smtp_password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('support@syncrob.it', 'SyncroB.it Support');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Verify your email';
            $mail->Body    = '<b>You\'re almost ready to get started!</b>
                              <br><br>
                              Click this link to complete your SyncroB.it account setup:
                              <br><br>
                              <a href="'.$url.'">Verify my email</a>
                              <br><br>
                              Verifying your email ensures that you can receive critical notifications.
                              <br><br>
                              Thanks,<br>
                              SyncroB.it
                              <br><br>
                              <small>Link not working? Copy and paste this URL into your browser:<br>
                               '.$url.'
                               <br>
                               This link is valid for 24 hours. If this email is expired, log in to your account to resend your verification link. 
                               If you have questions about the email verification process, please contact support. 
                              </small>';

            $mail->send();

            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return false;
    }

    public static function sendForgotPwdEmail($email, $hash){
        $url = SB_CORE::getSetting('base_uri')."reset/?email=".$email."&hash=".$hash;
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = SB_CORE::getSetting('smtp_server');
            $mail->SMTPAuth   = true;
            $mail->Username   = SB_CORE::getSetting('smtp_user');
            $mail->Password   = SB_CORE::getSetting('smtp_password');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('support@syncrob.it', 'SyncroB.it Support');
            $mail->addAddress($email);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Password Reset';
            $mail->Body    = '<b>Hi!</b>
                              <br><br>
                              You are receiving this email because a password reset was requested for your account.
                              <br><br>
                              <a href="'.$url.'">Reset Password</a>
                              <br><br>
                              If you did not request this reset, ignore this message.
                              <br><br>
                              Thanks,<br>
                              SyncroB.it
                              <br><br>
                              <small>Link not working? Copy and paste this URL into your browser:<br>
                               '.$url.'
                               <br>
                               This link is valid for 24 hours. 
                               If you have questions about the password reset process, please contact support. 
                              </small>';

            $mail->send();

            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return false;
    }
}