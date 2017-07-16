<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Title -->
<title>ระบบจัดการสมาชิก</title>

<!-- Bootstrap -->
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../bootstrap/justified-nav.css/justified-nav.css" rel="stylesheet" type="text/css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
     <!-- Nav -->
     <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false" style="color:#FFF">
        <span class="sr-only">Toggle navigation</span>
        เมนู
      </button>
      <a class="navbar-brand" href="index-member.php"><b>Member Management</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li style="background-color:red;"><a href="home.php" style=" color:#000">หน้าหลัก <span class="sr-only">(current)</span></a></li>
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">เพิ่มข้อมูลสมาชิก<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="insert_user.php">เพิ่มผู้ใช้งาน</a></li>
              <li ><a href="insert_admin.php">เพิ่มผู้ดูแลระบบ</a></li>
              <li ><a href="insert-faculty.php">เพิ่มสำนักวิชา/คณะ</a></li>
              <li ><a href="insert-major.php">เพิ่มโปรแกรมวิชา</a></li>
              <li ><a href="insert-class.php">เพิ่มชั้นปี</a></li>
          </ul>
        </li> 
        
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">จัดการข้อมูลสมาชิก<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="detail-user.php">รายชื่อผู้ใช้งาน</a></li>
              <li ><a href="detail-admin.php">รายชื่อผู้ดูแลระบบ</a></li>
              <li ><a href="detail-faculty.php">รายชื่อสำนักวิชา/คณะ</a></li>
              <li ><a href="detail-major.php">รายชื่อโปรแกรมวิชา</a></li>
              <li ><a href="detail-class.php">รายชื่อชั้นปี</a></li>
          </ul>
        </li> 
        
        <!-- dropdown 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li> End dropdown -->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div style="padding-top:14px">
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>