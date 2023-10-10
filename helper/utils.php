<?php

function getCurrentTimestamp()
{
    // Get the current timestamp
    $currentTimestamp = time();
    return (string)$currentTimestamp;
}

function generateClient()
{
    // Convert the timestamp to a string and remove the decimal point
    $timestampString = str_replace('.', '', (string)microtime(true));

    // Generate a random string by appending the timestamp string to a prefix
    $client_id = hash('sha256', 'levartech' . $timestampString);

    // Convert the timestamp to a string and remove the decimal point
    $timestampString = str_replace('.', '', (string)microtime(true));
    $client_secret = hash('sha256', 'levartech' . $timestampString);

    return [
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];
}

function generateToken($client_id, $client_secret) {
    $string = 'levartech%|%' . $client_id . '%|%' . $client_secret . '%|%' . (string)(microtime(true));
    $token = hash('sha256', $string);
    return $token;
}