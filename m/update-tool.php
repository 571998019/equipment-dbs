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
/* update to sql  */
if($_FILES["image"]["name"] != ""){
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
	$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	$updateSQL = sprintf("UPDATE tb_tools SET tool_name=%s, tool_code=%s, tool_type=%s, image=%s, tool_store_id=%s WHERE tool_id=%s",
				   GetSQLValueString($_POST['tool_name'], "text"),
				   GetSQLValueString($_POST['tool_code'], "text"),
				   GetSQLValueString($_POST['types'], "int"),
				   GetSQLValueString(dwUpload($_FILES['image']), "text"),
				   GetSQLValueString($_POST['store'], "int"),
				   GetSQLValueString($_POST['tool_id'], "int"));
	
	mysql_select_db($database_connectioneq, $connectioneq);
	$Result1 = mysql_query($updateSQL, $connectioneq) or die(mysql_error());
	
	$updateGoTo = "detail-tools.php";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	header(sprintf("Location: %s", $updateGoTo));
	}
	}else{
		
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
$editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
$updateSQL = sprintf("UPDATE tb_tools SET tool_name=%s, tool_code=%s, tool_type=%s, tool_store_id=%s WHERE tool_id=%s",
				   GetSQLValueString($_POST['tool_name'], "text"),
				   GetSQLValueString($_POST['tool_code'], "text"),
				   GetSQLValueString($_POST['types'], "int"),
				   GetSQLValueString($_POST['store'], "int"),
				   GetSQLValueString($_POST['tool_id'], "int"));

mysql_select_db($database_connectioneq, $connectioneq);
$Result1 = mysql_query($updateSQL, $connectioneq) or die(mysql_error());

$updateGoTo = "detail-tools.php";
if (isset($_SERVER['QUERY_STRING'])) {
$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
$updateGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $updateGoTo));
}
		
		}
/* END update to sql */

/*

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tb_tools SET tool_name=%s, tool_code=%s, tool_type=%s, image=%s, tool_store_id=%s WHERE tool_id=%s",
                       GetSQLValueString($_POST['tool_name'], "text"),
                       GetSQLValueString($_POST['tool_code'], "text"),
                       GetSQLValueString($_POST['types'], "int"),
					   GetSQLValueString(dwUpload($_FILES['image']), "text"),
                       GetSQLValueString($_POST['store'], "int"),
                       GetSQLValueString($_POST['tool_id'], "int"));

  mysql_select_db($database_connectioneq, $connectioneq);
  $Result1 = mysql_query($updateSQL, $connectioneq) or die(mysql_error());

  $updateGoTo = "detail-tools.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
 */

$colname_Recordset1 = "-1";
if (isset($_GET['tool_id'])) {
  $colname_Recordset1 = $_GET['tool_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordset1 = sprintf("SELECT * FROM tb_tools WHERE tool_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $connectioneq) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetType = "SELECT * FROM tb_type";
$RecordsetType = mysql_query($query_RecordsetType, $connectioneq) or die(mysql_error());
$row_RecordsetType = mysql_fetch_assoc($RecordsetType);
$totalRows_RecordsetType = mysql_num_rows($RecordsetType);

mysql_select_db($database_connectioneq, $connectioneq);
$query_RecordsetStore = "SELECT * FROM tb_stores";
$RecordsetStore = mysql_query($query_RecordsetStore, $connectioneq) or die(mysql_error());
$row_RecordsetStore = mysql_fetch_assoc($RecordsetStore);
$totalRows_RecordsetStore = mysql_num_rows($RecordsetStore);

$colname_Recordsettype2 = "-1";
if (isset($_GET['type_id'])) {
  $colname_Recordsettype2 = $_GET['type_id'];
}
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordsettype2 = sprintf("SELECT * FROM tb_type WHERE type_id = %s", GetSQLValueString($colname_Recordsettype2, "int"));
$Recordsettype2 = mysql_query($query_Recordsettype2, $connectioneq) or die(mysql_error());
$row_Recordsettype2 = mysql_fetch_assoc($Recordsettype2);
$totalRows_Recordsettype2 = mysql_num_rows($Recordsettype2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>update tool</title>
<style>
input[type=text], select {
    width: 80%;
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
.submitss {
    width: 100%;
    background-color: #F00;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
	text-align:center;
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
</style>
</head>

<body>
<div style="background-color:#CCC;">
<h3 style="text-align:center;">แก้ไขรายละเอียดอุปกรณ์</h3>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" enctype="multipart/form-data">
    <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">ชื่ออุปกรณ์:</td>
          <td><input type="text" name="tool_name" value="<?php echo htmlentities($row_Recordset1['tool_name'], ENT_COMPAT, 'utf-8'); ?>" size="21" />
           </td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">รหัสอุปกรณ์</td>
          <td><input type="text" name="tool_code" value="<?php echo htmlentities($row_Recordset1['tool_code'], ENT_COMPAT, 'utf-8'); ?>" size="21" />
           </td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">ประเภทอุปรณ์:</td>
          <td><select name="types">
           <option value="<?php echo $_GET['id_type']; ?>"><?php echo $_GET['type']; ?></option> 
					<?php
            do {  
            ?>
                    <option value="<?php echo $row_RecordsetType['type_id']?>"><?php echo $row_RecordsetType['type_name']?></option>
                    <?php
            } while ($row_RecordsetType = mysql_fetch_assoc($RecordsetType));
              $rows = mysql_num_rows($RecordsetType);
              if($rows > 0) {
                  mysql_data_seek($RecordsetType, 0);
                  $row_RecordsetType = mysql_fetch_assoc($RecordsetType);
              }
            ?>
                  </select>
           </td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">รูปประกอบ:</td>
          <td>
          <input type="file" name="image" value="<?php echo $_GET['image']; ?>" size="20" />
           </td>
        </tr>
        
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">สถานที่:</td>
          <td><select name="store">
          <option value="<?php echo $_GET['id_store']; ?>"><?php echo $_GET['store']; ?></option>
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
           </td>
        </tr>
    </table>    
  <table align="center">
     <tr>
    	<tr valign="baseline">
     	 <td><input type="submit" value="แก้ไข" /></td>
         <td>
       		 <a href="detail-tools.php?type2=<?php echo $_GET['id_type']; ?>">
        		<button class="submitss" type="button" >ยกเลิก</button>
       		 </a>
         </td>
    	</tr>
      </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="tool_id" value="<?php echo $row_Recordset1['tool_id']; ?>" />
</form>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($RecordsetType);

mysql_free_result($RecordsetStore);

mysql_free_result($Recordsettype2);
?>
