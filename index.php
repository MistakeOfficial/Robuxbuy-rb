<!DOCTYPE html>
<html lang="en">

<head>
  <?php require "config.php"; ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>เว็บขายโรบัคอัตโนมัติ</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<link rel="icon" href="https://lh3.googleusercontent.com/4I5dmTF6gYxovPjwwGxJhLni4PfKuH8FVOZo6wjDMemDXanQP1X-1E3G9KnaNeoR-V0c=w300" type="image/x-icon"/>
<link rel="shortcut icon" href="https://lh3.googleusercontent.com/4I5dmTF6gYxovPjwwGxJhLni4PfKuH8FVOZo6wjDMemDXanQP1X-1E3G9KnaNeoR-V0c=w300" type="image/x-icon"/>
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Mitr&display=swap" rel="stylesheet">

  <style type="text/css">
  	body {
  		background-color: #eee;
  		font-weight: 400px;
  		font-family: 'Mitr', sans-serif;
  	}
  	.fadeInDown {
  -webkit-animation-name: fadeInDown;
  animation-name: fadeInDown;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
}

@-webkit-keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInDown {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(0, -100%, 0);
    transform: translate3d(0, -100%, 0);
  }
  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}
@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

.fadeIn {
  opacity:0;
  -webkit-animation:fadeIn ease-in 1;
  -moz-animation:fadeIn ease-in 1;
  animation:fadeIn ease-in 1;

  -webkit-animation-fill-mode:forwards;
  -moz-animation-fill-mode:forwards;
  animation-fill-mode:forwards;

  -webkit-animation-duration:1s;
  -moz-animation-duration:1s;
  animation-duration:1s;
}

.fadeIn.first {
  -webkit-animation-delay: 0.4s;
  -moz-animation-delay: 0.4s;
  animation-delay: 0.4s;
}

.fadeIn.second {
  -webkit-animation-delay: 0.6s;
  -moz-animation-delay: 0.6s;
  animation-delay: 0.6s;
}

.fadeIn.third {
  -webkit-animation-delay: 0.8s;
  -moz-animation-delay: 0.8s;
  animation-delay: 0.8s;
}

.fadeIn.fourth {
  -webkit-animation-delay: 1s;
  -moz-animation-delay: 1s;
  animation-delay: 1s;
}
  </style>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
</head>

