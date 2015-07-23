<? include ("inc/hr_header.php"); ?>
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script> -->
<!--eND HERE-->
<script>
$(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
</script>
<?
$date="";
?>
<?
////////////////////// Markin attendence //////////////
if(isset($_POST['btn_attend']))
{

$emp_id=$_POST['emp_id'];
$txt_date=getdbDate($_POST['txt_date']);
$ip = $_SERVER['REMOTE_ADDR'];
$i=1;
	foreach($emp_id as $id)
	{	
	 $id;	
	 $hr=$_POST['fldHour_'.$i];
	 $min=$_POST['fldMin_'.$i];
	 
	 $hr_out=$_POST['out_Hour_'.$i];
	 $min_out=$_POST['out_Min_'.$i];

	 
	 $status=$_POST['attendace'.$id];
	 
	 $good_work=$_POST['good_work_'.$id];
	 $sec="00";
	 
	 
	 
	 $time=$hr.":".$min.":".$sec;
	 $time_out=$hr_out.":".$min_out.":".$sec;
	 
	 $sql_check = "insert into ".$mysql_table_prefix."attendence_master set	
																	emp_id ='$id',
																	attendance_status='$status',
																	date ='$txt_date',
																	time ='$time',
																	time_out ='$time_out',
																	good_work ='$good_work',
																	InsertBy ='$id',
																	InsertDate =now(),
																	IpAddress ='$ip'";
																	
	$result_check=mysql_query($sql_check) or die ("Query Failed ".mysql_error());
	$i++;
}
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;vertical-align:top;" >
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Deptt/Shift Wise Long Leave Report</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                    <form id="frm_absent_list" name="frm_absent_list" method="post" action="shift_wise_long_leave_report_excel.php" target="_blank">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td width="100%" colspan="2" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                        <tr>
                                            <td class="text_1" style="padding-left:15px;" width="15%">Date<span class="red">*</span></td>
                                            <td width="21%"><input type="text" name="txt_date" id="txt_date" value="<?=$date?>" style="width:100px; height:20px;" data-beatpicker="true"/>
                                            </td>
                                             <td width="12%" class="text_1" style="padding-right:15px; text-align:right;">Shift<span class="red">*</span></td>											 <td>
                                         <select name="shift_detail" id="shift_detail">
                                          	<option value="">---Select---</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="G">G</option>
                                          </select>
                                            </td>
                                           	<td align="center" style="padding-top:5px;">
                                        		<input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                        		<input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	