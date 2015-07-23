<? include ("inc/administrator_header.php"); ?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/administrator_snb.php"); ?></td>
    <td style="padding-left:5px; padding-top:5px;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
        </tr>
          <tr>
        
          <td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
        
          <form action="" method="post">
        
        <table>
          <tr>
            <td> UserName(required) </td>
            <td><input type="text" name="username" id="username" required></td>
          </tr>
          <tr>
            <td>Password(required)</td>
            <td><input type="password" name="upassword" id="upassword" required></td>
          </tr>
          <tr>
            <td>Name(required)</td>
            <td><input type="text" name="personalname" id="personalname" required></td>
          </tr>
          <tr>
            <td>Email Id(required)</td>
            <td><input type="email" name="emailid" id="emailid" required></td>
          </tr>
          <tr>
            <td>User Type</td>
            <td><select name="utype">
                    <option value="">Select</option>
                
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
                <option value="Hr">Hr</option>
                <option value="Dispatch">Dispatch</option>
                <option value="Adm0">Adm0</option>
                <option value="Adm1">Adm1</option>
                <option value="Store">Store</option>
                <option value="Maint">Maint</option>
                <option value="Elec">Elec</option>
                <option value="Purchase">Purchase</option>
                <option value="AddPurchase">AddPurchase</option>
                <option value="Administrator">Administrator</option>
               <!-- <option value="User">User</option>-->
              </select></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="Save"></td>
          </tr>
        </table>
          </td>
        
          </tr>
        
      </table>
      </form>
      <?php 
	  if(isset($_POST['submit']))
	  {
		  $loginid = "";
		  $username = $_POST['username'];
		  $password = $_POST['upassword'];
		  $name = $_POST['personalname'];
		  $email = $_POST['emailid'];
		  $usertype = $_POST['utype'];
		  $isactive = "1";
		  $today = date("Y-m-d H:i:s"); 
		  include("inc/dbconnection.php");
		  $que = mysql_query("insert into mpc_login_master values('$loginid','$username','$password','$name','$email','$usertype','$isactive','$today')");
		  if((!$que))
		  {
			  echo"Please create user again";
		  }
		  else
		  {
			  echo"user successfully cteated";
			  echo '<script>window.location="http://solutionsofts.com/mah_database/administrator_all_user_list.php"</script>';
		  }
		  $subject = "Laxyo Solution Soft User Registration";
      $txt = "User is successfully registred with Laxyo Solution Soft Pvt. Ltd. with UserName :".$username." And Password :".$password."";
          $headers = "From: webmaster@example.com" . "\r\n" .
          "CC: somebodyelse@example.com";
		   mail($email,$subject,$txt,$headers);
		  
		  	  }
	   ?></td>
  </tr>
</table>

<? include ("inc/hr_footer.php"); ?>
