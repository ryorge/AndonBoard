<?php
date_default_timezone_set('America/Ensenada');
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
$dateToday = date("Y-m-d");
$dateSel = ($_GET['date'] ? $_GET['date'] : $dateToday);

function getOuts($process,$parent,$mode,$dateSel)
{
global $dateShift1a;
global $dateShift1b;
global $dateShift2a;
global $dateShift2b;
global $dateShift3a;
global $dateShift3b;
global $datebuffer1;
global $datebuffer2;
global $currentH;
 $t=time();
 $currentH=(date("H",$t));
 $currentM=(date("i",$t));

if (($currentH>=0)&&($currentH<=5)) // from 12AM to 5AM
{
	$dateShift1a= date('Y-m-d 6:00', strtotime($dateSel.'-1 day'));
	$dateShift1b= date('Y-m-d 14:00', strtotime($dateSel.'-1 day'));
	$dateShift2a= date('Y-m-d 14:00', strtotime($dateSel.'-1 day'));
	$dateShift2b= date('Y-m-d 22:00', strtotime($dateSel.'-1 day'));
	$dateShift3a= date('Y-m-d 22:00', strtotime($dateSel.'-1 day'));
	$dateShift3b= date('Y-m-d 6:00', strtotime($dateSel.'+0 day'));	
}
else  //  6AM to 
{
	$dateShift1a= date('Y-m-d 6:00', strtotime($dateSel.'+0 day'));
	$dateShift1b= date('Y-m-d 14:00', strtotime($dateSel.'+0 day'));
	$dateShift2a= date('Y-m-d 14:00', strtotime($dateSel.'+0 day'));
	$dateShift2b= date('Y-m-d 22:00', strtotime($dateSel.'+0 day'));
	$dateShift3a= date('Y-m-d 22:00', strtotime($dateSel.'+0 day'));
	$dateShift3b= date('Y-m-d 6:00', strtotime($dateSel.'+1 day'));
}


if ($mode=='Shift1')
{
	$date1=$dateShift1a;
	$date2=$dateShift1b;
	
}
elseif($mode=='Shift2')
{
	$date1=$dateShift2a;
	$date2=$dateShift2b;
	
}
elseif($mode=='Shift3')
{
	$date1=$dateShift3a;
	$date2=$dateShift3b;
	
}
//echo $date1." ".$date2."<br>";
		if($parent=='Stringer' || $parent=='stringer')
		{
			if ($process=='all'){
			$sql = " SELECT count(*) FROM
				  INVENTORYPACK IPN inner join
				  Part on IPN.PartID = Part.PartID
				  inner join MachineStage Machine on IPN.CreatedOnMachineStageID = Machine.MachineStageID
				  where Part.PartTypeID = 40
				  and Machine.MachineStageTypeID = 2
				  and IsEdited = 0
				  and IPN.CreatedToDT >= '$date1'
				  and IPN.CreatedToDT <= '$date2'
				  and IPN.CreatedToDT <> '2050-12-31 00:00:00.000'"; 
			}
			elseif ($process=='1' || $process=='2'){
				$sql = " SELECT count(*) FROM
				  INVENTORYPACK IPN inner join
				  Part on IPN.PartID = Part.PartID
				  inner join MachineStage Machine on IPN.CreatedOnMachineStageID = Machine.MachineStageID
				  where Part.PartTypeID = 40
				  and Machine.Name LIKE 'MXE_Stringer_0$process%'
				  and IsEdited = 0
				  and IPN.CreatedToDT >= '$date1'
				  and IPN.CreatedToDT <= '$date2'
				  and IPN.CreatedToDT <> '2050-12-31 00:00:00.000'"; 
			}
			else{
				$sql = " SELECT count(*) FROM
				  INVENTORYPACK IPN inner join
				  Part on IPN.PartID = Part.PartID
				  inner join MachineStage Machine on IPN.CreatedOnMachineStageID = Machine.MachineStageID
				  where Part.PartTypeID = 40
				  and Machine.Name = '$process'
				  and IsEdited = 0
				  and IPN.CreatedToDT >= '$date1'
				  and IPN.CreatedToDT <= '$date2'
				  and IPN.CreatedToDT <> '2050-12-31 00:00:00.000'"; 
			}
			//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');	// PROJ SPMX2 MES
			$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');	// PROD SPMX2 MES
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
		
		}
		elseif($parent=='MCF' || $parent=='mcf')
		{
			if ($process=='all'){
			$sql = "SELECT count (distinct InventoryPack.InventoryPackNo)
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.MachineStageTypeID = 6) AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT <= '$date2'
					AND BuildRecord_.OpenedDT <> '2050-12-31 00:00:00.000'";
			}
			elseif($process=="1" || $process=="2") {
				$sql = 	"SELECT count (distinct InventoryPack.InventoryPackNo)
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.Name LIKE N'%MXE_MCF_0$process%') AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT <= '$date2'
					AND BuildRecord_.OpenedDT <> '2050-12-31 00:00:00.000'";
			}
			else{
				$sql = 	"SELECT count (distinct InventoryPack.InventoryPackNo)
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.Name = '$process') AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT <= '$date2'
					AND BuildRecord_.OpenedD <> '2050-12-31 00:00:00.000'";
			}
			//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
			$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');	// PROD SPMX2 MES
			if (!$link) {
			die('Something went wrong while connecting to MSSQL');
			}
			else
			{
			//echo "DB Connected";	
			$db_selected = mssql_select_db('Ensenada_Owner', $link);
			}

			$result = mssql_query($sql);    
			//$dataArr = array();
			while ($row = mssql_fetch_row($result)) 
			//while ($row = mssql_fetch_array($result)) 
			{
			//$dataArr[] = $row['InventoryPackNo'];
			$data=$row[0]; 		
			if ($data==''){$data=0;}				
			}
			//$data = count(array_unique($dataArr));
			//$dataCnt = mssql_fetch_row($result);//echo $dataCnt;
			//echo $data;
			//echo count($dataArr)." ".count($dataUnique)."<br>";
		}
		if($parent=='EL' || $parent=='el')
		{
			if ($process=='all'){
			$sql = "SELECT InventoryPack.InventoryPackNo
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.Name LIKE 'MXE_EL_0%') AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT < '$date2'"; 
			}
			elseif ($process=='1' || $process=='2'){
				$sql = "SELECT InventoryPack.InventoryPackNo
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.Name LIKE 'MXE_EL_0$process%') AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT < '$date2'"; 
			}
			else{
				$sql = "SELECT InventoryPack.InventoryPackNo
					FROM BuildRecord_ INNER JOIN
                    BuildRecord ON BuildRecord_.BuildRecordID = BuildRecord.BuildRecordID INNER JOIN
                    InventoryPack ON BuildRecord.InvPackCreatedID = InventoryPack.InventoryPackID INNER JOIN
                    MachineStage ON BuildRecord.BuildMachineStageID = MachineStage.MachineStageID 
					WHERE (MachineStage.Name = '$process') AND (BuildRecord.InvPackConsumedID IS NULL)
					AND BuildRecord_.OpenedDT >= '$date1' AND BuildRecord_.OpenedDT < '$date2'"; 
			}
			//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');	// PROJ SPMX2 MES
			$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');	// PROD SPMX2 MES
			if (!$link) {
			die('Something went wrong while connecting to MSSQL');
			}
			else
			{
			//echo "DB Connected";	
			$db_selected = mssql_select_db('Ensenada_Owner', $link);
			}

			$result = mssql_query($sql);    
			$dataArr = array();
			//while ($row = mssql_fetch_row($result)) 
			while ($row = mssql_fetch_array($result)) 
			{
			$dataArr[] = $row['InventoryPackNo'];
			//$data=$row[0]; 		
			//if ($data==''){$data=0;}				
			}
			$data = count(array_unique($dataArr));
		
		}
		elseif($parent=='Laminator' || $parent=='laminator')
		{
			if ($process=='all'){
			$sql = " SELECT COUNT(*)
                      FROM InventoryPack INNER JOIN
                      Part ON InventoryPack.PartID = Part.PartID INNER JOIN
                      WO ON InventoryPack.WOID = WO.WOID INNER JOIN
                      PartType ON Part.PartTypeID = PartType.PartTypeID INNER JOIN
                      CUS_LaminatorInfo_ ON InventoryPack.InventoryPackNo = CUS_LaminatorInfo_.InventoryPackNo INNER JOIN
                      InventoryPack_ ON InventoryPack.InventoryPackID = InventoryPack_.InventoryPackID INNER JOIN
                      _SPML_ModuleInfo ON InventoryPack.InventoryPackNo = _SPML_ModuleInfo.SerialNo
                      WHERE (PartType.PartType = N'Laminates')
					  AND (_SPML_ModuleInfo.LaminationBuildDT >= '$date1')
					  AND (_SPML_ModuleInfo.LaminationBuildDT <= '$date2')
					  AND (_SPML_ModuleInfo.LaminationBuildDT <> '2050-12-31 00:00:00.000')";
			}
			elseif($process=="1" || $process=="2") {
				$sql = " SELECT COUNT(*)                       
				  FROM
				  InventoryPack INNER JOIN
                  Part ON InventoryPack.PartID = Part.PartID INNER JOIN
                  WO ON InventoryPack.WOID = WO.WOID INNER JOIN
                  PartType ON Part.PartTypeID = PartType.PartTypeID INNER JOIN
                  CUS_LaminatorInfo_ ON InventoryPack.InventoryPackid = CUS_LaminatorInfo_.InventoryPackID  INNER JOIN
                  InventoryPack_ ON InventoryPack.InventoryPackID = InventoryPack_.InventoryPackID INNER JOIN
                  _SPML_ModuleInfo ON InventoryPack.InventoryPackID  = _SPML_ModuleInfo.LaminateID INNER JOIN 
                  MachineStage ON InventoryPack.CreatedOnMachineStageID = MachineStage.MachineStageID
				  WHERE (PartType.PartType = N'Laminates')
    		      AND (_SPML_ModuleInfo.LaminationBuildDT > '$date1')
                  AND (_SPML_ModuleInfo.LaminationBuildDT <= '$date2')
                  AND (_SPML_ModuleInfo.LaminationBuildDT <> '2050-12-31 00:00:00.000')
                  AND UPPER(_SPML_ModuleInfo.LaminationBuildMachine) LIKE UPPER('MXE_Laminator_0$process%')";
			}
			else{
				$sql = " SELECT COUNT(*) 
				  FROM
				  InventoryPack INNER JOIN
                  Part ON InventoryPack.PartID = Part.PartID INNER JOIN
                  WO ON InventoryPack.WOID = WO.WOID INNER JOIN
                  PartType ON Part.PartTypeID = PartType.PartTypeID INNER JOIN
                  CUS_LaminatorInfo_ ON InventoryPack.InventoryPackid = CUS_LaminatorInfo_.InventoryPackID  INNER JOIN
                  InventoryPack_ ON InventoryPack.InventoryPackID = InventoryPack_.InventoryPackID INNER JOIN
                  _SPML_ModuleInfo ON InventoryPack.InventoryPackID  = _SPML_ModuleInfo.LaminateID INNER JOIN 
                  MachineStage ON InventoryPack.CreatedOnMachineStageID = MachineStage.MachineStageID
				  WHERE (PartType.PartType = N'Laminates')
    		      AND (_SPML_ModuleInfo.LaminationBuildDT > '$date1')
                  AND (_SPML_ModuleInfo.LaminationBuildDT <= '$date2')
                  AND (_SPML_ModuleInfo.LaminationBuildDT <> '2050-12-31 00:00:00.000')
                  AND UPPER(_SPML_ModuleInfo.LaminationBuildMachine) = UPPER('$process')";

			}
			//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
			$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s'); // PROD SPMX2
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
		
		}
		elseif($parent=='Trim' || $parent=='trim')
		{
			if ($process=='all'){
				/*
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
						FROM    _SPML_ModuleInfo ModuleInfo
						LEFT OUTER JOIN _SP_Pallet Pallet ON ModuleInfo.PalletID = Pallet.PalletID
						INNER JOIN MachineStage ON Pallet.MachineStageID = MachineStage.MachineStageID
						LEFT OUTER JOIN Part ON Pallet.ModulePartID = Part.PartID
						INNER JOIN InventoryAtLocation ON ModuleInfo.ModuleID = InventoryAtLocation.InventoryPackID
						AND InventoryAtLocation.ToDT = '2050-12-31 00:00:00.000'
                        AND InventoryAtLocation.IsEdited = 0
						INNER JOIN Location ON InventoryAtLocation.LocationID = Location.LocationID
						WHERE   ( ModuleInfo.PackedDT >= '$date1')
						AND ( ModuleInfo.PackedDT <= '$date2' )
						AND MachineStage.Name like 'MXE_Trim%'";
				*/ 
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
					FROM    _SPML_ModuleInfo ModuleInfo
					WHERE   ( ModuleInfo.TrimBuildDT >= '$date1')
					AND ( ModuleInfo.TrimBuildDT <= '$date2' )
					AND ModuleInfo.TrimBuildMachine LIKE 'MXE_Trim%'"; 
			}
			elseif($process=="1" || $process=="2") {
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
					FROM    _SPML_ModuleInfo ModuleInfo
					WHERE   ( ModuleInfo.TrimBuildDT >= '$date1')
					AND ( ModuleInfo.TrimBuildDT <= '$date2' )
					AND ModuleInfo.TrimBuildMachine LIKE 'MXE_Trim_0$process%'"; 
			}
			else{
				if(stristr($process,'Flashtest')==TRUE){
					$process2=substr_replace($process,'Packing',strpos($process,'Flashtest'),9);
				}
				else{
					$process2 = $process;
				}
				//$sql = "SELECT     COUNT(SerialNo) AS cnt
				//FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
				//WHERE     (FlashtestBuildMachine = '$process') AND (PackedDT >= '$date1') AND (PackedDT <= '$date2')
				//";
				/* 
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
					FROM    _SPML_ModuleInfo ModuleInfo
					LEFT OUTER JOIN _SP_Pallet Pallet ON ModuleInfo.PalletID = Pallet.PalletID
					INNER JOIN MachineStage ON Pallet.MachineStageID = MachineStage.MachineStageID
					LEFT OUTER JOIN Part ON Pallet.ModulePartID = Part.PartID
					INNER JOIN InventoryAtLocation ON ModuleInfo.ModuleID = InventoryAtLocation.InventoryPackID
					AND InventoryAtLocation.ToDT = '2050-12-31 00:00:00.000'
                    AND InventoryAtLocation.IsEdited = 0
					INNER JOIN Location ON InventoryAtLocation.LocationID = Location.LocationID
					WHERE   ( ModuleInfo.PackedDT >= '$date1')
					AND ( ModuleInfo.PackedDT <= '$date2' )
					AND MachineStage.Name = '$process2'"; 
				*/
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
					FROM    _SPML_ModuleInfo ModuleInfo
					WHERE   ( ModuleInfo.TrimBuildDT >= '$date1')
					AND ( ModuleInfo.TrimBuildDT <= '$date2' )
					AND ModuleInfo.TrimBuildMachine = '$process2'"; 
			}
			//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
			$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');
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
		
		}
		elseif($parent=='PKG' || $parent=='pkg')
		{
				if ($process=='all')
				{
				//$sql = "SELECT     COUNT(SerialNo) AS cnt
				//FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
				//WHERE     (PackedDT >= '$date1') AND (PackedDT <= '$date2')
				//AND (FlashtestBuildMachine like '%MX_Flashtest%')"; 
				$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
						FROM    _SPML_ModuleInfo ModuleInfo
						LEFT OUTER JOIN _SP_Pallet Pallet ON ModuleInfo.PalletID = Pallet.PalletID
						INNER JOIN MachineStage ON Pallet.MachineStageID = MachineStage.MachineStageID
						LEFT OUTER JOIN Part ON Pallet.ModulePartID = Part.PartID
						INNER JOIN InventoryAtLocation ON ModuleInfo.ModuleID = InventoryAtLocation.InventoryPackID
						AND InventoryAtLocation.ToDT = '2050-12-31 00:00:00.000'
                        AND InventoryAtLocation.IsEdited = 0
						INNER JOIN Location ON InventoryAtLocation.LocationID = Location.LocationID
						WHERE   ( ModuleInfo.PackedDT >= '$date1')
						AND ( ModuleInfo.PackedDT <= '$date2' )
						AND MachineStage.Name like '%Packing%'"; 
				}
				elseif($process=="1" || $process=="2") 
				{
					if(stristr($process,'Flashtest')==TRUE){
						$process2=substr_replace($process,'Packing',strpos($process,'Flashtest'),9);
					}
					else{
						$process2 = $process;
					}
					//$sql = "SELECT     COUNT(SerialNo) AS cnt
					//FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
					//WHERE     (FlashtestBuildMachine = '$process') AND (PackedDT >= '$date1') AND (PackedDT <= '$date2')
					//"; 
					$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
						FROM    _SPML_ModuleInfo ModuleInfo
						LEFT OUTER JOIN _SP_Pallet Pallet ON ModuleInfo.PalletID = Pallet.PalletID
						INNER JOIN MachineStage ON Pallet.MachineStageID = MachineStage.MachineStageID
						LEFT OUTER JOIN Part ON Pallet.ModulePartID = Part.PartID
						INNER JOIN InventoryAtLocation ON ModuleInfo.ModuleID = InventoryAtLocation.InventoryPackID
						AND InventoryAtLocation.ToDT = '2050-12-31 00:00:00.000'
                        AND InventoryAtLocation.IsEdited = 0
						INNER JOIN Location ON InventoryAtLocation.LocationID = Location.LocationID
						WHERE   ( ModuleInfo.PackedDT >= '$date1')
						AND ( ModuleInfo.PackedDT <= '$date2' )
						AND MachineStage.Name LIKE 'MXE_Packing_0$process2%'"; 
				}
				else
				{
					if(stristr($process,'Flashtest')==TRUE){
						$process2=substr_replace($process,'Packing',strpos($process,'Flashtest'),9);
					}
					else{
						$process2 = $process;
					}
					//$sql = "SELECT     COUNT(SerialNo) AS cnt
					//FROM         dbo._SPML_ModuleInfo AS FlashTestOuts
					//WHERE     (FlashtestBuildMachine = '$process') AND (PackedDT >= '$date1') AND (PackedDT <= '$date2')
					//"; 
					$sql = "SELECT  Count(ModuleInfo.SerialNo) AS cnt       
						FROM    _SPML_ModuleInfo ModuleInfo
						LEFT OUTER JOIN _SP_Pallet Pallet ON ModuleInfo.PalletID = Pallet.PalletID
						INNER JOIN MachineStage ON Pallet.MachineStageID = MachineStage.MachineStageID
						LEFT OUTER JOIN Part ON Pallet.ModulePartID = Part.PartID
						INNER JOIN InventoryAtLocation ON ModuleInfo.ModuleID = InventoryAtLocation.InventoryPackID
						AND InventoryAtLocation.ToDT = '2050-12-31 00:00:00.000'
                        AND InventoryAtLocation.IsEdited = 0
						INNER JOIN Location ON InventoryAtLocation.LocationID = Location.LocationID
						WHERE   ( ModuleInfo.PackedDT >= '$date1')
						AND ( ModuleInfo.PackedDT <= '$date2' )
						AND MachineStage.Name = '$process2'"; 
				}
				
				
				//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');
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
		elseif($parent=='PALLET' || $parent=='pallet') {
			if ($process=='all')
				{
				$sql = "SELECT count(*) FROM _sp_pallet a INNER JOIN machinestage AS b ON a.machinestageid = b.machinestageid 
					WHERE a.complete = 1 AND a.completeddt >= '$date1' AND a.completeddt < '$date2'
					AND a.completeddt != '2050-12-31 00:00:00.000' AND b.machinestagetypeid=16"; 
				}
				elseif($process=="1" || $process=="2") 
				{
					
					$sql = "SELECT count(*) FROM _sp_pallet a INNER JOIN machinestage AS b ON a.machinestageid = b.machinestageid 
					WHERE a.complete = 1 AND a.completeddt >= '$date1' AND a.completeddt < '$date2'
					AND a.completeddt != '2050-12-31 00:00:00.000' AND b.name LIKE 'MXE_Packing_0$process%'"; 
				}
				else
				{
					$sql = "SELECT count(*) FROM _sp_pallet a INNER JOIN machinestage AS b ON a.machinestageid = b.machinestageid 
					WHERE a.complete = 1 AND a.completeddt >= '$date1' AND a.completeddt < '$date2'
					AND a.completeddt != '2050-12-31 00:00:00.000' AND b.name = '$process'"; 
				}
				
				
				//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');
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
		}
		elseif($parent=='komax')
		{
					if ($process=='MXE_Stringer-Farm1')
					{
					$sql = "		
									SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
					FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN 
										  dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
					WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND 

					(
					(dbo.Line.Line = 'MXE_Stringer_01-1A') OR
					(dbo.Line.Line = 'MXE_Stringer_01-1B') OR
					(dbo.Line.Line = 'MXE_Stringer_01-2A')
					
					

					)";
					}
					elseif ($process=='MXE_Stringer-Farm2')
					{
					$sql = "		
									SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
					FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN 
										  dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
					WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND 

					(
					(dbo.Line.Line = 'MXE_Stringer_01-2B') OR
					(dbo.Line.Line = 'MXE_Stringer_01-3A') OR
					(dbo.Line.Line = 'MXE_Stringer_01-3B')							

					)";
					}
					elseif ($process=='MXE_Stringer-Farm3')
					{
						$sql = "
						SELECT     SUM(dbo.LineInfo.NetQuantityProduced) AS KomaxOuts
						FROM         dbo.LineInfo WITH(NOLOCK) INNER JOIN
						dbo.Line ON dbo.LineInfo.LineID = dbo.Line.LineID
						WHERE     (dbo.LineInfo.FromDT BETWEEN '$date1' AND '$date2') AND
					
						(
						(dbo.Line.Line = 'MXE_Stringer_01-4A') OR
						(dbo.Line.Line = 'MXE_Stringer_01-4B') OR
						(dbo.Line.Line = 'MXE_Stringer_02-1A') OR
						(dbo.Line.Line = 'MXE_Stringer_02-1B') OR
						(dbo.Line.Line = 'MXE_Stringer_02-2A') OR
						(dbo.Line.Line = 'MXE_Stringer_02-2B') OR
						(dbo.Line.Line = 'MXE_Stringer_02-3A') OR
						(dbo.Line.Line = 'MXE_Stringer_02-3B') OR
						(dbo.Line.Line = 'MXE_Stringer_02-4A') OR
						(dbo.Line.Line = 'MXE_Stringer_02-4B') OR

					)";
					}
				

				//MCF
				//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');
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
				//$sql = "		
				//SELECT DISTINCT SUM(dbo.InventoryPack.Quantity) AS MCFOuts
				//FROM         dbo.InventoryPack WITH (NOLOCK) INNER JOIN
				//		  dbo.MachineStage WITH (NOLOCK) ON dbo.InventoryPack.CreatedOnMachineStageID = dbo.MachineStage.MachineStageID
				//WHERE     (dbo.InventoryPack.CreatedFromDT BETWEEN '$date1' AND '$date2') AND (dbo.MachineStage.Name = '$process')
				//GROUP BY dbo.MachineStage.Name, dbo.MachineStage.MachineStageTypeID WITH ROLLUP		"; 
				
				if(stristr($process,'Framing')==TRUE){
					$process2=substr_replace($process,'Trim',strpos($process,'Framing'),7);					
				}
				else{
					$process2 = $process;
				}
				$sql = "						
				select count(b.Name) as MCFOuts  from 
				(SELECT MaxBuildRecord.BuildRecordID   ,
                        MaxBuildRecord.InvPackCreatedID,
                        MaxBuildRecord.BuildDT         ,
                        MaxBuildRecord.BuildMachineStageID,
						BuildRecord_.Comments
					FROM    BuildRecord AS MaxBuildRecord
                        INNER JOIN
                                (SELECT MAX(BuildDT) AS BuildDT,
                                        InvPackCreatedID, BuildMachineStageID
                                FROM    BuildRecord AS BuildRecord_1
                                WHERE (IsEdited             = 0)
                                    AND (InvPackConsumedID IS NULL)
                                    AND (BuildDT           >= '$date1')
                                    AND (BuildDT           <= '$date2')
                                GROUP BY InvPackCreatedID,
                                        BuildMachineStageID
                                ) AS latest_built_onms
                        ON      MaxBuildRecord.BuildDT            = latest_built_onms.BuildDT
                            AND MaxBuildRecord.InvPackCreatedID   = latest_built_onms.InvPackCreatedID
                            AND MaxBuildRecord.BuildMachineStageID = latest_built_onms.BuildMachineStageID
						INNER JOIN BuildRecord_
						ON BuildRecord_.BuildRecordID = MaxBuildRecord.BuildRecordID
					WHERE (MaxBuildRecord.IsEdited                    = 0)
                    AND (MaxBuildRecord.InvPackConsumedID        IS NULL)) a
                    inner join MachineStage b on a.BuildMachineStageID = b.MachineStageID
					WHERE b.Name = '$process2'
                    group by b.Name";

				//MCF
				//$link = mssql_connect('DEV-LHSQLDCA01', 'lhsqluser', '$Y#IPH@3&S');
				$link = mssql_connect('LHSQLSPMX2-OA1', 'lhmesspmx2', '$gH#l&%p&s');	// PROD SPMX2 MES
				if (!$link) {
				die('Something went wrong while connecting to MSSQL');
				}
				else
				{
				//echo "DB Connected";	
				$db_selected = mssql_select_db('Ensenada_Owner', $link);
				}
				//echo $sql;
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

function getTarget($process,$parent,$dateSel)
{
global $line;
global $desc;
global $AMtotalTarget;
global $PMtotalTarget;
global $AMtarget;
global $PMtarget;
global $prevAMtarget;
global $prevPMtarget;

global $shift1Total;
global $shift2Total;
global $shift3Total;
global $shift1Target;
global $shift2Target;
global $shift3Target;

//$db="MOD_ENGR_SYSTEM";
$db="MX2_MDCTest";
//$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');		
$link = mssql_connect('LHSQLSPMX2-OA1', 'factoryapps', '$g&h@o#9Y%n');		
mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_error());

if ($process=='all')
{

$patternArr = array("stringer"=>"Stringer","laminator"=>"Laminator","trim"=>"Trim","pkg"=>"Packing",'mcf'=>"MCF",'layup'=>'Layup','pallet'=>'Pallet','el'=>'EL');
$parent2 = strtolower($parent);
$query="Select 
sum(t2430)as t030,
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

  from Andon_tblTarget where machine like 'MXE_".$patternArr[$parent2]."%'" ;

}
elseif($process=="1" || $process=="2") {
	$patternArr = array("stringer"=>"Stringer","laminator"=>"Laminator","trim"=>"Trim","pkg"=>"Packing",'mcf'=>"MCF",'layup'=>'Layup','pallet'=>'Pallet','el'=>'EL');
	$parent2 = strtolower($parent);
	$query="Select 
	sum(t2430)as t030,
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
	from Andon_tblTarget where machine like 'MXE_".$patternArr[$parent2]."_0".$process."%'" ;
}
else
{
//$query="Select *  from Andon_tblTarget where machine='$process'" ;
	if($parent=="pallet") {
		$query="Select t2430 as t030, t130, t230, t330, t430, t530, t630, t730, t830, t930, t1030, t1130, t1230, t1330, t1430, t1530, t1630, t1730, t1830, t1930, 
			t2030, t2130, t2230, t2330, machine, description, line, id  from Andon_tblTarget where machine='$process'" ;
		$query = str_replace('Packing','Pallet',$query);
	}
	else {
		$query="Select t2430 as t030, t130, t230, t330, t430, t530, t630, t730, t830, t930, t1030, t1130, t1230, t1330, t1430, t1530, t1630, t1730, t1830, t1930, 
			t2030, t2130, t2230, t2330, machine, description, line, id  from Andon_tblTarget where machine='$process'" ;
	}
}

$rez=mssql_query($query);
while ($row = mssql_fetch_array($rez))
{

if ($process=='all') {
	$line="All";
	$parent2 = strtolower($parent);
	if($parent=="pkg") $desc="Packaging";
	elseif($parent2=="stringer") $desc="All Stringer";
	elseif($parent2=="laminator") $desc="All Laminator";
	elseif($parent2=="trim") $desc="All Trimming";
	elseif($parent2=="mcf") $desc="All MCF";
	elseif($parent2=="layup") $desc="All Layup";
	elseif($parent2=="pallet") $desc="All Pallet";
	elseif($parent2=="el") $desc="All EL";
}
elseif ($process=='1' || $process=="2") {
	$line=$process;
	$parent2 = strtolower($parent);
	if($parent=="pkg") $desc="All Packaging";
	elseif($parent2=="stringer") $desc="All Stringer";
	elseif($parent2=="laminator") $desc="All Laminator";
	elseif($parent2=="trim") $desc="All Trimming";
	elseif($parent2=="mcf") $desc="All MCF";
	elseif($parent2=="layup") $desc="All Layup";
	elseif($parent2=="pallet") $desc="All Pallet";
	elseif($parent2=="el") $desc="All EL";
}
else
{
$line=$row['line'];
$desc=$row['description'];
}
$t=time();
$currentH=(date("H",$t));
$currentM=(date("i",$t));

$t630=($row['t630']/60)*$currentM;
$t730=$row['t630']+($row['t730']/60)*$currentM;
$t830=$row['t630']+$row['t730']+($row['t830']/60)*$currentM;
$t930=$row['t630']+$row['t730']+$row['t830']+($row['t930']/60)*$currentM;
$t1030=$row['t630']+$row['t730']+$row['t830']+$row['t930']+($row['t1030']/60)*$currentM;
$t1130=$row['t630']+$row['t730']+$row['t830']+$row['t930']+$row['t1030']+($row['t1130']/60)*$currentM;
$t1230=$row['t630']+$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+($row['t1230']/60)*$currentM;
$t1330=$row['t630']+$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+($row['t1330']/60)*$currentM;

$t1430=($row['t1430']/60)*$currentM;
$t1530=$row['t1430']+($row['t1530']/60)*$currentM;
$t1630=$row['t1430']+$row['t1530']+($row['t1630']/60)*$currentM;
$t1730=$row['t1430']+$row['t1530']+$row['t1630']+($row['t1730']/60)*$currentM;
$t1830=$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+($row['t1830']/60)*$currentM;
$t1930=$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830']+($row['t1930']/60)*$currentM;
$t2030=$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830']+$row['t1930']+($row['t2030']/60)*$currentM;
$t2130=$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830']+$row['t1930']+$row['t2030']+($row['t2130']/60)*$currentM;
//$AMtotalTarget=$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330']+$row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830'];
$t2230=($row['t2230']/60)*$currentM;
$t2330=$row['t2230']+($row['t2330']/60)*$currentM;
$t030=$row['t2230']+$row['t2330']+($row['t030']/60)*$currentM;
$t2430=$row['t2230']+$row['t2330']+($row['t030']/60)*$currentM;
$t130=$row['t2230']+$row['t2330']+$row['t030']+($row['t130']/60)*$currentM;
$t230=$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+($row['t230']/60)*$currentM;
$t330=$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+($row['t330']/60)*$currentM;
$t430=$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+($row['t430']/60)*$currentM;
$t530=$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+($row['t530']/60)*$currentM;
//$t630=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+($row['t630']/60)*$currentM;
//$t630=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+($row['t630']/60)*$currentM;
//$PMtotalTarget=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+$row['t630'];
//$PMtotalTarget=$row['t1930']+$row['t2030']+$row['t2130']+$row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530']+$row['t630'];
$shift1Total = $row['t630']+$row['t730']+$row['t830']+$row['t930']+$row['t1030']+$row['t1130']+$row['t1230']+$row['t1330'];
$shift2Total = $row['t1430']+$row['t1530']+$row['t1630']+$row['t1730']+$row['t1830']+$row['t1930']+$row['t2030']+$row['t2130'];
$shift3Total = $row['t2230']+$row['t2330']+$row['t030']+$row['t130']+$row['t230']+$row['t330']+$row['t430']+$row['t530'];

} 
 $t=time();
 $currentH=(date("H",$t));
 $currentM=(date("i",$t));

switch($currentH)
 {
 	// 6am-2pm shift
 	case 6: 	
	$shift1Target=$t630;
	break;

	case 7: 
	$shift1Target=$t730;
	break;

	case 8: 
	$shift1Target=$t830;
	break;

	case 9: 
	$shift1Target=$t930;
	break;

	case 10: 
	$shift1Target=$t1030;
	break;

	case 11: 
	$shift1Target=$t1130;
	break;

	case 12: 
	$shift1Target=$t1230;
	break;

	case 13: 
	$shift1Target=$t1330;
	break;

	// 2pm-10pm shift
	case 14: 
	$shift2Target=$t1430;
	break;

	case 15: 
	$shift2Target=$t1530;
	break;

	case 16: 
	$shift2Target=$t1630;
	break;

	case 17: 
	$shift2Target=$t1730;
	break;

	case 18: 
	$shift2Target=$t1830;
	break;
	
	case 19: 
	$shift2Target=$t1930;
	break;

	case 20: 
	$shift2Target=$t2030;
	break;

	case 21: 
	$shift2Target=$t2130;
	break;

	// 10pm-6am shift
	case 22: 
	$shift3Target=$t2230;
	break;

	case 23: 
	$shift3Target=$t2330;
	break;

	case 0: 
	$shift3Target=$t030;
	break;

	case 1: 
	$shift3Target=$t130;
	break;

	case 2:
	$shift3Target=$t230;
	break;

	case 3: 	
	$shift3Target=$t330;
	break;

	case 4: 
	$shift3Target=$t430;
	break;

	case 5: 
	//$PMtarget=$t630;
	$shift3Target=$t530;
	break;
	
 }
 
 	//$AMtarget=round($AMtarget, 0, PHP_ROUND_HALF_UP);  
	//$PMtarget=round($PMtarget, 0, PHP_ROUND_HALF_UP); 
	$shift1Target=ceil($shift1Target); 
	$shift2Target=ceil($shift2Target); 
	$shift3Target=ceil($shift3Target); 
 
 if (($currentH>=6)&&($currentH<14)) {
   //$shift1Target=$shift1Total;
 } 

 if (($currentH>=14)&&($currentH<22))
 {
   //$shift2Target=$shift2Total;
   $shift1Target=$shift1Total;
 } 
 if (($currentH>=22 && $currentH<=24) || ($currentH>=0 && $currentH<6)) 
 {
 	$shift2Target=$shift2Total;
   $shift1Target=$shift1Total;
   //$shift3Target=$shift3Total;
 }
 
// echo "H:".$currentH."M:".$currentM;

$dateTodayTmp = date("Y-m-d");
if($dateSel<$dateTodayTmp) {
	$shift3Target=$shift3Total;
 	$shift2Target=$shift2Total;
	$shift1Target=$shift1Total;
}

return (int)$target;
mssql_close($link);		
}

getTarget($process,$parent,$dateSel);
$shift1Actual=getOuts($process,$parent,"Shift1",$dateSel);
$shift2Actual=getOuts($process,$parent,"Shift2",$dateSel);
$shift3Actual=getOuts($process,$parent,"Shift3",$dateSel);

$shift1Delta=intval($shift1Actual)-intval($shift1Target);
$shift2Delta=intval($shift2Actual)-intval($shift2Target);
$shift3Delta=intval($shift3Actual)-intval($shift3Target);
//$PMdelta=intval($PMactual)-intval($PMtarget);


  if (($currentH>=7)&&($currentH<=18)) // currently on AM Shift
 {
 
   $PMdelta=0;
 }
 
 

if ($shift1Delta<1)
{
$shift1color='red';
}
if ($shift2Delta<1)
{
$shift2color='red';
}
if ($shift3Delta<1)
{
$shift3color='red';
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

if ($lang=="eng" || $lang=="en")
{
$shiftLabel="Shift";
$targetLabel="Target";
$actualLabel="Actual";
$deltaLabel="Delta";
}
elseif($lang=="spanish" || $lang=="es")
{ 
$shiftLabel="Turno";
$targetLabel="Plan";
$actualLabel="Actual";
$deltaLabel="Dif";
}
else
{ 
$shiftLabel="Turno";
$targetLabel="Plan";
$actualLabel="Actual";
$deltaLabel="Dif";
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
    <th height="115" colspan="4" bgcolor="#FFCC00" id="tableData4" scope="col"><p style="color: #000; font-size: 36px;">SunPower Production Status Board Ensenada
    </p>
    <p style="color: #000; font-size: 36px;">Line : <?php echo $line;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Station : <?php if($desc=="EL 1-2") echo "Busbar Insertion (Visual Inspection)"; else echo $desc;?></p></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $shiftLabel?></h1></th>
    <th bgcolor="#000000" ><p style="font-size:50px">6AM-2PM</p></th>
    <th bgcolor="#000000" ><p style="font-size:50px">2PM-10PM</p></th>   
    <th bgcolor="#000000" ><p style="font-size:50px">10PM-6AM</p></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th  bgcolor="#000000" id="tableData2" scope="row"><h1><?php echo $targetLabel?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $shift1Total;?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $shift2Total;?></h1></th>
    <th  bgcolor="#000000" ><h1><?php  echo $shift3Total;?></h1></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $actualLabel?></h1></th>
    <th bgcolor="#000000"><h1><?php echo $shift1Actual;?></th>
    <th bgcolor="#000000"><h1><?php echo $shift2Actual;?></th>
    <th bgcolor="#000000"><h1><?php echo $shift3Actual;?></th>
  </tr>
  <tr bgcolor="#FF9933">
    <th bgcolor="#000000" scope="row"><h1><?php echo $deltaLabel?></h1></th>
    <th bgcolor="#000000" ><font color="<?php echo $shift1color ?>"><h1><?php   echo $shift1Delta;?></h1></th>
    <th bgcolor="#000000" ><font color="<?php echo $shift2color ?>"><h1><?php   echo $shift2Delta;?></h1><h1>
    <th bgcolor="#000000" ><font color="<?php echo $shift3color ?>"><h1><?php   echo $shift3Delta;?></h1><h1>
  </th>
  </tr>
</table>
* Current 6AM - 2PM Running Target : <b><?php  echo $shift1Target;?></b><br>
* Current 2PM - 10PM Running Target : <b><?php  echo $shift2Target;?></b><br>
* Current 10PM - 6AM Running Target : <b><?php  echo $shift3Target;?></b><br>
* Current Time : <b><?php  $t=time();echo (date("H",$t));?>:<?php  $t=time();echo (date("i",$t));?></b>
<br>
* 6AM-2PM Data : <b><?php echo $dateShift1a;?> to  <?php echo $dateShift1b;?></b><br>
* 2PM-10PM Data : <b><?php echo $dateShift2a;?> to  <?php echo $dateShift2b;?></b><br>
* 10PM-6PM Data : <b><?php echo $dateShift3a;?> to  <?php echo $dateShift3b;?></b><br>
<br>
<p>Copyright(R) Sunpower 2016</p>
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
