<?php 


function isValid($username)
{
	//$db="MOD_ENGR_SYSTEM";
		//$link = mssql_connect('sptlmes01', 'sa', 'spcol');		
		$db="MOD_ENGR_SYSTEM";
		$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');	
	
		mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_get_last_message());
		$query="SELECT count(*) as cnt from Andon_users WHERE username='$username'";
		$rez=mssql_query($query);
		$valid=0;
		while ($row = mssql_fetch_array($rez))
		{
		$valid=$row['cnt'];
		}
		mssql_close($link);
		return (int)$valid;
		
}
function isAdmin($username)
{
		//$db="MOD_ENGR_SYSTEM";
		//$link = mssql_connect('sptlmes01', 'sa', 'spcol');	
		$db="MOD_ENGR_SYSTEM";
		$link = mssql_connect('DEV-LHSQLSPMM01\PROJLOGDB', 'loguser', '$Su%n^Pw#r@2');	
		mssql_select_db($db , $link) or die("Couldn't open $db: ".mssql_get_last_message());
		$query="SELECT count(*) as cnt from Andon_users WHERE username='$username' and Role='admin' ";
		$rez=mssql_query($query);
		$valid=0;
		while ($row = mssql_fetch_array($rez))
		{
		$valid=$row['cnt'];
		}
		mssql_close($link);
		return (int)$valid;
		
}


?>
