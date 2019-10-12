<?php
//error_reporting(0);
if (isset($_POST["num"]) || is_numeric($_POST["num"]) || $_POST["num"] > 0){
	if (!is_numeric($_POST["num"])){
		$_POST["num"] = 0;
	}
	require("../config.php");
	$query = "SELECT * FROM setting where id = '1'";
	$query_q = $sqli->query($query);
	$rate = $query_q->fetch_assoc();
	$nnum = $_POST["num"] * (int)$rate["rate"];
	if (is_float($nnum)){
		$nnum = abs(round($nnum));
	}
	
	echo abs($nnum);
}else {
	echo "กรุณากรอกตัวเลข";
}
?>