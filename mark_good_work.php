<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#txt_date" ).datepicker();
  });
  </script>-->
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script> -->
<!-- eND HERE -->
<?php
@include ("inc/hr_header.php"); 
$date=""; ?>
<script>
$(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
</script>

<!--<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script> -->
<script>
function shift_check(str){	
	if(str.value=="Staff"){			
			//document.getElementById('div_shift').innerHTML="";
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list_good.php',this.value+'&type='+document.getElementById('employee_type').value+'&shift='+document.getElementById('shift_detail').value,'div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'good_work\')){document.getElementById(\'good_work\').focus();}else{document.getElementById(\'update_emp\').focus();}}\" onfocus='validate_attendence();'/>";
			
		 //document.getElementById('employee_id').focus();
			
		 //	get_frm('get_employee_list.php',str.value,'div_employee_list',document.getElementById('txt_date').value);
			
		}else if(str.value=="Worker"){		
			var date = document.getElementById('txt_date').value;
			//document.getElementById('div_shift').innerHTML='<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0"><tr><td class="text_1" style="padding-top:0px;">Shift<span class="red">*</span></td><td><select name="shift_detail" id="shift_detail" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById(\'employee_id\').focus();}"><option value="">---Select---</option><option value="First">First</option><option value="Second">Second</option><option value="Third">Third</option></select></td></tr></table>';
			
			document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"employee_id\" onkeyup=\"get_frm('get_employee_list_good.php',this.value+'&type='+document.getElementById('employee_type').value+'&shift='+document.getElementById('shift_detail').value,'div_employee_list',document.getElementById('txt_date').value);\" onkeydown=\"if(event.keyCode && event.keyCode == 13){if(document.getElementById(\'good_work\')){document.getElementById(\'good_work\').focus();}else{document.getElementById(\'update_emp\').focus();}}\" onfocus='validate_attendence();'/>";
			
			document.getElementById('shift_detail').focus();		
		}
}
</script>
<? @$current_date=date('d'); @$current_month=date('m'); @$current_year=date('Y'); ?>
<script>
function validate_attendence(){
	return(
				checkString(document.frm_emp_list.txt_date,"Date",false) &&	
				checkString(document.frm_emp_list.employee_type,"Employee Type",false) &&	
				checkString(document.frm_emp_list.shift_detail,"Shift",false)									
		   );
}
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td>
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendence master-> </a>mark over time</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                     <form id="frm_emp_list" name="frm_emp_list" method="post" action="">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td width="100%" colspan="2" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                        <tr>
                                            <td class="text_1" style="padding-left:15px;" width="12%">Over Time Date<span class="red">*</span></td>
                                          <td width="15%"><input type="text"
         name="txt_date" id="txt_date" value="<?=$date?>" style="width:100px; height:20px;" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']"/>
         
                                           </td>
                                          <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type<span class="red">*</span></td>
<td width="13%"><select name="employee_type" id="employee_type" onChange="shift_check(this)" style="width:100px; height:25px;" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('shift_detail').focus();}">
                                                
                                                <option value="">---Select---</option>
                                                     <?php 
												$que=mysql_query("select type_name from mpc_employee_type_master");
												
												while($row=mysql_fetch_array($que))
												 {
												 ?>
                                                   <option value="<?php echo $row['type_name']?>" ><?php  echo $row['type_name'];  ?> </option>
										<?php } ?>
                                           </select> 
                                            </td>
                                            <td width="18%" align="left" style="padding-left:20px;">
                                       	    <div id="div_shift">
                                          Shift<span class="red">*</span>&nbsp;&nbsp;&nbsp;&nbsp;<select name="shift_detail" id="shift_detail" onkeydown="if(event.keyCode && event.keyCode == 13){document.getElementById('employee_id').focus();}"><option value="">---Select---</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="G">G</option></select>
                                          </div>
                                          </td>
                                          <td width="13%" class="text_1" style="padding-right:15px; text-align:right;">Emp Id<span class="red">*</span></td>
                                      	  <td width="17%" align="left" style="padding-left:20px;">
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
