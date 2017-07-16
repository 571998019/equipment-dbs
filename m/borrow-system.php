<?php require_once('../Connections/connectioneq.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname_Recordset1 = $_GET['search'];
}
$colname2_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname2_Recordset1 = $_GET['search'];
}
$colname3_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname3_Recordset1 = $_GET['search'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordset1 = sprintf("SELECT * FROM tb_tools inner join tb_type inner join tb_stores on tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_tools.tool_name LIKE %s or tb_tools.tool_code LIKE %s or tb_type.type_name Like %s", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname2_Recordset1 . "%", "text"),GetSQLValueString("%" . $colname3_Recordset1 . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $connectioneq) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettypes = "SELECT * FROM tb_type";
$Recordsettypes = mysql_query($query_Recordsettypes, $connectioneq) or die(mysql_error());
$row_Recordsettypes = mysql_fetch_assoc($Recordsettypes);
$totalRows_Recordsettypes = mysql_num_rows($Recordsettypes);

$colname_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname_Recordset1 = $_GET['search'];
}
$colname4_Recordset1 = "''";
if (isset($_GET['type'])) {
  $colname4_Recordset1 = $_GET['type'];
}
$colname2_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname2_Recordset1 = $_GET['search'];
}
$colname3_Recordset1 = "''";
if (isset($_GET['search'])) {
  $colname3_Recordset1 = $_GET['search'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordset1 = sprintf("SELECT * FROM tb_tools inner join tb_type inner join tb_stores on tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_tools.tool_name like %s or tb_tools.tool_code = %s or tb_tools.tool_type = %s or tb_tools.tool_type = %s", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"),GetSQLValueString($colname2_Recordset1, "text"),GetSQLValueString($colname3_Recordset1, "text"),GetSQLValueString($colname4_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $connectioneq) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title> B&R </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../bootstrap/w3/w3.css">
<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
<script src="../bootstrap/systemborrow/jquery.min.js"></script>
<script src="../bootstrap/systemborrow/bootstrap.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>﻿-->
<script>
$(function(){
	$("#type").change(function(){
		window.location ="borrow-system.php?type=" + $(this).val();
		});
	});
</script>
	
<style>
table {
	border-collapse: collapse;
	width: 100%;
	text-align: center;
}

th, td {
	text-align: center;
	padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
	background-color: #4CAF50;
	color: white;
	text-align: center;
}
body,h1,h2,h3,h4,h5 {
	/*font-family: "Poppins", sans-serif*/
	}
body {
	font-size:16px;
	}
.w3-half img{
	margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer
	}
.w3-btnxx{
	margin-top:10px;
	margin-bottom:10px;
	}
.w3-half img:hover{
	opacity:1
	}
</style>


<body style="background-color:#CCC">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-teal w3-collapse w3-top w3-large w3-padding" style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft" style="width:100%;font-size:22px">ปิดเมนู</a>
  <div class="w3-bar-block" style="border:5px; padding-top:20px; margin-right:20px">
  <table border="1px">
      <tr>
          <th style="background-color:#333;">
          <h2>ยืมอย่างรวดเร็ว</h2>
            <form name="form-fastborrow" id="form-fastborrow"  action="fast-borrow-table.php" method="POST">
              <p align="left">
                <label>รหัสนักศึกษา :</label>
                <input name="member_id"  id="member_id" type="text" placeholder="Example:5719980XX" style="width:220px"/>
              </p>
                
              <p align="left">
                <label>รหัสอุปกรณ์ :</label>
                <input name="code_id"  id="code_id" type="text" placeholder="Example:123456" style="width:220px" />
              </p>
              <p>
                <input class="w3-btnxx" type="submit" value="ยืมอุปกรณ์" />
                <input  type="reset" />
              </p>
            </form>
            </th>
        </tr>
    </table>
    <table>
    <tr>
    	<td>
        	<a href="home.php">
        	<button type="button">หน้าหลัก</button>
       	</a>        </td>
    </tr>
    </table>
  </div>
</nav>


<!-- Top menu on small screens -->
<!--
<header class="w3-container w3-top w3-hide-large w3-red w3-xlarge w3-padding">
  <a href="javascript:void(0)" class="w3-button w3-red w3-margin-right" onclick="w3_open()">☰</a>
  <span><i class="fa fa-hand-o-left" style="font-size:24px"></i>&nbsp;ยืมอย่างรวดเร็ว</span>
</header>
-->

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:340px;margin-right:40px;">
<div style=" padding-bottom:25%" align="center">
  <form name="search_tool" id="search_tool" action="" method="GET">
  	<div style="padding-top:8px">
    </div>
  	<p><br/>
  	  <label for="search"><h3>ค้นหาอุปกรณ์</h3></label>
       <a href="home.php"><button type="button" class="btn-primary">หน้าหลัก</button></a>&nbsp;<!--
  	  --><input type="text" name="search" id="search" placeholder="ชื่ออุปกรณ์หรือรหัสอุปกรณ์"/>
		 <input type="submit" id="btnsearch" value="ค้นหา" />  

    </p>
  </form>
    <form name="search_tool" id="search_tool" action="" method="GET">
  	<div style="padding-top:1px; padding-bottom:5px">
    
  	   <label for="type"></label>
       <select name="type" id="type">
	   <option value="">กรุณาเลือกประเภท</option>
		<?php
        do {  
        ?>
        <option value="<?php echo $row_Recordsettypes['type_id']?>"><?php echo $row_Recordsettypes['type_name']?></option>
        <?php
        } while ($row_Recordsettypes = mysql_fetch_assoc($Recordsettypes));
        $rows = mysql_num_rows($Recordsettypes);
        if($rows > 0) {
        mysql_data_seek($Recordsettypes, 0);
        $row_Recordsettypes = mysql_fetch_assoc($Recordsettypes);
        }
        ?>
       </select>
		<!--
		 <input type="submit" id="btnsearch" value="ค้นหา" />
		-->
       </div>  
  </form>
<?PHP  
    error_reporting( error_reporting() & ~E_NOTICE );
    $_GET['search'] = $_REQUEST['search'];
	$_GET['type'] = $_REQUEST['type'];   
?>

<?php
if($_GET['search'] != "" || $_GET['type'] != ""){    
?>
	<?php
		if($totalRows_Recordset1 > 0){
	 ?>
  <table border="1">
  <tr>
  	<tr>
    <th colspan="6">ผลการค้นหา</th>
    </tr>
    <tr>
      <td>รหัสอุปกรณ์</td>
      <td>ชื่ออุปกรณ์</td>
      <td>ประเภท</td>
      <td>สถานที่เก็บ</td>
      <td>ตัวเลือก</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_Recordset1['tool_code']; ?></td>
        <td>
		<?php 
			if($row_Recordset1['image']!=""){
		?>
          <img src="../img/<?php echo $row_Recordset1['image']; ?>" width="100" height="70" style="border:1px; border-color:#000;border-style: solid;"/><br/>
          <?php 
			}
		  ?>
          
          <?php echo $row_Recordset1['tool_name']; ?></td>
        <td><?php echo $row_Recordset1['type_name']; ?></td>
        <td><?php echo $row_Recordset1['stores_name']; ?></td>
        <td>
          <a href="fast-borrow-table.php?code_id=<?php echo $row_Recordset1['tool_code']; ?>">
            <button type="button" >ยืมอุปกรณ์</button>
          </a>        </td>
      </tr>
      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </tr>
  </table>
	
	<?php
	}else{
  	?>
  	<br />

  <table border="1">
  <tr>
  	<tr>
    <th colspan="6">ผลการค้นหา</th>
    </tr>
    <tr>
      <td>รหัสอุปกรณ์</td>
      <td>ชื่ออุปกรณ์</td>
      <td>ประเภท</td>
      <td>สถานที่เก็บ</td>
      <td>ตัวเลือก</td>
    </tr>
   </tr>
   </table>
   <p>ไม่พบข้อมูล</p>
  <?php
	}
  ?>
	
<?php
}else{
?><br />

  <table border="1">
  <tr>
  	<tr>
    <th colspan="6">ผลการค้นหา</th>
    </tr>
    <tr>
      <td>รหัสอุปกรณ์</td>
      <td>ชื่ออุปกรณ์</td>
      <td>ประเภท</td>
      <td>สถานที่เก็บ</td>
      <td>ตัวเลือก</td>
    </tr>
   </tr>
   </table>
   <p>ไม่พบข้อมูล</p>
  <?php
	}
  ?>
  
 </div>
<div id="result"></div>

<!-- End page content -->
</div>
<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
}

</script>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordsettypes);
?>
