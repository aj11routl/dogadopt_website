<?php

$dog_id = $_POST['dogid'];      

$url_string = 'http://localhost/dogadopt_website/backend/my_backend/index.php/dog/delete?dogid=' . $dog_id;

$url_string = str_replace ( ' ', '%20', $url_string);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_string);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$data = curl_exec($ch);
curl_close($ch);

// some action goes here under php
echo json_encode($data);

    
?>