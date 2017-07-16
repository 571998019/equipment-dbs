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
<?php include("dw-upload.inc.php"); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form-tool")) {
  $insertSQL = sprintf("INSERT INTO tb_tools (tool_name, tool_code, tool_type, image, tool_store_id, status) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['code'], "text"),
                       GetSQLValueString($_POST['type_log'], "text"),
                       GetSQLValueString(dwUpload($_FILES['img']), "text"),
                       GetSQLValueString($_POST['store'], "int"),
                       GetSQLValueString($_POST['all'], "text"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($insertSQL, $connectioneq) or die(mysql_error());

  $insertGoTo = "detail-tools.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettype = "SELECT * FROM tb_type";
$Recordsettype = mysql_query($query_Recordsettype, $connectioneq) or die(mysql_error());
$row_Recordsettype = mysql_fetch_assoc($Recordsettype);
$totalRows_Recordsettype = mysql_num_rows($Recordsettype);

mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettool = "SELECT * FROM tb_tools";
$Recordsettool = mysql_query($query_Recordsettool, $connectioneq) or die(mysql_error());
$row_Recordsettool = mysql_fetch_assoc($Recordsettool);
$totalRows_Recordsettool = mysql_num_rows($Recordsettool);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetStore = "SELECT * FROM tb_stores";
$RecordsetStore = mysql_query($query_RecordsetStore, $connectioneq) or die(mysql_error());
$row_RecordsetStore = mysql_fetch_assoc($RecordsetStore);
$totalRows_RecordsetStore = mysql_num_rows($RecordsetStore);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Add Tools</title>
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.submits{
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
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

<?php
	if (isset($_POST['btnsubmit']))
	{
		
		move_uploaded_file($_FILES["img"] ["tmp_name"],"../img/".$_FILES["filUpload"]["name"]);
	}
?>



<div>
	<center><h3>เพิ่มอุปกรณ์</h3></center>
  <form method="POST" action="<?php echo $editFormAction; ?>" name="form-tool" enctype="multipart/form-data">
    <p>
      <label for="name"> ชื่ออุปกรณ์ : </label>
      <input type="text" id="name" name="name" placeholder="ชื่ออุปกรณ์..">
      <?php 
	  	if($_GET){
	  ?>
      <label for="code"> รหัสอุปกรณ์ : </label>
      <input type="text" id="code" name="code" placeholder="รหัสอุปกรณ์.." value="<?php echo $_GET['code']; ?>"/>
      <?php
		}else{
	  ?>
      <label for="code"> รหัสอุปกรณ์ : </label>
      <input type="text" id="code" name="code" placeholder="รหัสอุปกรณ์.."/>
       <?php
		}
	  ?>
      
		<!--
      <label for="code"> จำนวน : </label>
      <input type="text" id="item" name="item" placeholder="จำนวน..">
		-->
      
      <label for="type"> ประเภทอุปกรณ์ :</label>
      <label for="type_log"></label>
      <select name="type_log" id="type_log">
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
      
      
       <label for="code"> สถามที่เก็บอุปกรณ์ : </label>
      <select name="store" id="store">
        <?php
do {  
?>
        <option value="<?php echo $row_RecordsetStore['stores_id']?>"><?php echo $row_RecordsetStore['stores_name']?></option>
        <?php
} while ($row_RecordsetStore = mysql_fetch_assoc($RecordsetStore));
  $rows = mysql_num_rows($RecordsetStore);
  if($rows > 0) {
      mysql_data_seek($RecordsetStore, 0);
	  $row_RecordsetStore = mysql_fetch_assoc($RecordsetStore);
  }
?>
      </select>
      

      <label for="img"> รูปประกอบ : </label>
      <input type="file" id="img" name="img" placeholder="เพิ่มอุปกรณ์..">
      
      
    </p>
    <center>
      <br>
    <input type="submit" name="btnsubmit" id="btnsubmit" value="ยืนยัน">
    
  </center>
    <input type="hidden" name="MM_insert" value="form-tool" />
    <input name="all" type="hidden" id="all" value="all" />
  </form>
  <br />
  <center>
  <a href="detail-tools.php?type2=<?php echo $_GET['id_type']; ?>">
    <button type="button" class="submits" style="background-color:#F00">ยกเลิก</button>
    </a>
    </center>
</div>

</body>
</html>
<?php
mysql_free_result($Recordsettype);

mysql_free_result($Recordsettool);

mysql_free_result($RecordsetStore);
?>
