<?php

//$ch = curl_init();
//
//curl_setopt($ch,CURLOPT_URL, 'http://personalsite.test/api/login');
//curl_setopt($ch,CURLOPT_HTTPHEADER, array('Accept: application/json'));
//curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
//curl_setopt($ch, CURLOPT_POST, true);
//curl_setopt($ch, CURLOPT_POSTFIELDS, array(
//    'email' => 'wale_x@hotmail.com',
//    'password' => '123456'
//));
//$response = curl_exec($ch);
//curl_close($ch);
//
////$response = json_decode($response);
//var_dump($response);
//
//exit;

$_POST = json_decode(file_get_contents('php://input'), true);
foreach ($_POST as $key => $value) {
    if (is_array($value)) {
        unset($_POST[$key]);
        foreach ($value as $k => $v) {
            if (is_array($v)) {
                unset($_POST[$key][$k]);
                foreach ($v as $k2 => $v2) {
                    $_POST[$key . '[' . $k . '][' . $k2 . ']'] = $v2;
                }
            } else
                $_POST[$key . '[' . $k . ']'] = $v;
        }
    }
}

$mode = 'personalsite';

$ch = curl_init();

if ($mode == 'personalsite') {
    $token = 'Tti34sJuS2nGc9Zi7tmOkD9IMsZF9QmECa0RyEUABBvZ3hq4jAzoRODBBpgR';
    curl_setopt($ch,CURLOPT_URL, 'http://personalsite.test/api/ajax');
}

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Accept: application/json'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
