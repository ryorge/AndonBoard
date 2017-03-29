<?php 
error_reporting(E_ERROR | E_PARSE); 
session_start();
$username=$_SESSION['username'];
$toAdd=$_POST['txtUsername'];
$action=$_GET['action'];
$account=$_GET['account'];


//$db="MOD_ENGR_SYSTEM";
//$link = mssql_connect('sptlmes01', 'sa', 'spcol');	

		
$db="MOD_ENGR_SYSTEM";
$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');	
mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_get_last_message());

if(($_SESSION['username']=="")||($_SESSION['andon_role']==""))
{
header("location:index.php?action=NotAuthorized");
}

if ($action=='delete')
{
$query="Delete From Andon_users where username='$account'";
if(!mssql_query($query)){ echo ('Invalid query: ' .$query);}
header("location:usersList.php");
mssql_close($link);
exit();
}


if (!($toAdd==""))
{
$query="INSERT INTO Andon_users (username,role) values ('$toAdd',NULL)";
if(!mssql_query($query)){
mssql_close($link);
?>
<script>
alert("User already enrolled : <?php echo $toAdd ?>. ");
window.location.href="usersList.php";
</script>
<?
}
mssql_close($link);
header("location:usersList.php");
exit();
}


?>
<html>
<head>

<link rel="stylesheet" href="jquery/themes/base/jquery.ui.all.css">
<script src="development-bundle/jquery-1.7.1.js"></script>
<link rel="stylesheet" href="development-bundle/themes/base/jquery.ui.all.css">
<script src="development-bundle/ui/jquery.ui.core.js"></script>
<script src="development-bundle/ui/jquery.ui.widget.js"></script>
<script src="development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="jquery.calendrical.js"></script>
<link rel="stylesheet" href="calendrical.css" />
<script src="jquery/ui/jquery.ui.core.js"></script>
<script src="jquery/ui/jquery.ui.widget.js"></script>
<script src="jquery/ui/jquery.effects.core.js"></script>
<script src="jquery/ui/jquery.effects.blind.js"></script>
<script src="jquery/ui/jquery.effects.bounce.js"></script>
<script src="jquery/ui/jquery.effects.clip.js"></script>
<script src="jquery/ui/jquery.effects.drop.js"></script>
<script src="jquery/ui/jquery.effects.fold.js"></script>
<script src="jquery/ui/jquery.effects.slide.js"></script>
<script src="jquery/ui/jquery.effects.explode.js"></script>
<script src="jquery/ui/jquery.ui.datepicker.js"></script>
<script src="jquery/ui/jquery.ui.dialog.js"></script>
<script src="jquery/ui/jquery.ui.position.js"></script>
<script src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="picnet.table.filter.min.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
jQuery(document).ready(function() 
{
	 
	 jQuery("a.grouped_elements").fancybox({
			'width'				:'35%',
			'height'			: '100%',
			'autoScale'			: false,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	
				
				
	

});
</script>

<script>function deleteAccount(DeleteId) {

   var answer = confirm("Do you want to delete this account?")

   if (answer){

      window.location = "usersList.php?action=delete&account="+DeleteId;

   }

}</script>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000;
}
-->
</style>

<style> 
table { 
border-bottom-style: solid; 
border-bottom-width: 10px; 
border-bottom-color: EEEEEE; /* lt gray*/ 
border-right-style: solid; 
border-right-width: 10px; 
border-right-color: EEEEEE; /* lt gray*/ 
} 
</style> 

<title>Sunpower SPMX2 Production Status Board Maintenance [Users List] Administrator</title>
</head>



<body>

<center>
		<div id="container">
		<form id="form1" name="form1" method="post" action="usersList.php">
		  <h1 class="full_width big">&nbsp;</h1>
			<table border=0>
			<tr bgcolor='#FFCC00' bordercolor="#999999" >
			  <th colspan="3"><img src="top.jpg" width="700" height="100"></th>
			  </tr>
			<tr bgcolor='#FFCC00' bordercolor="#999999" >
			  <th colspan="3" align="left">Welcome , <?php echo $username;?> , <a href="logout.php">[ Logout ] </a></th>
			  </tr>
			<tr bgcolor='#FFCC00' bordercolor="#999999" >
			  <th colspan="3" align="left">Add user :		      
			    <label for="txtUsername"></label>
		      <input type="text" name="txtUsername" id="txtUsername"> <input type="submit" name="button" id="button" value="Add"></th>
			  </tr>
			  
			  </form>
			<tr bgcolor='#FFCC00' bordercolor="#999999" ><th> ID </th><th> Username</th><th>Status</th></tr>
			<?php


if ($process=='')
{
$process=$hiddenProcess;
}

$query="Select id,username from Andon_users " ;

$rez=mssql_query($query);
while ($row = mssql_fetch_array($rez))
{	
$uid=$row['username'];
?>

<tr><th bgcolor="#FFFF99"><?php echo $row['id']; ?> </th><th bgcolor="#FFCC66"><?php echo $row['username'];?></th><th bgcolor="#FFFF66"><?php echo "<a href='#' onclick=\"deleteAccount('$uid')\" >"; ?>Delete </a></th> </tr>


<?php
} 
?>
<tr bgcolor="#666666"><th height="14" colspan="3"><img src="bottom.jpg" width="700" height="34"></th></tr>


</table>
		


		
		
			</div>
		</div>
Copyright(R) 2012 Sunpower


		</body>





</html>


<?php 
mssql_close($link);
ob_flush(); 
?> 