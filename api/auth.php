<?php

// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
require '../controller/Auth.php';
require '../controller/Client.php';

$auth = new Auth();
$client = new Client();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    $json_data =file_get_contents("php://input");

    $data = json_decode($json_data, true); // true to get an associative array

    if ($data === null) {
        http_response_code(400); // Bad Request
        exit("Invalid JSON data.");
    }

    $client_data = $client->getClient($data['client_id'],$data['client_secret']);

    if ($client_data == null){
        exit($client->message('Client not found',false));
    }

    $authData = $auth->generate_token($client_data['client_id'], $client_data['client_secret']);
    if ($authData != null) {
        echo $client->message('Auth Success',false,
            ['client_id' => $client_data['client_id'],
             'token' => $authData['token'],
             'expire' => $authData['expire']
            ]);
    } else {
        echo $client->message('Auth Failed',true);
    }
}
