<?
	setcookie("id", "", time()+60);
    setcookie("hash","", time()+60);
	header("Location: login.php"); 
	exit();
?>

