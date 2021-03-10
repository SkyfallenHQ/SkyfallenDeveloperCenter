<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Class SDCEmail
 * Class used to send emails
 */
class SDCEmail
{
    /**
     * Sends an email
     * @param String $emailTo Who to send the email to
     * @param String $emailSubject Subject line of the email
     * @param String $emailBody Body of the email
     * @throws Exception
     */
    public static function send($emailTo,$emailSubject,$emailBody){

        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->Host = SMTP_SERVER;
        $mail->Port = SMTP_PORT;
        $mail->SMTPSecure = SMTP_SECURITY;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->setFrom(SMTP_SENDER, SMTP_SENDER_NAME);
        $mail->addAddress($emailTo);
        $mail->Subject = $emailSubject;
        $mail->msgHTML($emailBody);

        if(!$mail->send()){
            echo "Mailer Error: " . $mail->ErrorInfo;
        }

    }

}