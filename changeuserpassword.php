<?PHP 
    include ("inc/user_header.php");
    //$_SESSION['user_mahima_session_user_name'];
    $txtLogin = $_SESSION['user_mahima_session_user_name'];

    $msg='';
    if (!isset($_POST["err"]))
    {
        $err = @ $_GET["err"]; 
    	if ($err=='1') 
    	{
    		$msg = "Password Fields Do Not Match";
    	}
    	else
    	{ 
    		$msg = "";
    	}
    }

    $flag   =   0;
    if(isset($_POST["Submit"]))
    {
   	    $txtLogin    =   $_SESSION['user_mahima_session_user_name'];
    	$flag        =   1;
        $new_pass    =   $_POST["new_pass"];
        $conf_pass   =   $_POST["confrm_pass"];
        $user_name   =   $_POST["user_name"];
       
        $status      = (($new_pass   &&  $conf_pass  &&  $user_name) != '') ?1:0;
        if($status)
        { 
        	$txtLogin   = $_SESSION['user_mahima_session_user_name'];
            $sql        = "SELECT * FROM ".$mysql_table_prefix."login_master where UserName = '$txtLogin'";
        	$result     = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
        	if(mysql_num_rows($result) >   0)
        	{
        		$row    = mysql_fetch_array($result);
        	}
        	/*if($new_pass == NULL and  $conf_pass == NULL)
        	{
        	    $new_pass=$row['password'];
        	    $conf_pass=$row['password'];
        	}*/
        	 
        	//////////// ****************** If new Password Fiels do not match with Re-Enter Password field ********************* ////////////////
        	if ($new_pass  !=  $conf_pass)
        	{
        		$flag =   0;
        		echo "<script language='javascript'>";
        		echo "document.location='changeuserpassword.php?err=1'";
            	echo "</script>";
        	}
        	else
        	{	
                $new_pass = mysql_real_escape_string(md5($new_pass));
                $sql      =   "update ".$mysql_table_prefix."login_master set Password ='$new_pass' , Username= '$user_name' where UserName ='$txtLogin'";
        		$result   =   mysql_query($sql) or die("error in query".mysql_errno().":".mysql_error());
                $sql      =   "update ".$mysql_table_prefix."employee_master set password ='$new_pass' , username= '$user_name' where UserName ='$txtLogin'";
        		$result   =   mysql_query($sql) or die("error in query".mysql_errno().":".mysql_error());
        		$msg      =   "You have Successfully Update your details";
        	    $_SESSION['user_mahima_session_user_name'] =   $user_name;
        	//$txtLogin = $_SESSION['user_mahima_session_user_name'];
        	}	
        }
        else
        {
            $msg =  "Please fill all the fields";
        } 
    }    
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snbuser.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Change Password</td>
                </tr>
                <tr>
                    <td class="red" style="padding-top:5px;"><?=$msg?></td>
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
                                                      <td align="left" class="loginTxt" width="71%"><b><? echo $SessionUserName;?></b></td>
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
                                          <td width="40%" align="left" class="loginTxt" style="padding-left:15px;">User name</td>
                                        <td width="60%"><input type="text" name="user_name" id="user_name" value="<?php echo $row['UserName'];?>" style="width:180px; height:20px;"></td>
                                        </tr>
                                        
                                      <input type="hidden" name="password" id="password" value="<?php echo $row['Password'];?>" style="width:180px; height:20px;">
                                        
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
                                                <input type="submit" name="Submit" value="Change Password" >
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