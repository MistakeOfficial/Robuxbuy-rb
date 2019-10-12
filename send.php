<?php
function send_robux($robux,$username,$player_v,$group,$cookie){
$curl56 = curl_init();
curl_setopt($curl56, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl56, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
curl_setopt($curl56, CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl56, CURLOPT_MAXREDIRS,5); 


curl_setopt_array($curl56, array(
  CURLOPT_URL => "https://groups.roblox.com/v1/groups/".$group."/users?limit=100",
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
    "User-Agent: PostmanRuntime/7.15.2",
    "cache-control: no-cache",
    "Content-Type: application/json",
    "Cookie: ".$cookie
  ),
));

$response13 = curl_exec($curl56);
$err = curl_error($curl56);

curl_close($curl56);
$json = json_decode($response13, true);
foreach($json["data"] as $player){
	if ($player["user"]["username"] == $player_v){
		$player_status = 1;
		$player_id = $player["user"]["userId"];
	}
}
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://groups.roblox.com/v1/groups/".$group."/payouts",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n  \"PayoutType\": \"FixedAmount\",\r\n  \"Recipients\": [\r\n    {\r\n      \"recipientId\": ".$player_id.",\r\n      \"recipientType\": \"User\",\r\n      \"amount\": ".$robux."\r\n    }\r\n  ]\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "cookie: ".$cookie,
    "x-csrf-token: dfsd"
  ),
));
curl_setopt($curl, CURLOPT_HEADER, 1);
$response = curl_exec($curl);
$err = curl_error($curl);
$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
  $headers = substr($response, 0, $header_size);
  $body = substr($response, $header_size);
curl_close($curl);
$headers = explode("\r\n", $headers); // The seperator used in the Response Header is CRLF (Aka. \r\n) 

$headers = array_filter($headers);

$header = explode(":", $headers[6]);
$curl5 = curl_init();
curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl5, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
curl_setopt($curl5, CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl5, CURLOPT_MAXREDIRS,5); 
$curl18 = curl_init();

curl_setopt_array($curl18, array(
  CURLOPT_URL => "https://groups.roblox.com/v1/groups/".$group."/payouts",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 300,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\r\n  \"PayoutType\": \"FixedAmount\",\r\n  \"Recipients\": [\r\n    {\r\n      \"recipientId\": ".$player_id.",\r\n      \"recipientType\": \"User\",\r\n      \"amount\": ".$robux."\r\n    }\r\n  ]\r\n}",
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/json",
    "cookie: ".$cookie,
    "x-csrf-token: ".$header[1]
  ),
));
$response12 = curl_exec($curl18);
$err2 = curl_error($curl18);
curl_close($curl18);
}
$argv[1] = "c25vd2JvbHR6LnRrX3phc3hjdl9rdXlfY2NtZGRoamZraGRzZmdqa2hka2ZnaGRmaA";
if (isset($argv[1])){
	if ($argv[1] == "c25vd2JvbHR6LnRrX3phc3hjdl9rdXlfY2NtZGRoamZraGRzZmdqa2hka2ZnaGRmaA"){
require "config.php";
		$pdo = new PDO('mysql:host=localhost;dbname='.$db_name,$db_user, $db_pass);
$pdo->exec("set names utf8");
$link_cmd = "SELECT * FROM setting where id = '1'";
$link_exec = $pdo->prepare($link_cmd);
$link_exec->execute();
$link = $link_exec->fetch(PDO::FETCH_ASSOC);
	$runq_cmd = "SELECT * FROM queue where status = 'unpay'";
	$runq_exec = $pdo->prepare($runq_cmd);
	$runq_exec->execute();
	$runq_list = $runq_exec->rowCount();
	if ($runq_list > 0){
		while ($runq = $runq_exec->fetch()){
			
	    $pay_cmd = "UPDATE queue SET status = 'paid' where id = '{$runq["id"]}'";
		$pay_exec = $pdo->prepare($pay_cmd);
		$pay_exec->execute();
		send_robux($runq["amount"],'500dfs',$runq["player"],$setting["groups"],$setting["cookie"]);
			
		}
	}
	}
}
?>