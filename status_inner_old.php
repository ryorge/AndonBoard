<?php
//date_default_timezone_set('America/Vancouver');

set_time_limit(300);
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
header('Refresh: 300'); ?>
<script>
       //window.moveTo( <?php echo $w ?> ,<?php echo $h ?> )
	   //window.moveTo( 1400,1 )
   
</script>
<?php
$parent=$_GET['parent'];
$process=$_GET['process'];
$lang=$_GET['lang'];
$mode=$_GET['mode'];
function getOuts($process,$parent,$mode)
{
global $dateAM1;
global $dateAM2;
global $datePM1;
global $datePM2;
global $datebuffer1;
global $datebuffer2;
global $currentH;
 $t=time();
 $currentH=(date("H",$t));
 $currentM=(date("i",$t));
 
 
if (($currentH>=0)&&($currentH<=7)) // from 12AM to 6AM
{
	if (($currentH==7)&&($currentM>=0) )
	{
	//echo "1";
	$dateAM1= date('Y-m-d 7:00', strtotime('+0 day'));
	$dateAM2= date('Y-m-d 19:00', strtotime('+0 day'));
	$datePM1= date('Y-m-d 19:00', strtotime('+0 day'));
	$datePM2= date('Y-m-d 7:00', strtotime('+1 day'));
	}
	else
	{
	
	$dateAM1= date('Y-m-d 7:00', strtotime('-1 day'));
	$dateAM2= date('Y-m-d 19:00', strtotime('-1 day'));
	$datePM1= date('Y-m-d 19:00', strtotime('-1 day'));
	$datePM2= date('Y-m-d 7:00', strtotime('+0 day'));
	}
	
}
else  //  6AM to 
{
$dateAM1= date('Y-m-d 7:00', strtotime('+0 day'));
$dateAM2= date('Y-m-d 19:00', strtotime('+0 day'));
$datePM1= date('Y-m-d 19:00', strtotime('+0 day'));
$datePM2= date('Y-m-d 7:00', strtotime('+1 day'));
}


if ($mode=='AM')
{
	$date1=$dateAM1;
	$date2=$dateAM2;
}
elseif($mode=='PM')
{
	$date1=$datePM1;
	$date2=$datePM2;
}



		if($parent=='PKG')
		{
				if ($process=='pkgall')
				{
				$sql = "SELECT     COUNT(SerialNo) AS cnt
				FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
				WHERE     (PackedDT >= '$date1') AND (PackedDT <= '$date2')
				AND
				
				
				(FlashtestBuildMachine like '%MXE_Flashtest%')
				
				"; 
				}
				else
				{
				$sql = "SELECT     COUNT(SerialNo) AS cnt
				FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
				WHERE     (FlashtestBuildMachine = '$process') AND (PackedDT >= '$date1') AND (PackedDT <= '$date2')
				"; 
				}
				
				
				$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('Ensenada_Owner', $link);
				}

				$result = mssql_query($sql);    
			
				while ($row = mssql_fetch_row($result)) 
				{   
				$data=$row[0]; 
				
			
				if ($data==''){$data=0;}				
				}
				//END OF MCF
				
		}
		elseif($parent=='komax')
		{
					if ($process=='MX_Komax-Farm1')
					{
					$sql = "		
									SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
					FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN 
										  dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
					WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND 

					(
					(dbo.Line.Line = 'MXE_Stringer_01-1A') OR
					(dbo.Line.Line = 'MXE_Stringer_01-1B') OR
					(dbo.Line.Line = 'MXE_Stringer_01-3A')
					
					
					

					)";
					}
					elseif ($process=='MX_Komax-Farm2')
					{
					$sql = "		
									SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
					FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN 
										  dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
					WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND 

					(
					(dbo.Line.Line = 'MXE_Stringer_01-4A') OR
					(dbo.Line.Line = 'MXE_Stringer_01-4B') OR
					(dbo.Line.Line = 'MXE_Stringer_01-3B')		

					)";
					}
					elseif ($process=='MX_Komax-Farm3')
					{
						$sql = "
						SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
						FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN
						dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
						WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND
					
						(
						(dbo.Line.Line = 'MXE_Stringer_01-2B') OR
						(dbo.Line.Line = 'MXE_Stringer_01-2A')	
					
						)";
					}

				//MCF
				$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('Ensenada_Owner', $link);
				}

				$result = mssql_query($sql);    
			
				while ($row = mssql_fetch_row($result)) 
				{   
				$data=$row[0]; 
				
				//echo "DATA : ".$data;
				if ($data==''){$data=0;}				
				}
				//END OF MCF
				
		}
		
		else 
		{
				$sql = "		
				SELECT DISTINCT SUM(dbo.InventoryPack.Quantity) AS MCFOuts
				FROM         dbo.InventoryPack WITH (NOLOCK) INNER JOIN
						  dbo.MachineStage WITH (NOLOCK) ON dbo.InventoryPack.CreatedOnMachineStageID = dbo.MachineStage.MachineStageID
				WHERE     (dbo.InventoryPack.CreatedFromDT BETWEEN '$date1' AND '$date2') AND (dbo.MachineStage.Name = '$process')
				GROUP BY dbo.MachineStage.Name, dbo.MachineStage.MachineStageTypeID WITH ROLLUP		"; 

				//MCF
				$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('Ensenada_Owner', $link);
				}

				$result = mssql_query($sql);    
			
				while ($row = mssql_fetch_row($result)) 
				{   
				$data=$row[0]; 
				
				//echo "DATA : ".$data;
				if ($data==''){$data=0;}				
				}
				//END OF MCF
		}
	

		mssql_close($link);
		return $data;
}

