<? include ("inc/hr_header.php"); ?>
<!--STRAT FROM HERE-->
<!-- <link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>-->
<!--eND HERE-->
 <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">-->
 <script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form){
	return(
		checkString(form.elements["FromDate"],"From Date",false) &&	checkString(form.elements["ToDate"],"To Date",false)
	);
}

</script>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
   	  <td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px; vertical-align:top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                    <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Import Employee Attendance</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                    <td class="red"></td>
                </tr>
                <tr>
                	<td valign="top">
                    	<form name="frm_import_attendance" id="frm_import_attendance" action="import_attendance.php" method="post" onSubmit="return validate_form(this);">
		                    <table width="100%" cellpadding="2" cellspacing="2" border="0" align="center" class="border" style="padding-top:10px; margin-top:10px;">
	                            <tr>
    		                        <td class="text_1">From Date</td>
                                        <td align="left"><input type="text" name="FromDate" id="FromDate" style="width:150px; height:20px;" value="" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']" data-beatpicker="true"/></td>
                                </tr>
                                <tr>
    		                        <td class="text_1">To Date</td>
                                        <td align="left"><input type="text" name="ToDate" id="ToDate" style="width:150px; height:20px;" value="" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']"  data-beatpicker="true" /></td>
                                </tr>
                                <tr>
                                	<td>
                                    	<input type="submit"  value="Submit" name="btn_submit" id="btn_submit" class="btn_bg"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <?php
if(isset($_POST['btn_submit']))
{
	
$FromDate=$_POST['FromDate'];
$ToDate=$_POST['ToDate'];
include("inc/dbconnection.php");
?>
<div style="overflow:scroll;height:300px;">
<table border="0" align="center" width="100%" style="overflow-y:scroll;" class="border">
					<tbody><tr class="blackHead">
					   <td align="center" width="6%">Employee Id</td>
					   <td align="center" width="7%">Insert Date</td>
                       <td align="center" width="8%">Employee Name</td>
					   <td align="center" width="21%">AttandanceStatus</td>
					   						<td align="center" width="19%">Shift</td>
                                            
						
				 <?php /* $que = mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_employee_master.emp_id = mpc_attendence_master.emp_id
WHERE `date` between '$FromDate' and '$ToDate'"); */?>

				<?php 
				
				
				 
$que = mysql_query("SELECT mpc_attendence_master.*,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_employee_master.ticket_no
FROM `mpc_attendence_master` inner join `mpc_employee_master` on mpc_attendence_master.emp_id =   mpc_employee_master.emp_id
WHERE `date` between '$FromDate' and '$ToDate'"); ?>
<?php
while($row = mysql_fetch_array($que))
{
	/*echo'<pre>';
	print_r($row);
	*/
	?>
								<tr bgcolor="#F8F8F8" class="tableTxt">
						<td align="center"><?php echo $row[ticket_no];?></td>
						<td align="center"><?php echo $row[date];?></td>
						<td align="center"><?php echo $row[first_name];?>&nbsp;<?php echo $row[last_name];?></td>
					    <td align="center"><?php echo $row[attendance_status];?></td> 
						 <td align="center"><?php echo $row[shift];?> </td>
                        
						
					</tr>
                    </tbody>
                    <?php
	}
	
	}
?>
			           	    
			</table></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>











</div>

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
<? include ("inc/hr_footer.php"); ?>
