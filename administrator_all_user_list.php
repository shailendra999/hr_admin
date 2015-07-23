<? include ("inc/administrator_header.php"); ?>
 <?php 
					if(isset($_GET['del']))
					{
						$LoginId=$_GET['del'];
						
					$que = mysql_query("delete from mpc_login_master where LoginId ='$LoginId'");
					if(!($que))
					{
						$delted = "User Is Not Deleted";
						
					}
				else
				{
					$delted= "User Is Deleted";

				
				}
					
					}
					
					
					
					?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/administrator_snb.php"); ?>
        </td>        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
                </tr>
                <tr>
                	<td  valign="top" style="padding-top:40px; padding-left:40px;">
                    <?php
					include("inc/dbconnection.php");
					?>
                    <table class="border">
                    <tr bgcolor="#F8F8F8" class="tableTxt"><th align="center">UserName</th>
                    <th align="center">Password</th>
                    <th align="center">Name</th>
                    <th align="center">Email-Id</th>
                    <th align="center">UserType</th><th>EDIT</th>
                    <th>DELETE</th>
                    </tr>
                    
                    <?php
					$que = mysql_query("select * from mpc_login_master where UserType !='user'");
					while($row = mysql_fetch_array($que))
					{?>
                    <tr bgcolor="#F8F8F8" class="tableTxt">
                    <td align="center"><?php echo $row[UserName];?></td>
                    <td align="center"><?php echo $row[Password];?></td>
                    <td align="center"><?php echo $row[Name];?></td>
                    <td align="center"><?php echo $row[email_id];?></td>
                    <td align="center"><?php echo $row[UserType];?></td>
                    <td align="center"><a href="http://solutionsofts.com/lss/administrator_update_user.php?loginid=<?php echo $row[LoginId];?>"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
                    
                    
                    
                    
<td align="center"><a href="<?php echo $_SERVER['PHP_SELF']?>?del=<?php echo $row[LoginId];?>"><img src="images/Delete.png" onclick="return delete1();" alt="Delete" title="Delete" border="0"></a></td>
                    </tr>
					<?php
                    }
					?></table>
                   
                  </td>
                  </tr>
                  <tr>
                  <td><label><?php echo $delted; ?></label></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<? include ("inc/hr_footer.php"); ?>	
<script>
function delete1(){
	var answer = confirm ("Are you sure");
if (answer)
return true;
else
return false;

	}
</script>