function getTarget($process)
{
global $line;
global $desc;
global $AMtotalTarget;
global $PMtotalTarget;
global $AMtarget;
global $PMtarget;
global $prevAMtarget;
global $prevPMtarget;

$db="MOD_ENGR_SYSTEM";
$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');		
mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_error());

if ($process=='pkgall')
{
$query="Select 
sum(t030)as t030,
sum(t130)as t130,
sum(t230)as t230,
sum(t330)as t330,
sum(t430)as t430,
sum(t530)as t530,
sum(t630)as t630,
sum(t730)as t730,
sum(t830)as t830,
sum(t930)as t930,
sum(t1030)as t1030,
sum(t1130)as t1130,
sum(t1230)as t1230,
sum(t1330)as t1330,
sum(t1430)as t1430,
sum(t1530)as t1530,
sum(t1630)as t1630,
sum(t1730)as t1730,
sum(t1830)as t1830,
sum(t1930)as t1930,
sum(t2030)as t2030,
sum(t2130)as t2130,
sum(t2230)as t2230,
sum(t2330)as t2330


  from Andon_tblTarget where machine like 'MXE_Flashtest%'" ;
  
  
  
}
else
{
$query="Select *  from Andon_tblTarget where machine='$process'" ;
}

$rez=mssql_query($query);
while ($row = mssql_fetch_array($rez))
{

if ($process=='pkgall')	
{
$line="All";
$desc="Packaging";
}
else
{
$line=$row['line'];
$desc=$row['description'];
}
$t=time();
$currentH=(date("H",$t));
$currentM=(date("i",$t));
$t730=($row['t730']/60)*$currentM;
$t830=$row['t730']+($row['t830']/60)*$currentM;
$t930=$row['t730']+$row['t830']+($row['t930']/60)*$currentM;
$t1030=$row['t730']+$row['t830']+$row['t930']+($row['t1030']/60)*$currentM;
$t1130=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+($row['t1130']/60)*$currentM;
$t1230=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+($row['t1230']/60)*$currentM;
$t1330=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+($row['t1330']/60)*$currentM;
$t1430=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+($row['t1430']/60)*$currentM;
$t1530=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+($row['t1530']/60)*$currentM;
$t1630=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+$row['t1530']+($row['t1630']/60)*$currentM;
$t1730=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+$row['t1530']+$row['t1630']+($row['t1730']/60)*$currentM;
$t1830=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+($row['t1830']/60)*$currentM;
$AMtotalTarget=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830'];
$t1930=($row['t1930']/60)*$currentM;
$t2030=$row['t1930']+($row['t2030']/60)*$currentM;
$t2130=$row['t1930']+$row['t2030']+($row['t2130']/60)*$currentM;
$t2230=$row['t1930']+$row['t2030']+$row['t2130']+($row['t2230']/60)*$currentM;
$t2330=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+($row['t2330']/60)*$currentM;
$t030=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+($row['t030']/60)*$currentM;
$t130=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+($row['t130']/60)*$currentM;
$t230=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+($row['t230']/60)*$currentM;
$t330=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+($row['t330']/60)*$currentM;
$t430=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+($row['t430']/60)*$currentM;
$t530=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+($row['t530']/60)*$currentM;
$t630=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+($row['t630']/60)*$currentM;

$PMtotalTarget=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+$row['t630'];


} 
 $t=time();
 $currentH=(date("H",$t));
 $currentM=(date("i",$t));

