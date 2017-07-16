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
mysql_select_db($database_connectioneq, $connectioneq);
$query_Recordset1 = sprintf("SELECT * FROM tb_borrow_his inner join tb_user inner join tb_class inner join tb_faculty inner join tb_major inner join tb_tools inner join tb_type inner join tb_stores on tb_borrow_his.b_his_user_id= tb_user.id_log and tb_borrow_his.b_his_tool_id = tb_tools.tool_id and tb_user.class_id = tb_class.class_id and tb_user.faculty_id = tb_faculty.faculty_id and tb_user.major_id = tb_major.major_id and tb_tools.tool_type = tb_type.type_id and tb_tools.tool_store_id = tb_stores.stores_id WHERE tb_user.student_id_log LIKE %s", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));
$Recordset1 = mysql_query($query_Recordset1, $connectioneq) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HISTORY</title>
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
<body>
<table>
    <tr>
        <td width="10%" style="background-color:#039">
        	<a href="home.php">
        	<button type="button" class="submits">หน้าหลัก</button>
       	</a>        </td>
        <td width="30%" style="background-color:#039">
        	             
        <form name="search_tool" id="search_tool" action="" method="">
          <input type="text" name="search" id="search" placeholder="ค้นหาโดย รหัสนักศึกษา"/>
          <input type="submit" id="btnsearch" value="ค้นหา" />  
        </form>
            	
        </td>
        
        <td width="80%" style="background-color:#CCC">
        <p><b>ระบบยืมคืนอุปกรณ์ :</b> Center for Microwave and Robotic Technology</p>
        <form id="form1" name="form1" method="post" action="">
          <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordsetyous['b_id_log']; ?>" />
        </form>
        </td>
    </tr>
    </table>
<table border="1">
<tr>
  <tr>
  	<th colspan="11" style="background-color:#00F">ประวัติการยืม</th>
  </tr>
  <tr>
    	<th>ชื่อ-นามสกุล</th>
        <th>รหัสนักศึกษา</th>
        <th>ชั้นปี</th>
        <th>สาขาวิชา</th>
        <th>อุปกรณ์ที่ยืม</th>
        <th>รหัสอุปกรณ์</th>
        <th>ประเภทอุปกรณ์</th>
        <th>ที่เก็บอุปกรณ์</th>
        <th>วันที่ยืม</th>
        <th>กำหนดการคืน</th>
        <th>ตัวเลือก</th>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['name_log']; ?></td>
      <td><?php echo $row_Recordset1['student_id_log']; ?></td>
      <td><?php echo $row_Recordset1['class_name']; ?></td>
      <td><?php echo $row_Recordset1['major_name']; ?></td>
      <td><?php echo $row_Recordset1['tool_name']; ?></td>
      <td><?php echo $row_Recordset1['tool_code']; ?></td>
      <td><?php echo $row_Recordset1['type_name']; ?></td>
      <td><?php echo $row_Recordset1['stores_name']; ?></td>
      <td><?php echo $row_Recordset1['b_his_date_borrow']; ?></td>
      <td><?php echo $row_Recordset1['b_his_return']; ?></td>
      <td>
      	<a href="delete-history.php?b_his_id=<?php echo $row_Recordset1['b_his_id']; ?>">
      	<button disabled="disabled" type="button">ลบ</button>
   	  </a>   <p>Updating</p>   </td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
