<?
// �������� ����������� ������ ������������
# ���������� � ��
include_once("db.php");
	mysql_connect($sqlhost, $sqluser, $sqlpass);
	mysql_select_db($sqltable);

if(isset($_POST['submit']))
{
    $err = array();
    # �������� �����
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "����� ����� �������� ������ �� ���� ����������� �������� � ����";
    }  

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "����� ������ ���� �� ������ 3-� �������� � �� ������ 30";
    }   

    # ���������, �� ��������� �� ������������ � ����� ������

    $query = mysql_query("SELECT COUNT(user_id) FROM users WHERE user_login='".mysql_real_escape_string($_POST['login'])."'");
    if(mysql_result($query, 0) > 0)
    {
        $err[] = "������������ � ����� ������� ��� ���������� � ���� ������";
    }    
    # ���� ��� ������, �� ��������� � �� ������ ������������
    if(count($err) == 0)
    {        
        $login = $_POST['login'];       

        # ������� ������ ������� � ������ ������� ����������
        $password = md5(md5(trim($_POST['password'])));      

        mysql_query("INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        header("Location: login.php"); exit();
    }
    else
    {
        print "<b>��� ����������� ��������� ��������� ������:</b><br>";
        foreach($err AS $error)
        {
            print $error."<br>";
        }
    }
}
?>

<form method="POST">

����� <input name="login" type="text"><br>

������ <input name="password" type="password"><br>

<input name="submit" type="submit" value="������������������">

</form>