switch($currentH)
 {
	case 7: 
	
	$AMtarget=$t730;
 
	break;
	case 8: 
	
	$AMtarget=$t830;
	break;
	case 9: 
	
	$AMtarget=$t930;
	break;
	case 10: 

	$AMtarget=$t1030;
	break;
	case 11: 

	$AMtarget=$t1130;
	break;
	case 12: 
	
	$AMtarget=$t1230;
	break;
	case 13: 

	$AMtarget=$t1330;
	break;
	case 14: 
	
	$AMtarget=$t1430;
	break;
	case 15: 

	$AMtarget=$t1530;
	break;
	case 16: 

	$AMtarget=$t1630;
	break;
	case 17: 

	$AMtarget=$t1730;
	break;
	case 18: 

	$AMtarget=$t1830;
	break;
	
	//-PM Shift Next :)
	
	case 19: 

	$PMtarget=$t1930;
	break;
	case 20: 
	
	$PMtarget=$t2030;
	break;
	case 21: 

	$PMtarget=$t2130;
	break;
	case 22: 

	$PMtarget=$t2230;
	break;
	case 23: 
	
	$PMtarget=$t2330;
	break;
	case 0: 
	
	$PMtarget=$t030;
	break;
	case 1: 
	
	$PMtarget=$t130;
	break;
	case 2: 

	$PMtarget=$t230;

	break;
	case 3: 	
	$PMtarget=$t330;
	
	break;
	case 4: 

	$PMtarget=$t430;
	break;
	case 5: 
	//$PMtarget=$t630;
	$PMtarget=$t630;
	
	break;
	case 6: 
	
	$PMtarget=$t630;
	break;
	
 }
 
 	//$AMtarget=round($AMtarget, 0, PHP_ROUND_HALF_UP);  
	//$PMtarget=round($PMtarget, 0, PHP_ROUND_HALF_UP); 
	$AMtarget=ceil($AMtarget); 
	$PMtarget=ceil($PMtarget);	
 
 if ((($currentH>=19)&&($currentH<=23))||(($currentH>=0)&&($currentH<=6)))  // currently on PM Shift
 {
	
   $AMtarget=$AMtotalTarget;  	   
  
 }
  if (($currentH>=7)&&($currentH<=18)) // currently on AM Shift
 {
   $PMtarget=$PMtotalTarget;  
 }
 
// echo "H:".$currentH."M:".$currentM;


return (int)$target;
mssql_close($link);		
}

getTarget($process);
$AMactual=getOuts($process,$parent,"AM");
$PMactual=getOuts($process,$parent,"PM");

