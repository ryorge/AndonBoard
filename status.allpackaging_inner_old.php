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
				
				
				(FlashtestBuildMachine like '%MX_Flashtest%')
				
				"; 
				}
				else
				{
				$sql = "SELECT     COUNT(SerialNo) AS cnt
				FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
				WHERE     (FlashtestBuildMachine = '$process') AND (PackedDT >= '$date1') AND (PackedDT <= '$date2')
				"; 
				}
				
				
				$link = mssql_connect('LHSQLSPMX01\LIGHTHOUSE_PROD', 'usrLHAdmin', '3. better than this');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('MEXICALI_OWNER', $link);
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
					(dbo.Line.Line = 'MX_Komax-1') OR
					(dbo.Line.Line = 'MX_Komax-2') OR
					(dbo.Line.Line = 'MX_Komax-3') OR
					(dbo.Line.Line = 'MX_Komax-4') OR
					(dbo.Line.Line = 'MX_Komax-5') OR
					(dbo.Line.Line = 'MX_Komax-6') OR
					(dbo.Line.Line = 'MX_Komax-7') OR
					(dbo.Line.Line = 'MX_Komax-8') OR
					(dbo.Line.Line = 'MX_Komax-9') OR
					(dbo.Line.Line = 'MX_Komax-10') OR
					(dbo.Line.Line = 'MX_Komax-11') OR
					(dbo.Line.Line = 'MX_Komax-12') 
					

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
					(dbo.Line.Line = 'MX_Komax-13') OR
					(dbo.Line.Line = 'MX_Komax-14') OR
					(dbo.Line.Line = 'MX_Komax-15') OR
					(dbo.Line.Line = 'MX_Komax-16') OR
					(dbo.Line.Line = 'MX_Komax-17') OR
					(dbo.Line.Line = 'MX_Komax-18') OR
					(dbo.Line.Line = 'MX_Komax-19') 					

					)";
					}

				//MCF
				$link = mssql_connect('LHSQLSPMX01\LIGHTHOUSE_PROD', 'usrLHAdmin', '3. better than this');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('MEXICALI_OWNER', $link);
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
				$link = mssql_connect('LHSQLSPMX01\LIGHTHOUSE_PROD', 'usrLHAdmin', '3. better than this');
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('MEXICALI_OWNER', $link);
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
global $runningTarget;
global $PMtarget;
global $prevAMtarget;
global $prevPMtarget;

//$db="MOD_ENGR_SYSTEM";
//$link = mssql_connect('sptlmes01.spml.sunpowercorp.com', 'sa', 'spcol');
		$db="MX_ModEngrSystem";
		$link = mssql_connect('sqlspmx01', 'factoryapps', 'factoryapps');	
		
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


  from AndonMX_tblTarget where machine like 'MX_Flashtest%'" ;
  
  
  
}
else
{
$query="Select *  from AndonMX_tblTarget where machine='$process'" ;
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
$t1930=$AMtotalTarget+($row['t1930']/60)*$currentM;
$t2030=$AMtotalTarget+$row['t1930']+($row['t2030']/60)*$currentM;
$t2130=$AMtotalTarget+$row['t1930']+$row['t2030']+($row['t2130']/60)*$currentM;
$t2230=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+($row['t2230']/60)*$currentM;
$t2330=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+($row['t2330']/60)*$currentM;
$t030=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+($row['t030']/60)*$currentM;
$t130=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+($row['t130']/60)*$currentM;
$t230=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+($row['t230']/60)*$currentM;
$t330=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+($row['t330']/60)*$currentM;
$t430=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+($row['t430']/60)*$currentM;
$t530=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+($row['t530']/60)*$currentM;
$t630=$AMtotalTarget+$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+($row['t630']/60)*$currentM;

$PMtotalTarget=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+$row['t630'];


} 
 $t=time();
 $currentH=(date("H",$t));
 $currentM=(date("i",$t));

switch($currentH)
 {
	case 7: 
	
	$runningTarget=$t730;
 
	break;
	case 8: 
	
	$runningTarget=$t830;
	break;
	case 9: 
	
	$runningTarget=$t930;
	break;
	case 10: 

	$runningTarget=$t1030;
	break;
	case 11: 

	$runningTarget=$t1130;
	break;
	case 12: 
	
	$runningTarget=$t1230;
	break;
	case 13: 

	$runningTarget=$t1330;
	break;
	case 14: 
	
	$runningTarget=$t1430;
	break;
	case 15: 

	$runningTarget=$t1530;
	break;
	case 16: 

	$runningTarget=$t1630;
	break;
	case 17: 

	$runningTarget=$t1730;
	break;
	case 18: 

	$runningTarget=$t1830;
	break;
	
	//-PM Shift Next :)
	
	case 19: 

	$runningTarget=$t1930;
	break;
	case 20: 
	
	$runningTarget=$t2030;
	break;
	case 21: 

	$runningTarget=$t2130;
	break;
	case 22: 

	$runningTarget=$t2230;
	break;
	case 23: 
	
	$runningTarget=$t2330;
	break;
	case 0: 
	
	$runningTarget=$t030;
	break;
	case 1: 
	
	$runningTarget=$t130;
	break;
	case 2: 

	$runningTarget=$t230;

	break;
	case 3: 
	
	$runningTarget=$t330;
	break;
	case 4: 

	$runningTarget=$t430;
	break;
	case 5: 

	$runningTarget=$t630;
	
	break;
	case 6: 
	
	$runningTarget=$t630;
	break;
	
 }
 
 	//$runningTarget=round($runningTarget, 0, PHP_ROUND_HALF_UP);  
	$runningTarget=ceil($runningTarget); 

 
 
 //echo "H:".$currentH."M:".$currentM;


return (int)$target;
mssql_close($link);		
}

getTarget($process);
$actual=getOuts($process,$parent,"AM")+getOuts($process,$parent,"PM");

$delta=intval($actual)-intval($runningTarget);



 

if ($delta<1)
{
$color='red';
}


if ($delta>1)
{
//$color='green';
}



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
<title>Sunpower MODCO - Andon Board
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
    <th  bgcolor="#000000" id="tableData2" scope="row"><h1><?php echo $targetLabel?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $AMtotalTarget+$PMtotalTarget;?></h1></th>
   
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $actualLabel?></h1></th>
    <th bgcolor="#000000"><h1><?php echo $actual;?></th>
  
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $deltaLabel?></h1></th>
    <th bgcolor="#000000" ><font color="<?php echo $color ?>"><h1><?php   echo $delta;?></h1></th>
    
  </th>
  </tr>
</table>

* Current Running Target : <b><?php  echo $runningTarget;?></b>
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
