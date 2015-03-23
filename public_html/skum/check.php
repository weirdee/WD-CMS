<?
// Скрипт проверки
# Соединямся с БД
include_once("db.php");
	mysql_connect($sqlhost, $sqluser, $sqlpass);
	mysql_select_db($sqltable);
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   
    $query = mysql_query("SELECT *,INET_NTOA(user_ip) FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysql_fetch_assoc($query);
    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
)
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "Хм, что-то не получилось <br />";
		print $userdata['user_ip'];
		print "<br />";
		print $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        print "Привет, ".$userdata['user_login'].". Всё работает!";
		$gettext = mysql_query("SELECT text FROM data WHERE id = 1");

    }
}
else
{
    print "Включите куки";
}
?>

<html>
<head>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'></script>
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' language='javascript'>
// <![CDATA[
function ClickToSave () {
    var data = CKEDITOR.instances.textToBeSaved.getData();
    $.post('/save.php', {
        content : data
        })
    }
// ]]>
</script>
</head>
<body>
<div id='textToBeSaved' contenteditable='true'>
    <?php echo mysql_result($gettext, 0); ?>
</div>
<button onclick='ClickToSave()'>Save</button>
</body>
</html>
