<?php
function getMail($person)
{

define('LDAP_SERVER', '192.168.136.56');
define('LDAP_PORT', 389);
define('LDAP_USER', 'claromentis');
define('LDAP_PASSWORD', 'ur_claromentis01');

$ldap_dn = 'OU=Sites, DC=sunpowercorp, DC=com';
$ldap_con = ldap_connect(LDAP_SERVER, LDAP_PORT) or die("Could not connect to server. Error is " . ldap_error($ldap_con));
$ldap_bind = ldap_bind($ldap_con, LDAP_USER, LDAP_PASSWORD) or die("Couldn't bind to LDAP!");

#$person = 'rmgebana';
$filter = '(samAccountName='.$person.')'; 

$id[] = $ldap_con;
$result = ldap_search($id, $ldap_dn, $filter); 


$search = false; 
foreach ($result as $value) {
    if(ldap_count_entries($ldap_con, $value) > 0){ 
        $search = $value; 
        break; 
    } 
} 

if($search){ 
    $info = ldap_get_entries($ldap_con, $search); 
}else{ 
    $info = 'No results found'; 
} 

ldap_close($ldap_con);
return ($info[0]['mail'][0]);

}

function getAlias($person)
{

define('LDAP_SERVER', '192.168.136.56');
define('LDAP_PORT', 389);
define('LDAP_USER', 'claromentis');
define('LDAP_PASSWORD', 'ur_claromentis01');

$ldap_dn = 'OU=Sites, DC=sunpowercorp, DC=com';
$ldap_con = ldap_connect(LDAP_SERVER, LDAP_PORT) or die("Could not connect to server. Error is " . ldap_error($ldap_con));
$ldap_bind = ldap_bind($ldap_con, LDAP_USER, LDAP_PASSWORD) or die("Couldn't bind to LDAP!");

#$person = 'rmgebana';
$filter = '(mail='.$person.')'; 

$id[] = $ldap_con;
$result = ldap_search($id, $ldap_dn, $filter); 


$search = false; 
foreach ($result as $value) {
    if(ldap_count_entries($ldap_con, $value) > 0){ 
        $search = $value; 
        break; 
    } 
} 

if($search)
{ 
    $info = ldap_get_entries($ldap_con, $search); 
	ldap_close($ldap_con);
	return ($info[0]['name'][0]);
}
else
{ 
	ldap_close($ldap_con);
    #$info = 'No results found'; 
} 



}



function verify_ldap($login, $passwd) {
 //return 1;
 $login = trim($login);
 $passwd = trim($passwd);
//ldap servers
$ldapDef = array("sunpowercorp.com","DOMSPMX01","DOMSPMX02","DOMDCA01","DOMDCA02");
$logins = array($login . "@sunpowercorp.com",$login . "@spml.sunpowercorp.com",);
$ldapDefSize = sizeof($ldapDef);
$loginsSize = sizeof($logins);

if (strlen(trim($passwd))== 0) return 0;
ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);

//loop on available servers
//if a server fails, it will try to connect on another server. If it's ok the loop will exit
for($i=0; $i < $ldapDefSize; $i++){
for($j=0; $j < $loginsSize; $j++){
if($ds=@ldap_connect($ldapDef[$i],389)){
if ($status=@ldap_bind($ds,$logins[$j],$passwd)) {
@ldap_unbind($ds);
return 1;
}              
}
}
}

@ldap_unbind($ds);
return 0;
}


?>