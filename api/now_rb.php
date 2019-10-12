<?php
require("../config.php");
  $query = "SELECT * FROM setting where id = '1'";
  $query_q = $sqli->query($query);
  $setting = $query_q->fetch_assoc();
$curl = curl_init();
curl_setopt($curl, CURLOPT_COOKIE, $setting["cookie"]);
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://economy.roblox.com/v1/groups/".$setting["groups"]."/currency",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Host: economy.roblox.com",
    "Postman-Token: 30b13207-81fc-4a43-906e-e7ea4a1c30b2,ed87ac89-704a-4026-bc71-806eed9e8892",
    "User-Agent: PostmanRuntime/7.15.2",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$robux_balance = json_decode($response);
if ($err) {
  echo "cURL Error #:" . $err;
} else {
	if(isset($robux_balance->robux)){
  echo "Stock ".$robux_balance->robux." Robux";
	}else {
	echo "สินค้าหมด";
	}
} ?>