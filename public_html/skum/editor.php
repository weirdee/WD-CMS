<?php
	include_once("db.php");
	mysql_connect($sqlhost, $sqluser, $sqlpass);
	mysql_select_db($sqltable);
	if (mysqli_connect_errno()) {
		echo "����������� ����������: ".mysqli_connect_error();
	}
	else {
	$query = mysql_query("SELECT text FROM data WHERE id = 1");

?>
<html>
<head>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'></script>
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' language='javascript'>
// <![CDATA[
function ClickToSave () {
    var data = CKEDITOR.instances.textToBeSaved.getData();
    $.post('save.php', {
        content : data
        })
    }
// ]]>
</script>
</head>
<body>
<div id='textToBeSaved' contenteditable='true'>
    <?php echo mysql_result($query, 0); ?>
</div>
<button onclick='ClickToSave()'>Save</button>
</body>
</html>