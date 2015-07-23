<?php
error_reporting(0);

session_start();

if ($_SESSION['mahima_session_user_type'] === 'hr') {
    header('location:hr_homepage.php');
} elseif ($_SESSION['mahima_session_user_type'] === 'adm0') {
    header('location:adm0_homepage.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>LSS HR LOGIN</title>
        <link href="style/adm0_style.css" rel="stylesheet" type="text/css" />
        <?php
        ini_set("display_errors", "0");
        $err = '';
        $msg = '';
        $err = $_REQUEST['err'];
        if ($err == 1) {
            $msg = "Your Login or Password Invalid !";
        }
        if ($err == 2) {
            $msg = "Your Session is Invalid !";
        }
        if ($err == 3) {
            $msg = "Type Not Matched !";
        }
        ?>
    </head>
    <script type="text/javascript">
        document.getElementById('UserId').focus();
        function valid()
        {
            if (document.LoginForm.UserId.value == '' && document.LoginForm.Password.value == '')
            {
                alert("Please Fill Login Or Password !!");
                document.LoginForm.UserId.focus();
                return false;
            }

        }
    </script>
    <body bgcolor="#000000">
        <form id="LoginForm" name="LoginForm" method="post" action="login_check.php">
            <table align="center" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#EEEEEE" height="650px">
                <tr>
                    <td align="center" width="100%" valign="top">
                        <table align="center" cellpadding="0" cellspacing="0" border="0" class="login_bg">
                            <tr>
                                <td colspan="2" align="center" valign="top" style="padding-top:60px;">
                                    <img src="images/web_logo.png"/>
                                    <div style="padding-top:100px;">
                                        <table>
                                            <tr>
                                                <td width="138" valign="top" class="loginTxt">User Id</td>
                                                <td width="242" align="left"><input type="text" id="UserId" name="UserId" value="" style="width:180px; height:20px;"/></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" class="loginTxt">Password</td>
                                                <td align="left"><input type="password" id="Password" name="Password" value="" style="width:180px; height:20px;"/></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="right" style="padding-right:43px;">
                                                    <input type="image" id="LoginSubmit" src="images/btnLogin.png" name="LoginSubmit" value="Login" onclick="return valid()" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" class="red" colspan="2" style="padding-top:30px;"><?= $msg ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div align="center" class="company" style="padding-top:80px;">
                                        e<span class="expert">X</span>pert Solutions by<br />
                                        <a href="http://www.laxyosolutionsoft.com" target="_blank">Laxyo solution soft Pvt. Ltd.</a>
                                    </div><br />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
