<?php

$client_id = 'CLIENT_ID';
$client_secret = 'CLIENT_SECRET';

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

if ('POST' != $_SERVER['REQUEST_METHOD']) {
    echo json_encode(['status' => false]);
    exit;
}

echo json_encode($_POST); exit;

request(
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
        'to' => 'info@bvh-bouwentimmerwerken.nl',
        'subject' => "{$_POST['subject']}",
        'body' => "{$_POST['body']}",
        'from_name' => 'BVH Bouw en Timmerwerken',
    ]
);

echo json_encode(['status' => true]);
exit;
