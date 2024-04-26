<?php

require_once './constants.php';

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://dog-facts2.p.rapidapi.com/facts",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 20,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: dog-facts2.p.rapidapi.com",
		"X-RapidAPI-Key: " . API_KEY_DOG_FACTS
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo $response;
}