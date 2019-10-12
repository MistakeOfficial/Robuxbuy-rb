<?php
if (isset($_POST["ref"])|| isset($_POST["num"]) || is_string($_POST["name"]) || isset($_POST["name"])){

	if (is_numeric($_POST["ref"]) || is_numeric($_POST["num"])){

ini_set('max_execution_time', 300);
require_once("truewallet.php");
require '../config.php';
$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$pdo->exec("set names utf8");
$query = "SELECT * FROM setting where id = '1'";
$query_q = $sqli->query($query);
$setting = $query_q->fetch_assoc();
$username = $setting["email"];
$password = $setting["password"];
$tw = new TrueWallet($username, $password, $setting["tw_ref"]);
$tw->curl_options = array(
	CURLOPT_SSL_VERIFYPEER => false
);
$identity_file = dirname(__FILE__)."/".md5($username).".identity";
if (!file_exists($identity_file)){
	file_put_contents($identity_file,$tw->generate_identity());
} else {
	list($tw->device_id,$tw->mobile_tracking) = explode("|",file_get_contents($identity_file));
}
$tw->Login();
$cmd_tw = "SELECT * FROM payment_tw WHERE ref = :ref";
    $query_tw = $pdo->prepare($cmd_tw);
    $query_tw->execute(Array(
      ":ref" => $_POST['ref']
    ));
    $payment_tw = $query_tw->rowCount();
if ($payment_tw < 1){
	$ref_tw_success = "INSERT INTO payment_tw (id,ref) VALUES ('',:ref)";
    $query_ref_success = $pdo->prepare($ref_tw_success);
    $query_ref_success->execute(Array(
      ":ref" => $_POST['ref']
    ));
$transactions = $tw->getTransaction(15);
foreach ($transactions["data"]["activities"] as $report) {
	$data = $tw->GetTransactionReport($report["report_id"]);
	if ($data["data"]["service_code"] == "creditor"){
		$amount = $data["data"]["amount"];
		$ref = $data["data"]["section4"]["column2"]["cell1"]["value"];
		if ($_POST['ref'] === $ref){
$wt = 1;
			$moneys = $data["data"]["amount"];
	    }
	}
}
if (empty($wt)){
	echo "-2";//ไม่พบเลขอ้างอิง
}
if (isset($wt)){
	if ($moneys == $_POST["num"]){
$robux = abs($_POST["num"] * $setting["rate"]);
$player_v = $_POST["name"];
$group = $setting["groups"];
$cookie = $setting["cookie"];
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

$response95 = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
$robux_balance = json_decode($response95);
$curl5 = curl_init();
curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl5, CURLOPT_FOLLOWLOCATION, 1); // allow redirects 
curl_setopt($curl5, CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl5, CURLOPT_MAXREDIRS,5); 


curl_setopt_array($curl5, array(
  CURLOPT_URL => "https://groups.roblox.com/v1/groups/".$setting["groups"]."/users?limit=100",
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

$response1 = curl_exec($curl5);
$err = curl_error($curl5);

curl_close($curl5);
$json = json_decode($response1, true);
$np = $json["nextPageCursor"];
if ($np != null){
	$ct = file_get_contents("https://groups.roblox.com/v1/groups/".$setting["groups"]."/users?limit=100&cursor=".$np);
	$ct1 = json_decode($ct);
	if ($ct1["nextPageCursor"] != null){
	$ct1 = file_get_contents("https://groups.roblox.com/v1/groups/".$setting["groups"]."/users?limit=100&cursor=".$np);
	$ct11 = json_decode($ct1);
	$j_all1 = array_push($json , $ct1);
	$j_all = array_push($j_all1 , $ct11);
}else {
	$j_all = array_push($json , $ct1);
	}
}
$j_all = $json["data"];
foreach($j_all as $player){
	if ($player["user"]["username"] == $_POST["name"]){
		$player_status = 1;
		$player_id = $player["user"]["userId"];
	}
} 
if ($robux_balance->robux >= $robux){
	if (isset($player_id)){
$ref_tw = "INSERT INTO queue (id,player,amount,status) VALUES ('',:player,:amount,'unpay')";
    $query_ref = $pdo->prepare($ref_tw);
    $query_ref->execute(Array(
      ":player" => $player_v,
      ":amount" => $robux
    ));
echo "1";
}else {
	echo "-3";//ไม่พบชื่อในกลุ่ม
}
}else {
	echo "-4";//สินค้าไม่เพียงพอ
}
	}else {
	echo "-7";//เงินไม่ตรงกับที่จ่าย
	}
}

}else {
	$ref_tw = "INSERT INTO payment_tw (id,ref) VALUES ('',:ref)";
    $query_ref = $pdo->prepare($ref_tw);
    $query_ref->execute(Array(
      ":ref" => $_POST['ref']
    ));
	echo "-1";//ถูกใช้เเล้ว
}
}else {
	echo "-5";//กรอกให้เป็นเลข
}
	
}else {
	echo "0";//กรอกไม่ครบ
}
$pdo = null;
?>