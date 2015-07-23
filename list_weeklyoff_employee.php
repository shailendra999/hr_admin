<?php
	include("inc/hr_header.php");
?>
<?
	$msg="";
	$ticket_no="";
?>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
//////////// *************** Delete Salary ************** ///////////////
if(isset($_POST["btn_del"]))
{
	$rec_id  = $_POST["hidden_overlay"];
	$sql = "delete from mpc_weekly_off_employee where rec_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$msg = "Weekly Off Entry Sucessfully Deleted";
}	
?>
<?
@$current_date=date('Y-m-d');
////////////////////// Markin attendence //////////////
if(isset($_POST['off_days']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{	
		$id = $_POST['emp_id'];
		$off_days=$_POST['off_days'];
		$txt_to_date=getdbDateSepretoe($_POST['txt_to_date']);
		$txt_from_date=getdbDateSepretoe($_POST['txt_from_date']);
		$weeklyoff_id=$_POST['weeklyoff_id'];

		
		$sql = "SELECT * FROM ".$mysql_table_prefix."weekly_off_employee where emp_id = '$id' and ((
		'$txt_from_date'>=from_date and '$txt_from_date'<=to_date) or ('$txt_to_date'>=to_date))and rec_id !='$weeklyoff_id'";
		$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
			if(mysql_num_rows($result)>0)
				{
					while($row = mysql_fetch_array($result))
					{
					
						if(strtotime($txt_from_date)>=strtotime($row['from_date']) and strtotime($txt_from_date)<=strtotime($row['to_date']))
						{
							$sql_check = "Update ".$mysql_table_prefix."weekly_off_employee set	
																						  to_date ='$txt_from_date' where rec_id='".$row['rec_id']."'";
																	
							$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
							
						}
						else if(strtotime($txt_to_date)>=strtotime($row['from_date']) and ($row['to_date']=='0000-00-00'))
						{
							 $sql_check = "Update ".$mysql_table_prefix."weekly_off_employee set	
																						   from_date ='$txt_to_date' where rec_id='".$row['rec_id']."'";
																	
							$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
							
						}
						else if(strtotime($txt_to_date)>=strtotime($row['from_date']) and strtotime($txt_to_date)<=strtotime($row['to_date']))
						{
							 $sql_check = "Update ".$mysql_table_prefix."weekly_off_employee set	
																						  from_date ='$txt_to_date' where rec_id='".$row['rec_id']."'";
																	
							$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
						}
						else
						{
							 $sql = "delete from ".$mysql_table_prefix."weekly_off_employee where rec_id='".$row['rec_id']."' and to_date!='0000-00-00'";
							 mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
							 
							 if(strtotime($current_date)==strtotime($txt_to_date))
								{
									$sql = "delete from ".$mysql_table_prefix."weekly_off_employee where rec_id='".$row['rec_id']."'";
									 mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
								}
						}
					}
				}	
		if(strtotime($current_date)==strtotime($txt_to_date))
		{
			$txt_to_date="0000-00-00";
		}
		$sql_check = "Update ".$mysql_table_prefix."weekly_off_employee set	
																		emp_id ='$id',
																		off_day ='$off_days',
																		from_date 	='$txt_from_date',
																		to_date ='$txt_to_date' where rec_id='$weeklyoff_id'";
																	
		$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());			
		$msg="Weekly Off Updated";
		$_SESSION['no_refresh'] = $_POST['no_refresh'];
	}
}
?>
<script type="text/javascript" src="javascript/common_function.js"></script>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0" bgcolor="#FFFFFF">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Employee Weekly Off</td>
                </tr>
                <tr>
                	<td class="red" align="center"><?=$msg?></td>
                </tr>
				<tr>
                	<td valign="top">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                        	<tr>
                            	<td>
                                	<table cellpadding="0" cellspacing="0" border="0" align="left" class="loginbg" width="100%">
                                        <tr>
                                          <td width="15%" class="text_1" style="padding-left:15px;">Employee List</td>
                                     	  <td width="15%">
                                     
                                			<input type="text" id="emp_search" name="emp_search" onkeydown="if(event.keyCode && event.keyCode == 13){get_frm_menu('employee_list_weeklyoff.php',this.value,'emp_list','');}" value="<?=$ticket_no?>"/>
                                            </td>
                                            <td width="24%" class="text_1" style="padding-top:5px;">
                                             <form name="frm_check" id="frm_check">
                                                <input type="radio" id="search_by" name="search_by" value="ID" checked="checked" onclick="get_frm_menu('employee_list_weeklyoff.php',document.getElementById('emp_search').value,'emp_list','')" />ID
                                                     <input type="radio" id="search_by" name="search_by"  value="Name" onclick="get_frm_menu('employee_list_weeklyoff.php',document.getElementById('emp_search').value,'emp_list','')"/>Name
                                       </form>  
                                          </td>
                                      </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div id="div_edit"></div>
                                </td>                                        
                            </tr>
                            <tr>
                            	<td valign="top">
                            		<div id="emp_list" style="overflow:scroll;height:300px;">
								    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV>   
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<div id="overlay">
     <div class="form_msg">
          <p>Are you sure to delete this Weekly Off</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<? include ("inc/hr_footer.php"); ?>	
