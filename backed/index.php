<!DOCTYPE html>
<html lang="en">

<head>
  <?php require "../config.php"; ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>จัดการ</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="../css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="../css/style.css" rel="stylesheet">
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
  <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="../js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="../js/mdb.min.js"></script>
  


</head>

<body class="bg-dark">
<br><br>
 <div class="container">
 	<div class="row justify-content-center">
 		<div class="col-md-8">
 		<?php
    if (isset($_SESSION["admin"])){
    ?>
    <?php
  $query = "SELECT * FROM setting where id = '1'";
  $query_q = $sqli->query($query);
  $setting = $query_q->fetch_assoc();
    ?>
    <div class="card text-white bg-primary mb-3 fadeInDown" style="border-radius: 0px;">
  <div class="card-header" style="background-color: #20c997;"><i class="fas fa-cog"></i> Backed จัดการระบบ </div>
  <div class="card-body bg-white">
    <style type="text/css">
      label {
        color: #000;
      }
    </style>
    <?php
    if (isset($_POST["save_admin"])){
      $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
      $save_cmd = "UPDATE setting SET rate = :rate,link = :link,groups = :groups,tw_ref = :tw_ref,tw_name = :tw_name,tw_phone = :tw_phone,email = :email,password = :password,cookie = :cookie where id = '1'";
      $save_exec = $pdo->prepare($save_cmd);
      $save_exec->execute(Array(
        ":rate" => $_POST["rate"],
        ":link" => $_POST["link"],
        ":groups" => $_POST["groups"],
        ":tw_ref" => $_POST["tw_ref"],
        ":tw_name" => $_POST["tw_name"],
        ":tw_phone" => $_POST["tw_phone"],
        ":email" => $_POST["email"],
        ":password" => $_POST["password"],
        ":cookie" => $_POST["cookie"]
      ));
      ?>
          <script type="text/javascript">
            swal("สำเร็จ", "บันทึกเรียบร้อยเเล้ว", "success").then((value) => {
  window.location.href = '';
});
          </script>
          <?php
    }
    ?>
    <form action="" method="post" name="save">
    <center class="col-md-12">
      <label>เรท</label><br>
     <input type="number" name="rate" value="<?= $setting["rate"] ?>" class="form-control"><br> 
     <label>Link กลุ่ม</label><br>
     <input type="text" name="link" value="<?= $setting["link"] ?>" class="form-control"><br> 
     <label>id กลุ่ม</label><br>
     <input type="number" name="groups" value="<?= $setting["groups"] ?>" class="form-control"><br> 
     <label>Truewallet Ref token</label><br>
     <input type="text" name="tw_ref" value="<?= $setting["tw_ref"] ?>" class="form-control"><br> 
     <label>Truewallet Name</label><br>
     <input type="text" name="tw_name" value="<?= $setting["tw_name"] ?>" class="form-control"><br> 
     <label>Truewallet Phone</label><br>
     <input type="number" name="tw_phone" value="<?= $setting["tw_phone"] ?>" class="form-control"><br> 
     <label>Truewallet Email/phone</label><br>
     <input type="text" name="email" value="<?= $setting["email"] ?>" class="form-control"><br> 
     <label>Truewallet Password/Pin</label><br>
     <input type="text" name="password" value="<?= $setting["password"] ?>" class="form-control"><br> 
     <textarea placeholder="cookie" name="cookie" class="form-control" rows="3">
       <?= $setting["cookie"] ?>
     </textarea>
     <input type="hidden" name="save_admin" value="1">
     <br><button type="button" onclick="window.location.href = '../index.php';" class="btn btn-warning"><i class="fas fa-backward"></i> ย้อนกลับ</button>&nbsp;<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> บันทึก</button>
    </center>
    </form>
  </div>
</div>
    <?php
  }else {
    ?>
<div class="card text-white bg-primary mb-3 fadeInDown" style="border-radius: 0px;">
  <div class="card-header" style="background-color: #20c997;"><i class="fas fa-cog"></i> จัดการ</div>
  <div class="card-body bg-white">
    <style type="text/css">
      label {
        color: #000;
      }
    </style>
    <?php
    if (isset($_POST["login"])){
      if (isset($_POST["password"])){
        if ($_POST["password"] == $password_admin){
          $_SESSION["admin"] = "1";
          ?>
          <script type="text/javascript">
            swal("สำเร็จ", "รหัสผ่านถูกต้อง", "success").then((value) => {
  window.location.href = '';
});
          </script>
          <?php
        }
      }
    }
    ?>
    <form action="" method="post" name="save">
    <center class="col-md-12">
      <label>รหัสผ่าน</label><br>
     <input type="text" name="password" class="form-control" placeholder="รหัสผ่าน"><br> <input type="hidden" name="login" value="1">
     <br><button type="button" onclick="window.location.href = '../index.php';" class="btn btn-warning"><i class="fas fa-backward"></i> ย้อนกลับ</button>&nbsp;<button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> เข้าหน้าadmin</button>
    </center>
    </form>
  </div>
</div>
    <?php 
  }
    ?>
 		</div>
 	</div>
 </div>
 
</body>
<center>
<hr color="#fff" class="col-md-4">
<p class="text-white">Copy Right &copy; 2019 <a href="https://www.facebook.com/zasbos.poko">Peerapat Dev</a></p>
</center>
</html>

