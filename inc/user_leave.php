<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
<?php
include("inc/hr_header.php");  
include("inc/dbconnection.php");
 require_once  ("inc/function.php"); ?>
<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
//$(function() {
//    $( "#txt_start_date" ).datepicker();
//	$("#txt_end_date").datepicker();
//  });
  </script>
 <?php $pgName = "";

include("inc/hr_header.php"); 
include("inc/dbconnection.php");
require_once  ("inc/function.php");
//$id = $_GET["id"];
$username=$_SESSION['user_mahima_session_user_name'];
$que=mysql_query("select ticket_no from mpc_employee_master where username='$username'");
$row=mysql_fetch_array($que);

    $id=$row['ticket_no'];
	$sql = "SELECT mpc_employee_master.*,mpc_official_detail.emp_category,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM mpc_employee_master,mpc_account_detail,mpc_official_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$id' order by first_name";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	
$row=mysql_fetch_array($result);
	
/*echo '<pre>';
print_r($row);
die()*/;
?>
<? $left_pl=getLeaveAllowed("pl",$row["emp_category"])-getLeave($row["emp_id"],"Pl")?>
                <?
					/*if($left_pl==0)
						{
					    	echo $left_pl; 
						}
					else
						{
						?>
                        	<a href="leave_application.php?emp_id=<?=$row["emp_id"]?>&leave_type=PL"><?=$left_pl?></a><?php ?>
						<?	
						}*/
						
				?>
                
                <? $left_cl=getLeaveAllowed("cl",$row["emp_category"])-getLeave($row["emp_id"],"Cl")?>
                 <?
					/*if($left_cl==0)
						{
					    	echo $left_cl; 
						}
					else
						{
						?>
                      <a href="leave_application.php?emp_id=<?=$row["emp_id"]?>&leave_type=CL"><?=$left_cl?></a>
						<?	
						}*/
						
	
				?>


<?php /*?><?php if(isset($_POST['submit'])){
	echo '<pre>';
	print_r($_POST);
	
	} ?><?php */?>

<div style="float:left" >
<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snbuser.php"); ?></td>
    <td style="padding-left:5px; padding-top:5px;"></td>
  </tr>
</table>
</div>
<div style="float:center">

<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0" >
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Welcome to Laxyo Solution Soft Pvt. Ltd.</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:40px; padding-left:40px;">
		  <form action="" method="post">
              
              <table style="background:white; border-radius:3px; padding-top:20px; padding-bottom:20px; padding-right:10px; padding-left:10px;">
                <tbody class="tbody"><tr>
                  <td style="font-family:Verdana, Geneva, sans-serif; color:'Black';"><b>Remaining Leave</b></td>
                  <td><label style="font-family:Verdana, Geneva, sans-serif; color:'Black';">PL</label>&nbsp;&nbsp;&nbsp;<label style="font-family:Verdana, Geneva, sans-serif; color:'Black';"><?=$left_pl?></label>&nbsp;&nbsp;&nbsp;<label style="font-family:Verdana, Geneva, sans-serif; color:'Black';">CL</label>&nbsp;&nbsp;&nbsp;<label style="font-family:Verdana, Geneva, sans-serif; color:'Black';"><?=$left_cl?></label></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;"><b>Apply to Leave</b></td>
                  <td></td>
                </tr>
                
                <tr class="focus">
                  <td style="font-family:Verdana, Geneva, sans-serif;">Start Date<span class="red">*</span></td>
                  <td>
                  <input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_start_date" id="txt_start_date" value="" />
                  <!--<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_leave.txt_start_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>--></td>
                  
                  
                  
                  <!--<input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" required="" id="from_date" name="from_date"></td>-->
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;">End Date<span class="red">*</span></td>
                  <td>
                  
                  <input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" name="txt_end_date" id="txt_end_date" value="" />
                  <!--<a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_leave.txt_end_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a>-->
                  <!--<input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" required="" id="to_date" name="to_date">--></td>
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;">Type<span class="red">*</span></td>
                  <td><select style="border:solid 1px #333; border-radius:5px; height:25px;" name="typeleave"><option>----</option>
                  <option >Cl</option>
                  <option>PL</option>
                  </select></td>
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;">To <span class="red">*</span></td>
                  <td><input type="email" style="border:solid 1px #333; border-radius:5px; height:25px;" required="" id="email_to" name="email_to"></td>
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;">Subject<span class="red">*</span></td>
                  <td><input type="text" style="border:solid 1px #333; border-radius:5px; height:25px;" required="" id="subject" name="subject"></td>
                </tr>
                <tr>
                  <td style="font-family:Verdana, Geneva, sans-serif;">Reason/Description<span class="red">*</span></td>
                  <td><textarea style="border: 1px solid rgb(51, 51, 51); border-radius: 5px; width: 172px; height: 68px;" name="reason"></textarea></td>
                </tr>
                <tr>
                  <td align="center" colspan="4"><input type="submit" style="border:solid 1px #333; border-radius:5px; height:25px;" value="Send" id="submit" name="submit"></td>
                </tr>
              </tbody></table>
          
            </form></td></tr><tr>
            <td><label><?php echo $exists; ?></label></td>
        </tr>
        
      </table>
</div>
<?php
if(isset($_POST['submit']))
{
	
	$txt_start_date=$_POST['txt_start_date'];
	$txt_end_date=$_POST['txt_end_date'];
	$typeleave=$_POST['typeleave'];
	$email_to=$_POST['email_to'];
	$cc=$_POST['cc'];
	$subject=$_POST['subject'];
	$reason=$_POST['reason'];
    $a=$row['first_name'];
    $message = "Dear sir, \r\n I m ".$a." and just want to inform u that i \r\n  will  not able to come office from ".$txt_start_date." to ".$txt_end_date." so plz approve my \r\n leave so plz mark my ".$typeleave."  and the reason is that  ".$reason;
	
	$msg = mail($email_to , $subject, $message);
	echo"mail send";
	
}
?>