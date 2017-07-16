<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style >
body {
	background-image: url(../img/back.jpg);
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    float: left;
}

li a, .dropbtn {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}



li.dropdown {
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.active {
    background-color: red;
}
</style>
</head>

<body>
	<ul>
  <li><a class="active" href="home.php">หน้าหลัก</a></li>
  <form id="form2" name="form2" method="post" action="">
  </form>
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">ผู้ใช้งาน</a>
    <div class="dropdown-content">
      <a href="insert_user.php">เพิ่มผู้ใช้งาน</a>
      <a href="insert_admin.php">เพิ่มผู้ดูแลระบบ</a>
      <a href="detail-user.php">รายชื่อผู้ใช้งาน</a>
      <a href="detail-admin.php">รายชื่อผู้ดูแลระบบ</a>
      
  <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">อุปกรณ์</a>
    <div class="dropdown-content">
      <a href="insert_tolls.php">เพิ่มอุปกรณ์</a>
      <a href="detail-tool.php">รายการอุปกรณ์</a>
      <a href="insert_type.php">เพิ่มประเภทอุปกรณ์</a>
      <a href="detail-type.php">ประเภทอุปกรณ์</a>
      
      <li class="dropdown">
    <a href="javascript:void(0)" class="dropbtn">ยืม - คืน</a>
    <div class="dropdown-content">
      <a href="borrow-all.php">ยืมอุปกรณ์</a>
      <a href="list-return.php">คืนอุปกรณ์</a>
    </div>
  </li>

  <li style="float:right"><a href="index.php">ออกจากระบบ</a></li>
</ul>
<form id="form1" name="form1" method="post" action="">
</form>

</body>
</html>