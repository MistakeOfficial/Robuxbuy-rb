<?php
session_start();

$password_admin = "30730";//รหัสผ่านระบบหลังร้าน
$tw_name = "";//ชื่อของคุณในทรูวอเล็ท

$db_host = "localhost"; //ip ของฐานข้อมูล (localhost)
$db_user = "root"; //ชื่อผู้ใช้ของฐานข้อมูล
$db_pass = "password"; //รหัสผ่านของฐานข้อมูล
$db_name = "robux"; //ชื่อฐานข้อมูล

$sqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
$sqli->set_charset("utf8");
?>