<body class="bg-dark">
<br><br>
 <div class="container">
 	<div class="row justify-content-center">
 		<div class="col-md-5">
 		<?php
  $query = "SELECT * FROM setting where id = '1'";
  $query_q = $sqli->query($query);
  $setting = $query_q->fetch_assoc();
 		if (empty($_POST["payment"])){
 		?>
    <script type="text/javascript">
    now_rb();
    function c_rb(val){
  $.post('api/moneys.php', {num: val}).done(function(response){
      $( "#smn" ).html(response);
});
}
function now_rb(){
  $.post('api/now_rb.php', {}).done(function(response){
    console.log(response);
      $( "#nrb" ).html(response);
      setTimeout(now_rb,3000);
});
}
  </script>
 		<div class="card text-white bg-primary mb-3 fadeInDown" style="border-radius: 0px;">
  <div class="card-header" style="background-color: #20c997;"><i class="fas fa-shopping-cart"></i> ซื้อโรบัคอัตโนมัติ</div>
  <div class="card-body bg-white">
  	<p class="note note-warning text-center" style="color: #000; border-left: 4px solid #fb3!important;"><i class="fas fa-exclamation-triangle"></i> <span class="alert-link" style="font-weight: bold;">คำเตือน</span> <span style="color: #818182;">ก่อนซื้อทุกครั้งต้องเข้ากลุ่มก่อน</span></p>
  	<center><button onclick="window.location.href = '<?= $setting["link"]; ?>';" class="btn btn-amber mt-1"><i class="fas fa-users"></i> เข้ากลุ่ม</button></center>
    <h4 class="text-center"><span class="badge badge-info" id="nrb">กำลังโหลด...</span>&nbsp;<span class="badge badge-warning">เรท <?= $setting["rate"]; ?> / 1 บาท</span></h4>
    <form class="container" method="post" action="">
    	<input type="text" id="defaultRegisterFormLastName" class="form-control" placeholder="ชื่อในเกม" required="" name="name">
    	<input type="text" id="defaultRegisterFormLastName" class="form-control mt-2" placeholder="จำนวนเงิน" required="" id="moneys" onkeyup="c_rb(this.value);" name="num">
    	<input type="hidden" name="payment" value="1">
    	<p style="color: #818182;" class="mt-1 text-center">คุณจะได้รับ Robux จำนวน <span class="badge badge-success" id="smn">0</span> Robux</p>
    	<center><button type="submit" class="btn btn-elegant"><i class="fas fa-credit-card"></i> ชำระเงิน</button></center>
		<p class="text-danger text-center">ซื้อขั้นต่ำ 6 บาท หากต่ำกว่า6บาทให้ทักมา</p>
    </form>
  </div>
</div>
 		<?php
 		}else {	
 		?>
 		<div class="card text-white bg-primary mb-3 fadeInDown" style="border-radius: 0px;">
  <div class="card-header"><i class="fas fa-credit-card"></i> ชำระเงินด้วยทรูวอเล็ท</div>
  <div class="card-body bg-white">
    <center><img src="https://snowboltz.tk/img/tw.png" width="100" height="100"></center>
    <div id="alert_status"></div>
  	<p class="note note-success text-center mt-2" style="color: #000; border-left: 4px solid #00c851!important;"><span class="alert-link text-center" style="font-weight: bold; color: #818182;">ชื่อ : <?= $tw_name; ?></span><br><span class="alert-link text-center" style="font-weight: bold; color: #818182;">โอนไปที่เบอร์ : <?= $setting["tw_phone"]; ?></span><br>*จำนวนเงินที่โอนต้องเท่ากับจำนวนเงินที่ใส่ เท่านั้น!!</p>
    <form class="container" onsubmit="return false" id="s_s">
    	<input type="text" id="ref" class="form-control mt-2 mb-2" placeholder="เลขอ้างอิง" required="" maxlength="14" name="ref">
    	<center><button type="button" onclick="window.location.href = 'index.php';" class="btn btn-warning"><i class="fas fa-backward"></i> ย้อนกลับ</button>&nbsp;<button type="submit" class="btn btn-success" id="b_s"><i class="fas fa-shopping-cart"></i> ชำระเงิน</button></center>
		<p class="text-danger text-center">เมื่อกดยืนยันชำระเงินเสร็จให้รอ 30 วิ-1นาที</p>
    </form>
  </div>
</div>
<script type="text/javascript">
      function op_swal(name,num){
swal({
  title: "ยืนยันคำสั่งซื้อ",
  text: "คุณชื่อ : "+name+", จำนวนเงิน : "+num+" บาท",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    $("#alert_status").html("<div class='alert alert-warning'><i class='fas fa-spinner fa-spin'></i> กำลังดำเนินการ...</div>");
    $("#s_s").attr("disabled","");
    $.post('api/buy.php', {name : name,num : num,ref : $("#ref").val()}).done(function(response){
    console.log(response);
    if (response == "1"){
      swal("สำเร็จ", "เติมเงินสำเร็จกรุณารอคิว", "success").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-1"){
      swal("ไม่สำเร็จ", "เลขอ้างอิงนี้ถูกใช้ไปเเล้ว", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-2"){
      swal("ไม่สำเร็จ", "ไม่พบเลขอ้างอิง", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-3"){
      swal("ไม่สำเร็จ", "ไม่พบชื่อในกลุ่ม", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-4"){
      swal("ไม่สำเร็จ", "สินค้าไม่เพียงพอ", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-5"){
      swal("ไม่สำเร็จ", "กรอกให้เป็นตัวเลขเท่านั้น", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "-7"){
      swal("ไม่สำเร็จ", "จำนวนเงินไม่ตรงกับที่จ่าย", "error").then(() => {
  window.location.href = 'index.php';
});
    }else if (response == "0"){
      swal("ไม่สำเร็จ", "กรอกไม่ครบ", "error").then(() => {
  window.location.href = 'index.php';
});
    }
});
  }
});
} 

$( "#s_s" ).submit(function() {
  op_swal("<?= $_POST["name"] ?>",<?= $_POST["num"] ?>);
  $("#b_s").attr("disabled","");
});
    </script>
 		<?php } ?>
 		</div>
 	</div>
 </div>
 
</body>
<center>
<hr color="#fff" class="col-md-4">
<p class="text-white">Copy Right &copy; 2019 <a href="https://www.facebook.com/zasbos.poko">Peerapat Dev</a></p>
</center>
</html>

