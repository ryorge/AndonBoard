<html>
<head>
<title>Sunpower Ensenada - Andon Board</title>
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
table {
	border-spacing:0; 
	border-collapse:collapse;
	padding:0px;
	padding-bottom:0px;
}
h1 {
	font-size: 110px;
	font-family: Verdana, Geneva, sans-serif;
	margin:-10px; 

}
th {text-align:center; height: 10px;}
</style>
<script src="./jquery/jquery-1.4.4.js"></script>
<script>

 $(document).ready(function() {
 getContent(); //intialize first
   var refreshId = setInterval('getContent()', 300000);   
});
function getContent(){
	 $("#responsecontainer").load("status_inner.php?rand="+Math.random(200) +"&<?php echo $_SERVER["QUERY_STRING"] ?>");	
	  $.ajaxSetup({cache: false}); 
}
</script>

</head>
<body bgcolor='white'>
<center> 
<div id="responsecontainer">
<img src='loading.gif'>
</div>


</body>