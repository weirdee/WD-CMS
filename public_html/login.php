<?
// Страница авторизации
# Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
# Соединямся с БД
require "./datacontroller.php";
  $dataq = new dataController();
if(isset($_POST['submit1']))
{
    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $data = $dataq->LoginGetMd5(mysql_real_escape_string($_POST['login']));  
    # Соавниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));           

        if(!@$_POST['not_attach_ip'])
        {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            $insip = "1";
        }       

        # Записываем в БД новый хеш авторизации и IP 
		$dataq->LoginWriteHash($hash, $insip, $data['user_id'], $_SERVER['REMOTE_ADDR']);
        # Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);       

        # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: admin.php"); exit();
    }
    else
    {
        print "Вы ввели неправильный логин/пароль";
    }
}
?>
<form method="POST">
Логин <input name="login" type="text"><br>
Пароль <input name="password" type="password"><br>
Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>
<input name="submit1" type="submit" value="Войти">
</form>