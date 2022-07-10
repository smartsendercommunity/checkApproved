<?php

ini_set('max_execution_time', '1700');
set_time_limit(1700);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Authorization');
http_response_code(200);

/////////////////////////
$ssToken = "smart token";
/////////////////////////

function send_bearer($url, $token, $type = "GET", $param = []){
    $descriptor = curl_init($url);
     curl_setopt($descriptor, CURLOPT_POSTFIELDS, json_encode($param));
     curl_setopt($descriptor, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($descriptor, CURLOPT_HTTPHEADER, array('User-Agent: M-Soft Integration', 'Content-Type: application/json', 'Authorization: Bearer '.$token)); 
     curl_setopt($descriptor, CURLOPT_CUSTOMREQUEST, $type);
    $itog = curl_exec($descriptor);
    curl_close($descriptor);
    return $itog;
}

$input = json_decode(file_get_contents("php://input"), true);

$checkVar = $input["variable"];
$userId = $input["userId"];

$getUser = json_decode(send_bearer("https://api.smartsender.com/v1/contacts/".$userId."/info", $ssToken), true);

if ($getUser[$checkVar] == true || $getUser[$checkVar] > 1) {
    $result["approve"] = true;
} else {
    $result["approve"] = false;
}


echo json_encode($result);
