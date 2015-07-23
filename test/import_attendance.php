<? include ("inc/hr_header.php"); ?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form){
	return(
		checkString(form.elements["FromDate"],"From Date",false) &&	checkString(form.elements["ToDate"],"To Date",false)
	);
}

</script>
<?php
if(isset($_POST['btn_submit']))
{
	
$FromDate=$_POST['FromDate'];
$ToDate=$_POST['ToDate'];
$conn = mysql_connect('localhost','ssofts_mahima','HUUFNdWSmi].')or die ("Couldn't connect to server.");
$db = mysql_select_db('ssofts_mah', $conn)or die ("Couldn't select database.");
$que=mysql_query("SELECT * FROM `mpc_attendence_master`");
print_r($que);
	
	}
?>

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
		                    <table width="100%" cellpadding="2" cellspacing="2" border="0" align="center" class="border" style="padding-top:10px;">
	                            <tr>
    		                        <td class="text_1">From Date</td>
                                        <td align="left"><input type="text" name="FromDate" id="FromDate" readonly style="width:150px; height:20px;" value=""/><a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_import_attendance.FromDate);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                </tr>
                                <tr>
    		                        <td class="text_1">To Date</td>
                                        <td align="left"><input type="text" name="ToDate" id="ToDate" readonly style="width:150px; height:20px;" value=""/><a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_import_attendance.ToDate);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                                </tr>
                                <tr>
                                	<td>
                                    	<input type="submit"  value="Submit" name="btn_submit" id="btn_submit"/>
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
