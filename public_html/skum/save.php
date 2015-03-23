<?php
include_once("db.php");
	mysql_connect($sqlhost, $sqluser, $sqlpass);
	mysql_select_db($sqltable);
	$txt = $_POST['content'];
	$id = $_POST['id'];
	mysql_query("UPDATE data SET text='".$txt."' WHERE id = '".$id."'");
?>