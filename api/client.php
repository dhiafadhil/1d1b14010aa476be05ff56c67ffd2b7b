<?php
// Include CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Include action.php file
require '../controller/Client.php';

$client = new Client();

// create a api variable to get HTTP method dynamically
$api = $_SERVER['REQUEST_METHOD'];

// get id from url
$id = $_GET['id'] ?? '';


if ($api == 'GET') {
    $data = $client->fetch($id);
    echo $client->message('Get client successfully!',false, $data);
}

if ($api == 'POST') {
    $clientData = generateClient();
    if ($client->insert($clientData['client_id'], $clientData['client_secret'])) {
        echo $client->message('Client added successfully!',false, $clientData);
    } else {
        echo $client->message('Failed to add an Client!',true);
    }
}
?>