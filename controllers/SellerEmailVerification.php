<?php
require_once '../vendor/autoload.php';
require_once '../classes/user.class.php';

define('SENDER_EMAIL', 'jjd462849@gmail.com');
define('SENDER_PASSWORD', 'xyhthnwydzldagbu');


// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
//$transport = (new Swift_SmtpTransport('smtp.hostinger.com', 465, 'ssl'))
    ->setUsername(SENDER_EMAIL, SENDER_EMAIL)
    ->setPassword(SENDER_PASSWORD, SENDER_PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendEmailVerification($userEmail, $token)
{
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Test mail</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background: #592f80;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <a href="http://localhost/myecom/verifySellerEmail.php?token=' . $token . '" style="color: #107869; background: white; border: 1px solid #107869; border-radius: 2px; ">Verify Email!</a>
    </body>

    </html>';

    // Create a message
    $message = (new Swift_Message('Please verify your Email Address.'))
        ->setFrom([SENDER_EMAIL => 'Handmade Treasure Store'])
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}
//<a href="https://wmsuphsi.online/verify_email.php?token=' . $token . '" style="color: #107869; background: white; border: 1px solid #107869; border-radius: 2px; ">Verify Email!</a></div>
//<a href="http://localhost/wmsuphsi-main/verify_email.php?token=' . $token . '" style="color: #107869; background: white; border: 1px solid #107869; border-radius: 2px; ">Verify Email!</a>