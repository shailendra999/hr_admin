<? include ("inc/hr_header.php"); ?>
<?
$date="";

?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>


<?
////////////////////// Markin attendence //////////////
if(isset($_POST['btn_attend']))
{

$emp_id=$_POST['emp_id'];
$emp_name=$_POST['emp_name'];
echo $txt_date=getdbDate($_POST['txt_date']);
echo $txt_todate=getdbDate($_POST['txt_todate']);


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
																			emp_name='$emp_name',
																			attendance_status='$status',
																			date ='$txt_date',
																			todate ='$txt_todate',

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
<script>
function shift_check(str)
{	
	if(str.value=="Staff")
		{			
var date = document.getElementById('txt_date').value;
var date1 = document.getElementById('txt_date1').value;
			
			//document.getElementById('div_shift').innerHTML="";
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list_monthly.php',this.value+'&type='+document.getElementById('employee_type').value+'&shift='+document.getElementById('shift_detail').value+'&sdate='+document.getElementById('txt_date1').value,'div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'attendace\')){document.getElementById(\'attendace\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById(\'update_emp\').focus();}else{alert(\'Wrong Id'\)}}}\" onfocus='validate_attendence();' />";
			
		 //document.getElementById('employee_id').focus();
			
		 //	get_frm('get_employee_list_monthly.php',str.value,'div_employee_list',document.getElementById('txt_date').value);
			
		}
	else if(str.value=="Worker")
		{		
			var date = document.getElementById('txt_date').value;
			var date1 = document.getElementById('txt_date1').value;
	
			//document.getElementById('div_shift').innerHTML='<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0"><tr><td class="text_1" style="padding-top:0px;">Shift<span class="red">*</span></td><td><select name="shift_detail" id="shift_detail" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById(\'employee_id\').focus();}"><option value="">---Select---</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="G">G</option></select></td></tr></table>';
			
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list_monthly.php',this.value+'&type='+document.getElementById('employee_type').value+'&shift='+document.getElementById('shift_detail').value+'&sdate='+document.getElementById('txt_date1').value,'div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'designation\')){document.getElementById(\'designation\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById('').focus();}else{alert(\'Wrong Id'\);}}}\" onfocus='validate_attendence();'/>";
			
			document.getElementById('shift_detail').focus();		
		}
}
</script>
<script>
function validate_attendence()
{
	return(
				checkString(document.frm_emp_list.txt_date,"Date",false) &&	
				checkString(document.frm_emp_list.employee_type,"Employee Type",false) &&	
				checkString(document.frm_emp_list.shift_detail,"Shift",false) &&
				checkString(document.frm_emp_list.txt_date1,"S_date",false)									
		   );
}
</script>
<?
	$current_date=date('d');
	$current_month=date('m');
	$current_year=date('Y');
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
		
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Mark Attendence</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                     <form id="frm_emp_list" name="frm_emp_list" method="post" action="">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td width="100%" colspan="2" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                        <tr>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance From Date<span class="red">*</span></td><td width="15%"><input type="text"
         name="txt_date" id="txt_date" value="<?=$date?>" style="width:100px; height:20px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}" readonly="readonly"/>
          <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.txt_date,[[1980,1,1],[
          <?=$current_year?>,<?=$current_month?>,<?=$current_date?>],[2010,08]]);">
          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""  
          onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}" /></a></td>
                                 
          <td class="text_1" style="padding-left:15px;" width="12%">Attendence To Date<span class="red">*</span></td>
                                          <td width="15%"><input type="text"
         name="txt_todate" id="txt_date1" value="<?=$date?>" style="width:100px; height:20px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}" readonly="readonly"/>
         <a href="javascript:void(0)" onclick="gfPop.fPopCalendar(document.frm_emp_list.txt_date1,[[1980,1,1],[
          <?=$current_year?>,<?=$current_month?>,<?=$current_date?>],[2010,08]]);">
          <img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="27" height="22" border="0" alt=""  
          onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}" /></a>
          </td>
                                          
                                          <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type
                                  <span class="red">*</span></td>
<td width="13%"><select name="employee_type" id="employee_type" onChange="shift_check(this)" style="width:100px; height:20px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('shift_detail').focus();}">
                                                <option value="">---Select---</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Worker">Worker</option>
                                            </select>                                            </td>
                                            <td width="16%" align="left" style="padding-left:20px;">
                                       	  <div id="div_shift">
                                          <select name="shift_detail" id="shift_detail" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_id').focus();}"><option value="">---Select---</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="G">G</option></select>
                                          </div>                                          </td>
                                          <td width="13%" class="text_1" style="padding-right:15px; text-align:right;">
											  Emp Id<span class="red">*</span></td>
                                      	  <td width="24%" align="left" style="padding-left:20px;">
                                       		<div id="div_txt_autocomplete">
                                        		<input type="text" name="employee_id" id="employee_id" value="" onfocus="validate_attendence();"/>    
                                         
                                         
                                            </div>    
                                                  
                                          </td>
                                      </tr>
                                    </table>
                              </td>
                            </tr>
                            <tr>
                            	<td>
                                	  <div id="div_employee_list" style="height:200px;overflow:auto;width:100%;padding-top:10px;"align="center">
                                     
                                       </div>  
                                </td>
                            </tr>
                            <tr>
                            	<td>
                           <div id="div_employee_last" style="height:200px;overflow:auto;width:100%;padding-top:10px;"align="center">
                                     
                                      </div> 
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
                        <div class="test" name="test" id="test">
                        <div id="form">

<?php

include "inc/dbconnection.php"; //Connect to Database

//$deleterecords = "TRUNCATE TABLE table_name"; //empty the table of its current records

//mysql_query($deleterecords);

//Upload File
if (isset($_POST['submit'])) {
	if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
		echo "<h1>" . "File ". $_FILES['filename']['name'] ." uploaded successfully." . "</h1>";
		echo "<h2>Displaying contents:</h2>";
		readfile($_FILES['filename']['tmp_name']);
	}

	//Import uploaded file to Database
	$handle = fopen($_FILES['filename']['tmp_name'], "r");

	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		echo'<pre>';
		print_r($data);
	}
	?>
    <?php die();?>
		
		$import="INSERT into mpc_attendence_master(rec_id,emp_id,attendance_status,date,time,shift) values('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[6]')";

		mysql_query($import) or die(mysql_error());
	}

	fclose($handle);

	print "Import done";

	//view upload form
else {

	print "Upload new csv by browsing to file and clicking on Upload<br />\n";

	print "<form enctype='multipart/form-data' action='#' method='post'>";

	print "File name to import:<br />\n";

	print "<input size='50' type='file' name='filename'><br />\n";

	print "<input type='submit' name='submit' value='Upload'></form>";

}

?>

</div>
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
