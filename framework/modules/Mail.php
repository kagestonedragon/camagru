<?php

namespace Framework\Modules;

use PHPMailer;

class Mail
{
    public static function send(string $to, string $subject, string $message, array $headers = [])
    {
        /*$headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";

        mail($to, $subject, $message, $headers);*/

        $mail = new PHPMailer;

        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.mailgun.org';  // Specify mailgun SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'postmaster@sandbox76682ab34fd54042a697e703e851accf.mailgun.org'; // SMTP username from https://mailgun.com/cp/domains
        $mail->Password = '62e60cd00185b76a32b1ec903b08c4d0-915161b7-0982b823'; // SMTP password from https://mailgun.com/cp/domains
        $mail->SMTPSecure = 'tls';   // Enable encryption, 'ssl'
        $mail->From = 'sender@domain.com'; // The FROM field, the address sending the email
        $mail->FromName = 'Orlie'; // The NAME field which will be displayed on arrival by the email client
        $mail->addAddress('kagestonedragon@gmail.com', 'BOB');     // Recipient's email address and optionally a name to identify him
        $mail->isHTML(true);   // Set email to be sent as HTML, if you are planning on sending plain text email just set it to false
// The following is self explanatory
        $mail->Subject = 'Email sent with Mailgun';
        $mail->Body    = '<span style="color: red">Mailgun rocks</span>, thank you <em>phpmailer</em> for making emailing easy using this <b>tool!</b>';
        $mail->AltBody = 'Mailgun rocks, shame you cant see the html sent with phpmailer so youre seeing this instead';
        if(!$mail->send()) {
            echo "Message hasn't been sent.";
            echo 'Mailer Error: ' . $mail->ErrorInfo . "n";
        } else {
            echo "Message has been sent  n";
        }

    }
}