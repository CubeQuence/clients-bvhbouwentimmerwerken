<?php

//Check valid email
$email_address = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

// Check for empty fields for the email
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message']) || !$email_address) {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Vul AUB alle velden correct in')));
}

//Format body
$message = nl2br($_POST['message']);
$body = '<table style=border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%;background-color:#f6f6f6 border=0 cellpadding=0 cellspacing=0 class=body><tr><td style=font-family:sans-serif;font-size:14px;vertical-align:top> <td style="font-family:sans-serif;font-size:14px;vertical-align:top;display:block;Margin:0 auto;max-width:580px;padding:10px;width:580px"class=container><div class=content style="box-sizing:border-box;display:block;Margin:0 auto;max-width:580px;padding:10px"><span class=preheader style=color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0>Bericht || TA-Soest</span><table style=border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%;background:#fff;border-radius:3px class=main><tr><td style=font-family:sans-serif;font-size:14px;vertical-align:top;box-sizing:border-box;padding:20px class=wrapper><table style=border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100% border=0 cellpadding=0 cellspacing=0><tr><td style=font-family:sans-serif;font-size:14px;vertical-align:top><p style=font-family:sans-serif;font-size:14px;font-weight:400;margin:0;Margin-bottom:15px>Beste Bart,<p style=font-family:sans-serif;font-size:14px;font-weight:400;margin:0;Margin-bottom:15px>Iemand heeft u een bericht gestuurd.<p style=font-family:sans-serif;font-size:14px;font-weight:400;margin:0;Margin-bottom:15px>Gegevens<br>Naam: ' . $_POST['name'] . ',<br>Email: ' . $_POST['email'] . ',<br><br>Bericht:<br><br>' . $message . '</table></table></div><td style=font-family:sans-serif;font-size:14px;vertical-align:top> </table>';

//Config
$config = parse_ini_file('/var/www/bvhbouwentimmerwerken.nl/config.ini');

//Send mail
$curl = curl_init();
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, ['to' => 'bart.vanhaaren@hotmail.com', 'from_name' => 'Contactformulier || BVH','subject' => 'Contactformulier || BVH', 'body' => $body, 'api_key' => $config['api_key']]);
curl_setopt($curl, CURLOPT_URL, "https://api.lucacastelnuovo.nl/mail/");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result, true);

//Throw error if api request failed
if ($result['status'] != 'true') {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode(array('message' => 'Uw bericht is niet verstuurd, probeer het later opnieuw')));
}

die(json_encode(array('status' => true)));
