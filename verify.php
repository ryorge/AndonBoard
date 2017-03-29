<?php ob_start(); ?>
<?php
$username=$_POST['username'];
$password=$_POST['password'];


include('common.php');
include('ldapsearch.php');
	 
$ldapValid=0;
if (verify_ldap($username,$password))
{
$ldapValid=1;
}
//echo $ldapValid;

if(($ldapValid==1)&&(isValid($username)==1))


{	
	session_start();
	session_destroy();
	session_start();
	if (isAdmin($username)==1)
	{
		$_SESSION['username'] = $username;	
		$_SESSION['andon_role'] = 'admin';		
		header("location:usersList.php");
	}
	else
	{
		$_SESSION['username'] = $username;				
		header("location:targets.php");
	}
			
}
elseif(($ldapValid==1)&&(isValid($username)<>1))
	 { // If not match. 
	header("location:index.php?action=NotAuthorized");
	 }

 // End Login authorization check.
else

 { // If not match. 
	header("location:index.php?action=InvalidLogin");
	 }

?> 


<?php ob_flush(); ?> 

