<?php

$user_id = $_POST['userid'];
$dog_id = $_POST['dogid'];
        
$url_string = 'http://localhost/dogadopt_website/backend/my_backend/index.php/application/create?userid=' . $user_id . '&dogid=' . $dog_id;

$url_string = str_replace ( ' ', '%20', $url_string);

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_URL,
            $url_string);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
                                #curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
$data = curl_exec($ch);
curl_close($ch);

// some action goes here under php
echo json_encode($data);
?>