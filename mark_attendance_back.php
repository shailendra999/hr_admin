<? include ("inc/hr_header.php"); ?>
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
<script>
function shift_check(str)
{	
	if(str.value=="Staff")
		{			
			

			document.getElementById('div_shift').innerHTML="";
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list.php',this.value+'&type=Staff','div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'attendace\')){document.getElementById(\'attendace\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById(\'update_emp\').focus();}else{alert(\'Wrong Id'\)}}}\" />";
			
		 document.getElementById('employee_id').focus();
			
		 //	get_frm('get_employee_list.php',str.value,'div_employee_list',document.getElementById('txt_date').value);
			
		}
	else if(str.value=="Worker")
		{		
			var date = document.getElementById('txt_date').value;
			document.getElementById('div_shift').innerHTML='<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0"><tr><td class="text_1" style="padding-top:0px;">Shift<span class="red">*</span></td><td><select name="shift_detail" id="shift_detail" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById(\'employee_id\').focus();}"><option value="">---Select---</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="G">G</option></select></td></tr></table>';
			
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list.php',this.value+'&type='+document.getElementById('shift_detail').value,'div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'designation\')){document.getElementById(\'designation\').focus();}else{if(document.getElementById(\'update_emp\')){document.getElementById(\'update_emp\').focus();}else{alert(\'Wrong Id'\);}}}\" />";
			
			document.getElementById('shift_detail').focus();		
		}
}
</script>
<script type="text/javascript" src="date_picker/Bs_Misc.js"></script>
<script type="text/javascript" src="date_picker/Bs_Button.js"></script>
<script type="text/javascript" src="date_picker/Bs_NumberField.js"></script>
<script type="text/javascript" src="date_picker/Bs_TitleToTooltip.js"></script>

<script>
if (moz) {
  document.writeln("<link rel='stylesheet' href='/_bsJavascript/components/toolbar/win2k_mz.css'>");
} else {
  document.writeln("<link rel='stylesheet' href='/_bsJavascript/components/toolbar/win2k_ie.css'>");
}

function init(count) {
	for(var i=1;i<=count;i++)
	{
		//udpate the form with the current time:
		var dateNow = new Date();
		document.getElementById('fldHour_'+i).value = 8; //dateNow.getHours();
		document.getElementById('fldMin_'+i).value  = dateNow.getMinutes();
		
		document.getElementById('out_Hour_'+i).value = 8; //dateNow.getHours();
		document.getElementById('out_Min_'+i).value  = dateNow.getMinutes();
		
		//title to tooltip feature:
		bs_ttt_initAll();
		
		hourObj = new Bs_NumberField('fldHour_'+i);
		hourObj.drawButtonsInside = true;
		hourObj.zeroFill          = 2;
		hourObj.minValue          = 0;
		hourObj.maxValue          = 23;
		hourObj.draw();
		
		minObj = new Bs_NumberField('fldMin_'+i);
		minObj.drawButtonsInside = true;
		minObj.zeroFill          = 2;
		minObj.minValue          = 0;
		minObj.maxValue          = 59;
		minObj.draw();
		
		hourObj = new Bs_NumberField('out_Hour_'+i);
		hourObj.drawButtonsInside = true;
		hourObj.zeroFill          = 2;
		hourObj.minValue          = 0;
		hourObj.maxValue          = 23;
		hourObj.draw();
		
		minObj = new Bs_NumberField('out_Min_'+i);
		minObj.drawButtonsInside = true;
		minObj.zeroFill          = 2;
		minObj.minValue          = 0;
		minObj.maxValue          = 59;
		minObj.draw();
		
	}
}
</script><link rel="stylesheet" href="date_picker/win2k_mz.css">
<style>
.foo {
position:absolute;
}
</style>

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
                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendence Date<span class="red">*</span></td>
                                          <td width="15%"><input type="text"
         name="txt_date" id="txt_date" value="<?=$date?>" style="width:100px; height:20px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}"/>
                                            <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.frm_emp_list.txt_date);"><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""  onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_type').focus();}"></a>                                            
                                            </td>
                                          <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type<span class="red">*</span></td>
<td width="13%"><select name="employee_type" id="employee_type" onChange="shift_check(this)" style="width:100px; height:20px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_id').focus();}">
                                                <option value="">---Select---</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Worker">Worker</option>
                                            </select> 
                                            </td>
                                            <td width="16%" align="left" style="padding-left:20px;">
                                       	  <div id="div_shift">
                                          
                                          </div> 
                                          </td>
                                          <td width="13%" class="text_1" style="padding-right:15px; text-align:right;">Emp Id<span class="red">*</span></td>
                                      	  <td width="24%" align="left" style="padding-left:20px;">
                                       		<div id="div_txt_autocomplete">
                                        	<input type="text" name="employee_id" id="employee_id" value=""/>    
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	