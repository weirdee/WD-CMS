<?
/*
  ������ ���������� ���������
  �����: ������ �������
  04 ����� 2007 ����
  mailto:admin@kbyte.ru
  Copyright (c) Nemiro AS, 2007
*/
 
class templateController {
 
  public $content;       // ��� �������� ��������
  public $templateName;  // ��� ����� �������
  public $errorMessage;  // ��������� �� ������
  public $title;         // ��������� <title></tile>
      
  // �������������
  function templateController() {
    $content = array();
    $templateName = "";
    $errorMessage = "";
    $title = "";
  }
  // ����� ������
  function Fill() {
    // �������� �������
    $result = file_get_contents($this->templateName);
    if (!$result) {
      $errorMessage = "<span style='color: Red'>
      ������: ���� �������
      <strong>".$this->templateName."</strong>
      �� ������.</span><br />";
      return $errorMessage;
    } else {
      // ���� <title></title>
      $titleTemplate = "(<title>(.*)</title>)|(<TITLE>(.*)</TITLE>)|(<Title>(.*)</Title>)";
      if (ereg($titleTemplate, $result, $ss)) {
        if ($this->title != NULL) {
          $newTitle = $this->title;
          $result = ereg_replace($titleTemplate, "<title>$newTitle</title>", $result);
        }
      }
 			$id = 1;
      // ����� � ������ ������ �������� ����� ���������
      while ($s = current($this->content)) {
		  
		  if ( !in_array(key($this->content), array('editorjs','template','css'), true ) )
		  {
        $result = str_replace("<php:".key($this->content).">", "<div id='".$id."' contenteditable='true'>".$s."</div>
<button onclick='ClickToSave(".$id.")'>Save</button>", $result);
			$id = $id+1;
		  }
		  else
		  {
			  $result = str_replace("<php:".key($this->content).">", $s, $result);
		  }
        next($this->content);
      }
                   
      echo $result;
    }       
  }
  
 
}
 
?>