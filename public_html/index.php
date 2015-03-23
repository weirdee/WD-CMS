<?
  require "./templatecontroller.php";
  $master = new templateController();
  require "./datacontroller.php";
  $dataq = new dataController();
 
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
  $master->content["template"] = "/template/";
  $master->content["css"] = "<link rel='stylesheet' href='/style.css'>";
  // указываем <title></title>
  $master->title = "Это просто ТЕСТ";
 
  // выводим результат
  $master->Fill();
?>