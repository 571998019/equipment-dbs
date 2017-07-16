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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tb_borrow (b_user_id, b_tool_id, b_date_return) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['hiddenField'], "int"),
                       GetSQLValueString($_POST['hiddenField2'], "int"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($insertSQL, $connectioneq) or die(mysql_error());

  $insertGoTo = "borrow-list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tb_borrow_his (b_his_user_id, b_his_tool_id, b_his_return) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['hiddenField'], "int"),
                       GetSQLValueString($_POST['hiddenField2'], "int"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($insertSQL, $connectioneq) or die(mysql_error());
}

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

$colname_Recordset1 = "-1";
if (isset($_REQUEST['member_id'])) {
  $colname_Recordset1 = $_REQUEST['member_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordset1 = sprintf("SELECT * FROM tb_user inner join tb_class inner join tb_faculty inner join tb_major on tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id WHERE student_id_log = %s or tb_user.personal_id = %s", GetSQLValueString($colname_Recordset1, "text"),GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $connectioneq) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$colname_RecordsetTool = "-1";
if (isset($_REQUEST['code_id'])) {
  $colname_RecordsetTool = $_REQUEST['code_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetTool = sprintf("SELECT * FROM tb_tools inner join tb_type inner join tb_stores on tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tool_code = %s ", GetSQLValueString($colname_RecordsetTool, "text"));
$RecordsetTool = mysql_query($query_RecordsetTool, $connectioneq) or die(mysql_error());
$row_RecordsetTool = mysql_fetch_assoc($RecordsetTool);
$totalRows_RecordsetTool = mysql_num_rows($RecordsetTool);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FastBorrow</title>
<link rel="stylesheet" href="../bootstrap/w3/w3.css">
<style>
td{
	text-align:left;
	}
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
</style>
</head>
	
<body style="background-image:url(../img/back.jpg)">
		

   <div align="center">
     <form name="formid" id="formid" method="POST" action="">
            <table>
                <tr valign="baseline">
                  <td><input type="text" placeholder="รหัสนักศึกษา" name="member_id" size="32"  /></td>
                    <td><input type="submit" value="ยืนยัน" /></td>
              </tr>
       </table>
            <input name="code_id" type="hidden" id="hiddenField3" value="<?php echo $row_RecordsetTool['tool_code']; ?>" />
       </form>
	</div>
<div>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>&user_id=<?php echo $row_Recordset1['id_log']; ?>">
           <div class=" w3-row w3-border" style="padding-top:5px; background-color:#CCC">
            <div class="w3-half" align="right" style="padding-right:5px; padding-bottom:5px">
               <table border="0">
               <tr>
                    <th colspan="2" style="font-size:18px">รายระเอียดคนยืมอุปกรณ์
                    <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordset1['id_log']; ?>" /></th>
               </tr>
                <th colspan="2">
                <?php 
				if($row_RecordsetTool['image']!=""){
				?>
                    <p><img src="../img/<?php echo $row_RecordsetTool['image']; ?>" width="100" height="70" style="border:1px; border-color:#000;border-style: solid;"/></p>
                <?php
                   }
				 ?>
                 </th>
                  
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">ชื่อ-สกุล :</td>
                  <td><input type="text" disabled="disabled" name="Borrower_name" value="<?php echo $row_Recordset1['name_log']; ?>" size="32"  /></td>
                </tr>
                
                <tr valign="baseline">
                  <td nowrap="nowrap" align="right">รหัสนักศึกษา :</td>
                  <td><input name="Borrower_id" disabled="disabled" type="text" value="<?php echo $row_Recordset1['student_id_log']; ?>" size="32" /></td>
                </tr>
                
              <tr>               
              <tr valign="baseline">
                  <td nowrap="nowrap" align="right">รหัสอุปกรณ์ :</td>
                  <td><input type="text" disabled="disabled" name="tool_code" value="<?php echo $row_RecordsetTool['tool_code']; ?>" size="32"  /></td>
              </tr>
                
                 <tr valign="baseline">
                  <td nowrap="nowrap" align="right">ชื่ออุปกรณ์ :</td>
                  <td><input type="text" disabled="disabled" name="tool_name" value="<?php echo $row_RecordsetTool['tool_name']; ?>" size="32"  /></td>
                </tr>
                
                <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">ชั้นปี :</td>-->
                  <td><input name="Borrower_class" type="hidden" disabled="disabled" value="<?php echo $row_Recordset1['class_name']; ?>" size="32"  /></td>
                </tr>
                
                <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">สำนักวิชา/คณะ :</td>-->
                  <td><input type="hidden" disabled="disabled" name="Borrower_faculty" value="<?php echo $row_Recordset1['faculty_name']; ?>" size="32"  /></td>
                </tr>
                
                <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">สาขา :</td>-->
                  <td><input type="hidden" disabled="disabled" name="Borrower_major" value="<?php echo $row_Recordset1['major_name']; ?>" size="32"  /></td>
                </tr>
                
                 <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">เบอร์โทร :</td>-->
                  <td><input type="hidden" disabled="disabled" name="Borrower_tel" value="<?php echo $row_Recordset1['tel_log']; ?>" size="32"  /></td>
                </tr>
                 
                 <tr>
                <th colspan="2"><!--รายระเอียดอุปกรณ์ที่ยืม-->
                  <input name="hiddenField2" type="hidden" id="hiddenField2" value="<?php echo $row_RecordsetTool['tool_id']; ?>" /></th>
           		</tr>
                 <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">ชื่อประเภท :</td>-->
                  <td><input type="hidden" disabled="disabled" name="tool_type" value="<?php echo $row_RecordsetTool['type_name']; ?>" size="32"  /></td>
                </tr>
                
                <tr valign="baseline"><!--
                  <td nowrap="nowrap" align="right">สถานที่จัดเก็บ :</td>-->
                  <td><input type="hidden" disabled="disabled" name="tool_store" value="<?php echo $row_RecordsetTool['stores_name']; ?>" size="32"  /></td>
                </tr>     
                </th>
            </table>
            <?php
            	$date = date("Y/m/d");
				$date1 = str_replace('-', '/', $date);
				$tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
			?>
            <label for="dates"><b style="color:#F00; font-size:18px">กำหนดวันคืน :</b></label>
            <input id="dates" name="date" type="date" value="<?php echo $tomorrow; ?>"/>
           </div>
           </div>
     <center>
       <table>
             <tr>
             	<th>
         	   	 <input type="submit" value="ยืนยัน"/>
                </th>
                <th>
                  <a href="borrow-system.php">
                  <button type="button" class="submits" style="background-color:#F00">ยกเลิก</button>
                </a>                </th>
             </tr>
         </table>
         </center>
         <input type="hidden" name="MM_insert" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($RecordsetTool);
?>
