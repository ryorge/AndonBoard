<?php
session_start();
session_destroy();
$error=$_GET['action'];
if ($error=="InvalidLogin")
{
$msg="  * Incorrect Username or Password.";
}
elseif($error=="NotAuthorized")
{
$msg="  * You are not authorized to login to this page.";
}
else
{
$msg="";
}


?>






<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SUNPOWER SPMX2 Production Status Board</title>

<style type="text/css">
body {
	background-color: #FC0;
	font: 11px/24px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #5A698B;
}

#title {
	width: 330px;
	height: 31px;
	color: #ffffff;
	font: bold 11px/18px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	padding-top: 5px;
	background: transparent url("images/bg_legend.gif") no-repeat;
	text-transform: uppercase;
	letter-spacing: 2px;
	text-align: center;
}

#bottom {
	width: 330px;
	height: 26px;
	color: #ffffff;
	font: bold 11px/18px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	padding-top: 5px;
	
	text-transform: uppercase;
	letter-spacing: 2px;
	text-align: center;
}

form {
	width: 335px;
}

.col1 {
	text-align: right;
	width: 135px;
	height: 31px;
	margin: 0;
	float: left;
	margin-right: 2px;
	background: url(images/bg_label.gif) no-repeat;
}

.col2 {
	width: 195px;
	height: 31px;
	display: block;
	float: left;
	margin: 0;
	background: url(images/bg_textfield.gif) no-repeat;
}
.col3 {
	width: 195px;
	height: 35px;
	display: block;
	float: left;
	margin: 0;
	background: url(images/bg_textfield.gif) no-repeat;
}

.col2comment {
	width: 195px;
	height: 98px;
	margin: 0;
	display: block;
	float: left;
	background: url(images/bg_textarea.gif) no-repeat;
}

.col1comment {
	text-align: right;
	width: 135px;
	height: 98px;
	float: left;
	display: block;
	margin-right: 2px;
	background: url(images/bg_label_comment.gif) no-repeat;
}

div.row {
	clear: both;
	width: 335px;
}

div.spacer {
	clear: both;
	width: 335px;
	height:0px;
}

.submit {
	height: 29px;
	width: 330px;
	background: url(images/bg_submit.gif) no-repeat;
	padding-top: 5px;
	clear: both;
} 

.input {
	background-color: #fff;
	font: 11px/14px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #5A698B;
	margin: 4px 0 5px 8px;
	padding: 1px;
	border: 1px solid #000;
	font-family: "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	display: table-cell;
	top: 0px;
}

.select {
	background-color: #fff;
	font: 11px/14px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #5A698B;
	margin: 4px 0 5px 8px;
	padding: 1px;
	border: 0px solid #8595B2;
}

.textarea {
	border: 1px solid #8595B2;
	background-color: #fff;
	font: 11px/14px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #5A698B;
	margin: 4px 0 5px 8px;
}

select {
	font: 11px/14px "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	height: 30px;
}


body,td,th {
	color: #000;
	font-family: "Lucida Grande", "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.msg {
	color: #000;
}
a:link {
	color: #FFF;
}
a:visited {
	color: #03F;
	font-weight: bold;
	font-size: 14px;
}


</style>

</head>

<body>

<center>

<table height="554" border="0" cellpadding="0" cellspacing="0" style="color: #03F; background-image: url(bg.jpg);" >
<td height="230"><form id="form1" name="form1" method="post" action="verify.php">
  <tr>
    <th width="198" height="30" scope="row">&nbsp;</th>
    <td width="334">&nbsp;</td>
  </tr>
  <tr>
    <th height="33" scope="row">&nbsp;</th>
    <td height="0"><input name="username" type="text" class="input" id="username" size="20" tabindex="1"  /></td>
  </tr>
  <tr>
    <th height="33" scope="row"><span class="row">&nbsp;</span></th>
    <td>
      <input name="password" class="input" type="password" id="password" size="20" tabindex="2" />
 </td>
  </tr>
 

  <tr>
    <th height="24" scope="row">&nbsp;</th>
    <td> <input type="submit" name="submit" id="submit" value="      OK       " /></td>
  </tr>
  <tr>
    <th height="170" colspan="2" class="msg" scope="row"><?php echo $msg; ?></th>
  </tr>
  <tr>
    <th height="30" colspan="2" class="msg" scope="row">&nbsp;</th>
  </tr>
</table>
</form>
</body>
</html>