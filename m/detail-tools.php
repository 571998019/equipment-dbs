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

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettools = "SELECT * FROM tb_tools, tb_type, tb_stores WHERE tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id";
$Recordsettools = mysql_query($query_Recordsettools, $connectioneq) or die(mysql_error());
$row_Recordsettools = mysql_fetch_assoc($Recordsettools);
$colname2_Recordsettools = "''";
if (isset($_GET['search'])) {
  $colname2_Recordsettools = $_GET['search'];
}
$colname3_Recordsettools = "''";
if (isset($_GET['search'])) {
  $colname3_Recordsettools = $_GET['search'];
}
$colname4_Recordsettools = "''";
if (isset($_GET['type2'])) {
  $colname4_Recordsettools = $_GET['type2'];
}
$colname_Recordsettools = "''";
if (isset($_GET['search'])) {
  $colname_Recordsettools = $_GET['search'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettools = sprintf("SELECT * FROM tb_tools inner join tb_type inner join tb_stores on tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_tools.tool_name like %s or tb_tools.tool_code like %s or tb_tools.tool_type = %s or tb_tools.tool_type = %s", GetSQLValueString("%" . $colname_Recordsettools . "%", "text"),GetSQLValueString("%" . $colname2_Recordsettools . "%", "text"),GetSQLValueString($colname3_Recordsettools, "text"),GetSQLValueString($colname4_Recordsettools, "text"));
$Recordsettools = mysql_query($query_Recordsettools, $connectioneq) or die(mysql_error());
$row_Recordsettools = mysql_fetch_assoc($Recordsettools);
$totalRows_Recordsettools = mysql_num_rows($Recordsettools);

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettype = "SELECT * FROM tb_type";
$Recordsettype = mysql_query($query_Recordsettype, $connectioneq) or die(mysql_error());
$row_Recordsettype = mysql_fetch_assoc($Recordsettype);
$totalRows_Recordsettype = mysql_num_rows($Recordsettype);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<title>Tools</title>
<script>
$(function(){
	$("#type2").change(function(){
		window.location ="detail-tools.php?type2=" + $(this).val();
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
</style>
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
      <a class="navbar-brand" href=""><b>Tools Management</b></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li style="background-color:red;"><a href="home.php" style=" color:#000">หน้าหลัก <span class="sr-only">(current)</span></a></li>
       
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">เพิ่มข้อมูลอุปกรณ์<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="insert_tolls.php">เพิ่มอุปกรณ์</a></li>
              <li ><a href="insert_type.php">เพิ่มประเภทอุปกรณ์</a></li>
              <li ><a href="insert_store.php">เพิ่มที่จัดเก็บอุปกรณ์</a></li>
          </ul>
        </li> 
        
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">จัดการข้อมูลอุปกรณ์<span class="caret"></span></a>
          <ul class="dropdown-menu">
              <li ><a href="detail-tools.php">รายชื่ออุปกรณ์</a></li>
              <li ><a href="detail-store.php">รายชื่อที่จัดเก็บอุปกรณ์</a></li>
              <li ><a href="detail-type.php">รายชื่อประเภทอุปกรณ์</a></li>
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
<div style="padding-top:45px">
</div>
<div style="background-color:#FFF; text-align:center">
<div style="background-color:#CCC">
	<form name="search_tool" id="search_tool" action="" method="GET">
  	  <label for="search"><h3>ค้นหาอุปกรณ์</h3></label><br/>
      <input type="text" name="search" id="search"/>
	  <input type="submit" id="btnsearch" value="ค้นหา" />  

  </form><br/>
    <form name="search_tool" id="search_tool" action="" method="GET">
  	<div style="padding-top:1px; padding-bottom:5px">
    
  	   <label for="type"></label>
       <select name="type2" id="type2">
	   <option value="">กรุณาเลือกประเภท</option>
         <?php
do {  
?>
         <option value="<?php echo $row_Recordsettype['type_id']?>"><?php echo $row_Recordsettype['type_name']?></option>
         <?php
} while ($row_Recordsettype = mysql_fetch_assoc($Recordsettype));
  $rows = mysql_num_rows($Recordsettype);
  if($rows > 0) {
      mysql_data_seek($Recordsettype, 0);
	  $row_Recordsettype = mysql_fetch_assoc($Recordsettype);
  }
?>
       </select>
		<!--
		 <input type="submit" id="btnsearch" value="ค้นหา" /> 
		-->
      </div>  
  </form>
</div>
	
	<?PHP  
error_reporting( error_reporting() & ~E_NOTICE );
$_GET['search'] = $_REQUEST['search'];
$_GET['type'] = $_REQUEST['type'];   
	?>
	<?php
	if($_GET['search'] != "" || $_GET['type2'] != ""){    
	?>
	 <?php
		if($totalRows_Recordsettools > 0){
	 ?>
	
<table border="1" width="110%">
  <tr>
  	<!--	<tr>
        <th colspan="6" style="background-color:#CCC">
        <label for="filter"> filter </label>
        <input name="filter" id="filter"type="checkbox" value="filter" />
        </th>
        </tr>-->
        <tr>
          <th colspan="4" style="background-color:#395FEA">รายชื่อที่เก็บอุปกรณ์</th>
          <th style="background-color:#666">ตัวเลือก</th>
        </tr> 
  <tr>
    <th>รหัสอุปกรณ์</th>
    <th>ชื่ออุปกรณ์</th>
    <th>ชื่อประเภท</th>
    <th>สถานที่จัดเก็บ</th>
    <th style="background-color:#FFF; width:10%"><a href="insert_tolls.php">
      <button type="button">เพิ่ม</button>
    </a></th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordsettools['tool_code']; ?></td>
      
      <td>
      	<?php 
			if($row_Recordsettools['image']!=""){
		?>
          <img src="../img/<?php echo $row_Recordsettools['image']; ?>" width="100" height="70" style="border:1px; border-color:#000;border-style: solid;"/>
          <?php 
			}
		  ?>
       <br />
	  <?php echo $row_Recordsettools['tool_name']; ?>
      </td>
      
      <td width="20%"><?php echo $row_Recordsettools['type_name']; ?></td>
      <td><?php echo $row_Recordsettools['stores_name']; ?></td>
      <td>
      <a href="delete-tool.php?tool_id=<?php echo $row_Recordsettools['tool_id']; ?>">
      <button type="button">ลบ</button>
      </a>
      <a href="update-tool.php?tool_id=<?php echo $row_Recordsettools['tool_id']; ?>&amp;store=<?php echo $row_Recordsettools['stores_name']; ?>&amp;type=<?php echo $row_Recordsettools['type_name']; ?>&amp;id_type=<?php echo $row_Recordsettools['type_id']; ?>&amp;id_store=<?php echo $row_Recordsettools['stores_id']; ?>&amp;type2=<?php echo $row_Recordsettools['type_id']; ?>">
      <button type="button" >แก้ไข</button>
      </a>
      </td>
    </tr>
    <?php } while ($row_Recordsettools = mysql_fetch_assoc($Recordsettools)); ?>
</tr>
</table>
 <?php
	}else{
  ?>
  	<br />

  <table border="1">
  <tr>
  	<tr>
    <th colspan="6" style="background-color:#395FEA">ผลการค้นหา</th>
    </tr>
    <tr>
      <th>รหัสอุปกรณ์</th>
      <th>ชื่ออุปกรณ์</th>
      <th>ประเภท</th>
      <th>สถานที่เก็บ</th>
      <th>ตัวเลือก</th>
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
			<th colspan="6" style="background-color:#395FEA">ผลการค้นหา</th>
		</tr>
		<tr>
		  <th>รหัสอุปกรณ์</th>
		  <th>ชื่ออุปกรณ์</th>
		  <th>ประเภท</th>
		  <th>สถานที่เก็บ</th>
		  <th>ตัวเลือก</th>
		</tr>
 </tr>
   </table>
   <p>ไม่พบข้อมูล</p>
  <?php
	}
  ?>
	
	
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>
<?php
mysql_free_result($Recordsettools);

mysql_free_result($Recordsettype);
?>
