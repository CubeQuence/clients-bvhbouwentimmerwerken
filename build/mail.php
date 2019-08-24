<?php

$client_id = getenv('CLIENT_ID');
$client_secret = getenv('CLIENT_SECRET');

if ('POST' != $_SERVER['REQUEST_METHOD']) {
    echo json_encode(['status' => false]);
    exit;
}

function request($url, $data)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);

    return json_decode($result, true);
}

$body = nl2br($_POST['body']);
$response = request(
    'https://api.lucacastelnuovo.nl/mail/',
    [
        'access_token' => request(
            'https://accounts.lucacastelnuovo.nl/auth/token',
            [
                'grant_type' => 'client_credentials',
                'client_id' => "{$client_id}",
                'client_secret' => "{$client_secret}",
            ]
        )['access_token'],
        'to' => 'ltcastelnuovo@gmail.com',
        'subject' => "{$_POST['subject']}",
        'body' => "{$body}",
        'from_name' => 'BVH Bouw en Timmerwerken',
    ]
);

echo json_encode(['success' => $response['success']]);
exit;
