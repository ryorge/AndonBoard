<?php 
//error_reporting(E_ERROR | E_PARSE);
session_start();
$username=$_SESSION['username'];


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

<title>Sunpower SPMX2 Production Status Board Maintenance</title>
</head>



<body>

<center>
		<div id="container">
			<h1 class="full_width big">&nbsp;</h1>
			<table border=0>
			<tr bgcolor='#FFCC00' bordercolor="#999999" >

			  <th colspan="3"><img src="top.jpg" width="700" height="100"></th>
			  </tr>
			<tr bgcolor='#FFCC00' bordercolor="#999999" ><th> Line </th><th> Description</th><th>Equipment</th></tr>
			<?php
$db="MX2_MDCTest";
$link = mssql_connect('LHSQLSPMX2-OA1', 'factoryapps', '$g&h@o#9Y%n');	
		//$db="MOD_ENGR_SYSTEM";
		//$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');	
	
mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_error());


if ($process=='')
{
$process=$hiddenProcess;
}

$query="Select machine,line,description from Andon_tblTarget WHERE machine LIKE 'MXE_%' AND
(description LIKE '%Laminator%' OR description LIKE '%Trim%' OR description LIKE '%Stringer%' OR description LIKE '%Packaging%' 
OR description LIKE '%MCF%')
order by description,line asc" ;

$tmpMachine = "xxx";
$rez=mssql_query($query);
while ($row = mssql_fetch_array($rez))
{	
$machine=$row['machine'];
$line=$row['line'];
$desc=$row['description'];
$machineArr = explode("_",$machine);

$posStr = strpos($row['machine'],'MXE_String');
$posLam = strpos($row['machine'],'MXE_Laminator');
$posTrim = strpos($row['machine'],'MXE_Trim');
$posPack = strpos($row['machine'],'MXE_Packing');
$posMcf = strpos($row['machine'],'MXE_MCF');

if($posStr!==false) $station="stringer";
elseif($posLam!==false) $station="laminator";
elseif($posTrim!==false) $station="trim";
elseif($posPack!==false) $station="pkg";
elseif($posMcf!==false) $station="mcf";

	if($tmpMachine!=$machineArr[1]) {
?>
	<tr><th bgcolor="#FFFF99">ALL LINES</th><th bgcolor="#FFCC66">All <?php echo $machineArr[1]?></th><th bgcolor="#FFFF66"><a href="status.php?parent=<?php echo $station;?>&process=all">ALL</a></th> </tr>
	<tr><th bgcolor="#FFFF99">LINE 1</th><th bgcolor="#FFCC66">All <?php echo $machineArr[1]?></th><th bgcolor="#FFFF66"><a href="status.php?parent=<?php echo $station;?>&process=1">ALL <?php echo strtoupper($machineArr[1]);?> IN LINE 1</a></th> </tr>
	<tr><th bgcolor="#FFFF99">LINE 2</th><th bgcolor="#FFCC66">All <?php echo $machineArr[1]?></th><th bgcolor="#FFFF66"><a href="status.php?parent=<?php echo $station;?>&process=2">ALL <?php echo strtoupper($machineArr[1]);?> IN LINE 2</a></th> </tr>
<?php } ?>
<tr><th bgcolor="#FFFF99"><?php echo $line ?> </th><th bgcolor="#FFCC66"><?php echo $desc?></th><th bgcolor="#FFFF66"><a href="status.php?parent=<?php echo $station;?>&process=<?php echo $machine; ?>"><?php echo $machine; ?></a></th> </tr>
<?php	
	$tmpMachine = $machineArr[1];
} 
?>
<tr bgcolor="#666666"><th height="14" colspan="3"><img src="bottom.jpg" width="700" height="34"></th></tr>


</table>
		


		
		
			</div>
		</div>
Copyright(R) 2012 Sunpower


		</body>





</html>


<?php ob_flush(); ?> 