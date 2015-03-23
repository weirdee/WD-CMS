<?
require "./datacontroller.php";
  $dataq = new dataController();
if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{   
	$userdata = $dataq->LoginGetUserData(intval($_COOKIE['id']));
    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
)
    {
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
        print "nope <br />";
    }
    else
    {
        print "<div class='underadmin'></div><div class='isadmin'>Привет, ".$userdata['user_login'].". Вы в режиме админиcтрирования.<a href='logout.php'>Выход</a></div>";
		
	$txt = $_POST['content'];
	$id = $_POST['id'];
	$dataq->SetText($txt, $id);
		
		// присоединяем класс управления шаблонами
  require "./templatecontrollerad.php";
 
  // создаем экземпляр класса управления шаблонами
  $master = new templateController();
 
  // указываем новый файл шаблона
  $master->templateName = "./template/index.html";
 
  // указываем контент для блока MainContent
  $texts[] = $dataq->GetAllTexts();
  foreach($texts as $texts => $strings)
  {
	  foreach($strings as $string)
	  {
  		$master->content[$string[id]] = $string[text];
	  }
  }
  $master->content["editorjs"] = "
  		<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
  		<script type='text/javascript' language='javascript'>
			// <![CDATA[
			function ClickToSave (id) {
				var data = CKEDITOR.instances[id].getData();
				$.post('/admin.php', {
					content : data,
					id : id
					})
				}
			// ]]>
		</script>";
	$master->content["template"] = "/template/";
	$master->content["css"] = "<link rel='stylesheet' href='/style.css'>";
  // указываем <title></title>
  $master->title = "Это просто ТЕСТ";
 
  // выводим результат
  $master->Fill();
		
		
		
		
    }
}
else
{
    print "НИХТ! НАЙН! КАПИТУЛИРЕН!<br /><a href='login.php'>Попробовать войти как все нормальные люди</a>";
}
?>

