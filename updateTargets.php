<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
body {
	background-color: #FC0;
}
-->
</style></head>
<?php
$process=$_GET['process'];

$hiddenProcess = $_POST['identifier'] ;
$line = $_POST['line'] ;
$desc = $_POST['description'] ;  
$t630=$_POST['t630'];
$t730=$_POST['t730'];
$t830=$_POST['t830'];
$t930=$_POST['t930'];
$t1030=$_POST['t1030'];
$t1130=$_POST['t1130'];
$t1230=$_POST['t1230'];
$t1330=$_POST['t1330'];
$t1430=$_POST['t1430'];
$t1530=$_POST['t1530'];
$t1630=$_POST['t1630'];
$t1730=$_POST['t1730'];
$t1830=$_POST['t1830'];
$t1930=$_POST['t1930'];
$t2030=$_POST['t2030'];
$t2130=$_POST['t2130'];
$t2230=$_POST['t2230'];
$t2330=$_POST['t2330'];
$t2430=$_POST['t2430'];
$t130=$_POST['t130'];
$t230=$_POST['t230'];
$t330=$_POST['t330'];
$t430=$_POST['t430'];
$t530=$_POST['t530']; 

//$db="MOD_ENGR_SYSTEM";
//		$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');	
$db="MX2_MDCTest";
$link = mssql_connect('LHSQLSPMX2-OA1', 'factoryapps', '$g&h@o#9Y%n');	
mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_error());
$query=" UPDATE Andon_tblTarget SET 
description='$desc',
line='$line',
t630='$t630',
t730='$t730',
t830='$t830',
t930='$t930',
t1030='$t1030',
t1130='$t1130',
t1230='$t1230',
t1330='$t1330',
t1430='$t1430',
t1530='$t1530',
t1630='$t1630',
t1730='$t1730',
t1830='$t1830',
t1930='$t1930',
t2030='$t2030',
t2130='$t2130',
t2230='$t2230',
t2330='$t2330',
t2430='$t2430',
t130='$t130',
t230='$t230',
t330='$t330',
t430='$t430',
t530='$t530'

WHERE machine='$hiddenProcess' ";
mssql_query($query);
//echo $query;
if ($process=='')
{
$process=$hiddenProcess;
}

$query="Select *  from Andon_tblTarget where machine='$process'" ;

$rez=mssql_query($query);
while ($row = mssql_fetch_array($rez))
{	
$machine=$row['machine'];
$line=$row['line'];
$desc=$row['description'];
$t630=$row['t630'];
$t730=$row['t730'];
$t830=$row['t830'];
$t930=$row['t930'];
$t1030=$row['t1030'];
$t1130=$row['t1130'];
$t1230=$row['t1230'];
$t1330=$row['t1330'];
$t1430=$row['t1430'];
$t1530=$row['t1530'];
$t1630=$row['t1630'];
$t1730=$row['t1730'];
$t1830=$row['t1830'];
$t1930=$row['t1930'];
$t2030=$row['t2030'];
$t2130=$row['t2130'];
$t2230=$row['t2230'];
$t2330=$row['t2330'];
$t2430=$row['t2430'];
$t130=$row['t130'];
$t230=$row['t230'];
$t330=$row['t330'];
$t430=$row['t430'];
$t530=$row['t530'];
} 
?>


<body><center>
<form id="form1" name="form1" method="post" action="updateTargets.php">
<h1><?php echo $machine ?></h1>
<table width="272" border="0">
  <tr>
    <th width="111" bgcolor="#FFFF33" scope="row">Identifier</th>
    <td width="151">
      <label>
        <input name="identifier" type="text" id="identifier" value="<?php echo $machine ?>" />
      </label>
   </td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">Description</th>
    <td><input name="description" type="text" id="description" value="<?php echo $desc ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">Line</th>
    <td><input name="line" type="text" id="line" value="<?php echo $line ?>" /></td>
  </tr>
  
  <tr>
    <th bgcolor="#FFFF33" scope="row">7:00</th>
    <td><input name="t730" type="text" id="t730" value="<?php echo $t730 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">8:00</th>
    <td><input name="t830" type="text" id="t830" value="<?php echo $t830 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">9:00</th>
    <td><input name="t930" type="text" id="t930" value="<?php echo $t930 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">10:00</th>
    <td><input name="t1030" type="text" id="t1030" value="<?php echo $t1030 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">11:00</th>
    <td><input name="t1130" type="text" id="t1130" value="<?php echo $t1130 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">12:00</th>
    <td><input name="t1230" type="text" id="t1230" value="<?php echo $t1230 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">13:00</th>
    <td><input name="t1330" type="text" id="t1330" value="<?php echo $t1330 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">14:00</th>
    <td><input name="t1430" type="text" id="t1430" value="<?php echo $t1430 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">15:00</th>
    <td><input name="t1530" type="text" id="t1530" value="<?php echo $t1530 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">16:00</th>
    <td><input name="t1630" type="text" id="t1630" value="<?php echo $t1630 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">17:00</th>
    <td><input name="t1730" type="text" id="t1730" value="<?php echo $t1730 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">18:00</th>
    <td><input name="t1830" type="text" id="t1830" value="<?php echo $t1830 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">19:00</th>
    <td><input name="t1930" type="text" id="t1930" value="<?php echo $t1930 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">20:00</th>
    <td><input name="t2030" type="text" id="t2030" value="<?php echo $t2030 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">21:00</th>
    <td><input name="t2130" type="text" id="t2130" value="<?php echo $t2130 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">22:00</th>
    <td><input name="t2230" type="text" id="t2230" value="<?php echo $t2230 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">23:00</th>
    <td><input name="t2330" type="text" id="t2330" value="<?php echo $t2330 ?>" /></td>
  </tr>
   <tr>
    <th bgcolor="#FFFF33" scope="row">0:00</th>
    <td><input name="t2430" type="text" id="t2430" value="<?php echo $t2430 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">1:00</th>
    <td><input name="t130" type="text" id="t130" value="<?php echo $t130 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">2:00</th>
    <td><input name="t230" type="text" id="t230" value="<?php echo $t230 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">3:00</th>
    <td><input name="t330" type="text" id="t330" value="<?php echo $t330 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">4:00</th>
    <td><input name="t430" type="text" id="t430" value="<?php echo $t430 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">5:00</th>
    <td><input name="t530" type="text" id="t530" value="<?php echo $t530 ?>" /></td>
  </tr>
  <tr>
    <th bgcolor="#FFFF33" scope="row">6:00</th>
    <td><input name="t630" type="text" id="t630" value="<?php echo $t630 ?>" /></td>
  </tr>
</table>
<p>
  <label>
    <input type="submit" name="button" id="button" value="Submit" />
  </label>
</p>
</form>
</body>
</html>
