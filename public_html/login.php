<?
// �������� �����������
# ������� ��� ��������� ��������� ������
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
}
# ���������� � ��
require "./datacontroller.php";
  $dataq = new dataController();
if(isset($_POST['submit1']))
{
    # ����������� �� �� ������, � ������� ����� ���������� ����������
    $data = $dataq->LoginGetMd5(mysql_real_escape_string($_POST['login']));  
    # ���������� ������
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        # ���������� ��������� ����� � ������� ���
        $hash = md5(generateCode(10));           

        if(!@$_POST['not_attach_ip'])
        {
            # ���� ������������ ������ �������� � IP
            # ��������� IP � ������
            $insip = "1";
        }       

        # ���������� � �� ����� ��� ����������� � IP 
		$dataq->LoginWriteHash($hash, $insip, $data['user_id'], $_SERVER['REMOTE_ADDR']);
        # ������ ����
        setcookie("id", $data['user_id'], time()+60*60*24*30);
        setcookie("hash", $hash, time()+60*60*24*30);       

        # ���������������� ������� �� �������� �������� ������ �������
        header("Location: admin.php"); exit();
    }
    else
    {
        print "�� ����� ������������ �����/������";
    }
}
?>
<form method="POST">
����� <input name="login" type="text"><br>
������ <input name="password" type="password"><br>
�� ����������� � IP(�� ���������) <input type="checkbox" name="not_attach_ip"><br>
<input name="submit1" type="submit" value="�����">
</form>