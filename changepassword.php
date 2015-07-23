<? include ("inc/adm0_header.php"); ?>
<script type="text/javascript">
    function valid()
    {
        if (document.chnge_pass.new_pass.value == '' && document.chnge_pass.confrm_pass.value == '')
        {
            alert("Please Fill Password !!");
            return false;
        }
    }
</script>
<?
$msg = '';
if (!isset($_POST["err"])) {
    $err = @ $_GET["err"];
    if ($err == '1') {
        $msg = "Password Fields Do Not Match";
    } else {
        $msg = "";
    }
}
?>
<?
$flag = 0;

$txtLogin = $SessionUserName;
if (isset($_POST["Submit"])) {
    $flag = 1;
    $txtLogin = $SessionUserName;
    $new_pass = $_POST["new_pass"];
    $conf_pass = $_POST["confrm_pass"];

    //////////// ****************** If new Password Fiels do not match with Re-Enter Password field *********************////////////////
    if ($new_pass != $conf_pass) {
        $flag = 0;
        echo "<script language='javascript'>";
        echo "document.location='changepassword.php?err=1'";
        echo "</script>";
    } else {
        $sql = "update " . $mysql_table_prefix . "login_master set Password ='$new_pass' where UserName ='$txtLogin'";
        $result = mysql_query($sql) or die("error in query" . mysql_errno() . ":" . mysql_error());
        $msg = "You have Successfully Change the Password";
    }
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/adm0_snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Change Password</td>
                </tr>
                <tr>
                    <td class="red" style="padding-top:5px;"><?= $msg ?></td>
                </tr> 
                <tr>
                    <td style="padding-top:20px;" valign="top">
                        <form name="chnge_pass" id="chnge_pass" method="post" action="">
                            <table align="center" width="40%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="left" width="10px"><img src="images/tnb_left.jpg" width="10" height="35"/></td>
                                                <td class="welcome_txt" align="left">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td align="left" width="27%" class="orange_head">User Name</td>
                                                            <td align="left" width="2%">
                                                                <img src="images/tnb_div_1.jpg" width="7" height="35"/>
                                                            </td>
                                                            <td align="left" class="loginTxt" width="71%"><b><? echo $SessionUserName; ?></b></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="right" width="10px"><img src="images/tnb_right.jpg" width="10" height="35"/></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top:10px;">
                                        <table align="center" width="100%" cellpadding="5" cellspacing="5" border="0" style="border:1px solid #C6B4AE;" bgcolor="#F5F2F1">
                                            <tr> 
                                                <td width="40%" align="left" class="loginTxt" style="padding-left:15px;">New Password</td>
                                                <td width="60%"><input type="password" name="new_pass" id="new_pass" value="" style="width:180px; height:20px;"></td>
                                            </tr>
                                            <tr> 
                                                <td align="left" class="loginTxt" style="padding-left:15px;padding-bottom:5px;">Re-Enter Password</td>
                                                <td><input type="password" name="confrm_pass" id="confrm_pass" value="" style="width:180px; height:20px;"></td>
                                            </tr>
                                            <tr> 
                                                <td colspan="2" align="center" style="padding-top:15px;">
                                                    <input type="submit" name="Submit" value="Change Password" onClick="return valid()">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </form>                  
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<? include ("inc/footer.php"); ?>	