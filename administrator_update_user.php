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
          <?php $loginid = $_REQUEST['loginid'];
		  
		  
		  ?>
          <?php
		  $que = mysql_query("select * from mpc_login_master where LoginId='$loginid'");
		  while($row = mysql_fetch_array($que))
		  {?>
            <td> UserName </td>
            <td><input type="text" requried name="username" id="username" value="<?php echo $row[UserName];?>"></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input type="password" requried name="upassword" id="upassword" value="<?php echo $row[Password];?>"></td>
          </tr>
          <tr>
            <td>Name</td>
            <td><input type="text" requried name="personalname" id="personalname" value="<?php echo $row[Name];?>"></td>
          </tr>
          <tr>
            <td>Email Id</td>
            <td><input type="text" requried name="emailid" id="emailid" value="<?php echo $row[email_id];?>"></td>
          </tr>
          <tr>
            <td>User Type</td>
            <td><select name="utype">
            
            <option value="">Select</option>
                
                <option <?php if($row[UserType] == Admin){echo 'selected';} ?> value="Admin">Admin</option>
                <option <?php if($row[UserType] == Hr){echo 'selected';} ?>  value="Hr">Hr</option>
                <option <?php if($row[UserType] == Dispatch){echo 'selected';} ?>  value="Dispatch">Dispatch</option>
                <option <?php if($row[UserType] == Store){echo 'selected';} ?>  value="Store">Store</option>
                <option <?php if($row[UserType] == Maint){echo 'selected';} ?>  value="Maint">Maint</option>
                <option <?php if($row[UserType] == Elec){echo 'selected';} ?>  value="Elec">Elec</option>
                <option <?php if($row[UserType] == Purchase){echo 'selected';} ?>  value="Purchase">Purchase</option>
                <option <?php if($row[UserType] == AddPurchase){echo 'selected';} ?>  value="AddPurchase">AddPurchase</option>
                <option <?php if($row[UserType] == Administrator){echo 'selected';} ?>  value="Administrator">Administrator</option>
               
                     </select></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><input type="submit" name="submit" id="submit" value="EDIT"></td>
          </tr>
        </table>
          </td>
        
          </tr>
        <?php }?>
      </table>
      </form>
      <?php 
	  if(isset($_POST['submit']))
	  {
		  $loginid = $_REQUEST['loginid'];
		  $username = $_POST['username'];
		  $password = $_POST['upassword'];
		  $name = $_POST['personalname'];
		  $email = $_POST['emailid'];
		  $usertype = $_POST['utype'];
		  $isactive = "1";
		  $today = date("Y-m-d H:i:s"); 
		  include("inc/dbconnection.php");
		  $que = mysql_query("update mpc_login_master set UserName='$username',Password='$password',Name='$name',email_id='$email',UserType='$usertype',IsActive=' $isactive',InsertDate='$today' where LoginId='$loginid'");
		  if((!$que))
		  {
			  echo"Please create user again";
		  }
		  else
		  {
			  echo"user successfully updated";
			  echo '<script>window.location="http://solutionsofts.com/lss/administrator_all_user_list.php"</script>';
		  }
		 
		  
		  	  }
	   ?></td>
  </tr>
</table>
<? include ("inc/hr_footer.php"); ?>