$AMdelta=intval($AMactual)-intval($AMtarget);
$PMdelta=intval($PMactual)-intval($PMtarget);


  if (($currentH>=7)&&($currentH<=18)) // currently on AM Shift
 {
 
   $PMdelta=0;
 }
 
 

if ($AMdelta<1)
{
$AMcolor='red';
}
if ($PMdelta<1)
{
$PMcolor='red';
}

if ($AMdelta>1)
{
//$AMcolor='green';
}
if ($PMdelta>1)
{
//$PMcolor='green';
}

/*
echo "<br>-----------<br>";
echo $AMactual."-".$AMtarget;
echo "<br>";

echo $PMactual."-".$PMtarget;
echo "<br>";

echo "<br>";
echo "AM DELTA : ".$AMdelta;
echo "<br>";
echo "PM DELTA : ".$PMdelta;
*/

if($target==0)
{
$target="No Target Define";
}

if ($lang=="eng")
{
$shiftLabel="Shift";
$targetLabel="Target";
$actualLabel="Actual";
$deltaLabel="Delta";
}
elseif($lang=="spanish")
{
$shiftLabel="Turno";
$targetLabel="Plan";
$actualLabel="Actual";
$deltaLabel="Dif";
}
else
{
$shiftLabel="Shift";
$targetLabel="Target";
$actualLabel="Actual";
$deltaLabel="Delta";
}


?>



<html>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
	font-family: Verdana, Geneva, sans-serif;
}
#tableData {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 25px;
	font-style: normal;
}
-->
table
{
border-spacing:0; 
border-collapse:collapse;
padding:0px;
padding-bottom:0px;
}


h1{
	font-size: 110px;
	font-family: Verdana, Geneva, sans-serif;
	margin:-10px; 

}
th {text-align:center; height: 10px;}
</style>



<head>
</head>
<title>Sunpower SPMX2 - Andon Board
</title>
<body bgcolor='white'>
<center>
<table  width='100%' border="1" cellpadding="0" id="tableData" style="color: #FFF;">
  <tr>
    <th height="115" colspan="3" bgcolor="#FFCC00" id="tableData4" scope="col"><p style="color: #000; font-size: 36px;">SunPower Production Status Board SPMX
    </p>
    <p style="color: #000; font-size: 36px;">Line : <?php echo $line;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Station : <?php echo $desc;?></p></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $shiftLabel?></h1></th>
    <th bgcolor="#000000" ><h1>AM </h1></th>
    <th bgcolor="#000000" ><h1>PM </h1></th>   
  </tr>
  <tr bgcolor="#FF9933">
    <th  bgcolor="#000000" id="tableData2" scope="row"><h1><?php echo $targetLabel?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $AMtotalTarget;?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $PMtotalTarget;?></h1></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $actualLabel?></h1></th>
    <th bgcolor="#000000"><h1><?php echo $AMactual;?></th>
    <th bgcolor="#000000"><h1><?php echo $PMactual;?></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $deltaLabel?></h1></th>
    <th bgcolor="#000000" ><font color="<?php echo $AMcolor ?>"><h1><?php   echo $AMdelta;?></h1></th>
    <th bgcolor="#000000" ><font color="<?php echo $PMcolor ?>"><h1><?php   echo $PMdelta;?></h1><h1>
  </th>
  </tr>
</table>

* Current AM Running Target : <b><?php  echo $AMtarget;?></b>
<br>
* Current PM Running Target : <b><?php  echo $PMtarget;?></b>
<br>
* Current Time : <b><?php  $t=time();echo (date("H",$t));?> :<?php  $t=time();echo (date("i",$t));?></b>
<br>
* AM Data : <b><?php echo $dateAM1;?> to  <?php echo $dateAM2;?></b>
<br>
* PM Data : <b><?php echo $datePM1;?> to  <?php echo $datePM2;?></b>
<br>
<p>Copyright(R) Sunpower 2012</p>
</body>
</html>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<font color=white>Page generated in '.$total_time.' seconds.';
?>
