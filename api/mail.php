<?php


// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
require '../controller/Auth.php';
require '../controller/Client.php';
require '../controller/Mail.php';

$auth = new Auth();
$client = new Client();
$mail = new Mail();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

$id = $_GET['id'] ?? '';


if ($api == 'GET') {
    $data = $mail->fetch();
    echo $client->message('Get Email successfully!',false, $data);
}

if ($api == 'POST') {
    $json_data = file_get_contents("php://input");

    $data = json_decode($json_data, true); // true to get an associative array

    if ($data === null) {
        http_response_code(400); // Bad Request
        exit("Invalid JSON data.");
    }

    $headers = getallheaders();


    $token_data = $auth->get_token($headers['token']);

    if ($token_data == null) {
        exit($client->message('Unauthorized', false));
    }


    if ($token_data['expire'] < (string)time()) {
        exit($client->message('Token Expired', false));
    }

    $sendEmail = $mail->save($data);
    if ($sendEmail) {
        echo $client->message('Email Send', false, $data);
    } else {
        echo $client->message('Email Send Failed', false, $data);
    }

}
