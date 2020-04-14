<?php

namespace Framework\Modules;

use PHPMailer;

class Mail
{
    public static function send(string $to, string $subject, string $message, array $headers = [])
    {
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo 'true';
        } else {
            echo 'false';
        }

    }
}