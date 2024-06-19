<?php
$recipient_number = '9318419061';
$sender_number = '8130112402';
$message = 'Hello from WhatsApp Business API!';

$token = 'f6dc9ae17b5da12afb5b01fcdb92b3cd-2e211778-aff2-4878-b7a8-2b68051cfb19';

$url = "https://rgp2ky.api.infobip.com";
$headers = [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
];

$data = [
    'from' => $sender_number,
    'to' => $recipient_number,
    'text' => $message,
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Failed to send WhatsApp message: ' . curl_error($ch);
} else {
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code === 202) {
        echo 'WhatsApp message sent successfully!';
    } else {
        echo 'Failed to send WhatsApp message. HTTP Response Code: ' . $http_code;
    }
}

curl_close($ch);
?>
