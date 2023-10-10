<?php
// Worker loop
require '../controller/Auth.php';
require '../controller/Client.php';
require '../controller/Mail.php';

$auth = new Auth();
$client = new Client();
$mail = new Mail();

while (true) {
    // Wait for a task in the queue
    $mailQueue = $mail->queue();

    // this is example function to send email
    if ($mailQueue) {
        if (!$mail->send($mailQueue)) {
            echo 'Email could not be sent. Mailer Error';
        } else {
            echo 'Email sent successfully';
        }
    }
    sleep(1);
}