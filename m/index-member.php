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
<?php include("layout-member.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Title -->
<title>หน้าจัดการสมาชิก</title>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<body style="background-image:url(../img/back.jpg)">
<div style="padding-top:50px">
</div>
<div class="container">
     
  <!-- Jumbotron -->
  <div class="jumbotron" style="background:#CCC">
  	<table style="text-align:center">
          <tbody>
          <tr>
          	<td colspan="2"><p style="font-size:16px;"><b>บุคคลากร</b><br>โปรแกรมวิชาวิศวกรรมคอมพิวเตอร์<p></td>
          </tr>
          <tr>
              <td colspan="2" width="50%"><img class="img-thumbnail" src="../img/teacher/krittakorn.jpg" width="256" height="256"></td>
          </tr>
          <tr>
              <td colspan="2">อาจารย์กฤตกรณ์ ศรีวันนา<br><b>ประธานโปรแกรมวิชา</b></td>
          </td>
          </tr>
          <tr>
          <td></td>
          </tr>
          <tr>
              <td style="padding:1px"><img class="img-thumbnail" src="../img/teacher/thanawoot.jpg" width="256" height="256"></td>
              <td><img class="img-thumbnail" src="../img/teacher/kamol.jpg" width="256" height="256"></td>
          </tr>
          <tr>
              <td>อ. ดร.ธนาวุฒิ ธนวาณิชย์</td>
              <td>อาจารย์กมล บุญล้อม</td>
          </tr>  
          <tr>
          <td><p></p></td>
          </tr>        
          <tr>
              <td><img class="img-thumbnail" src="../img/teacher/athikoms.jpg" width="256" height="256"></td>
              <td><img class="img-thumbnail" src="../img/teacher/phumipong.jpg" width="256" height="256"></td>
          </tr>
          <tr>
              <td>อาจารย์อธิคม ศิริ</td>
              <td>อาจารย์ภูมิพงษ์ ดวงตั้ง</td>
          </tr>
          </tbody>
          </table>
  </div>

  <!-- Site footer -->
  <footer class="footer">
    <p style="color:
    #FFF">&copy; 2017 Mirot :: Center for Microwave and Robotic Technology </p>
  </footer>

</div> <!-- /container -->
</body>
</html>