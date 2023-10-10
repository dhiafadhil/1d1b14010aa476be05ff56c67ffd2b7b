<?php

require_once '../config/db.php';
require_once '../helper/utils.php';
include "../modules/classes/class.phpmailer.php";

class Mail extends Config {

    public function queue() {
        $sql = 'SELECT * FROM mail WHERE is_send IS NULL order by id limit 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows;
    }

    public function fetch() {
        $sql = 'SELECT * FROM mail';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        return $rows[0];
    }

    public function save($data)
    {
        $from = $data['from'];
        $to = $data['to'];
        $subject = $data['subject'];
        $cc = $data['cc'];
        $text = $data['text'];
        $timestamp =  (string)time();

        $sql = 'INSERT INTO mail (sender, email_receiver, subject, cc, text, timestamp ) VALUES (:sender, :email_receiver, :subject, :cc, :text, :timestamp)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam('sender', $from,PDO::PARAM_STR);
        $stmt->bindParam('email_receiver', $to, PDO::PARAM_STR);
        $stmt->bindParam('subject', $subject, PDO::PARAM_STR);
        $stmt->bindParam('cc', $cc, PDO::PARAM_STR);
        $stmt->bindParam('text', $text, PDO::PARAM_STR);
        $stmt->bindParam('timestamp', $timestamp, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    }

    public function send($data) {

        $mail = new PHPMailer;

        $mail->IsSMTP();

        $mail->SMTPSecure = 'ssl';

        $mail->Host = "localhost"; //hostname masing-masing provider email
        $mail->SMTPDebug = 2;
        $mail->Port = 465;
        $mail->SMTPAuth = true;

        $mail->Timeout = 60; // timeout pengiriman (dalam detik)
        $mail->SMTPKeepAlive = true;

        $mail->Username = "admin@namadomain"; //user email
        $mail->Password = "XXXXX"; //password email
        $mail->SetFrom("admin@namadomain","Nama pengirim yang muncul"); //set email pengirim
        $mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
        $mail->AddCC(['a@mail.com','b@mail.com']);
        $mail->AddAddress("admin@namadomain","Nama penerima yang muncul"); //tujuan email
        $mail->MsgHTML("Pengiriman Email Dari Website");

        if($mail->Send()) echo "Message has been sent";
        else echo "Failed to sending message";
    }
}

?>