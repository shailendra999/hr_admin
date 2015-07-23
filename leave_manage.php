<? include ("inc/hr_header.php"); ?>
<script>

function shift_check(str)
{	
	if(str.value=="Staff")
	{
		//get_frm('get_employe_auto.php',str.value,'div_employee_list','');
		document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"txt1\" onkeyup=\"get_frm('get_employe_auto.php',this.value,'div_employee_list','Staff');\" />";
	}
	else if(str.value=="Worker")
	{
		document.getElementById('div_shift').innerHTML='<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0"><tr><td class="text_1" style="padding-top:0px;">Shift<span class="red">*</span></td><td><select name="shift_detail" id="shift_detail" onchange="shift_check_1(this.value)"><option value="">---Select---</option><option value="First">First</option><option value="Second">Second</option><option value="Third">Third</option></select></td></tr></table>';
		document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"txt1\" onkeyup=\"get_frm('get_employe_auto.php',this.value,'div_employee_list','Worker');\" />";
	}
}

function shift_check_1(str)
{
	document.getElementById('div_txt_autocomplete').innerHTML="<input type=\"text\" value=\"\" id=\"txt1\" onkeyup=\"get_frm('get_employe_auto.php',this.value+'&worker_shift="+str+"','div_employee_list','Worker');\" />";
	
}
</script>
<?
$ticket_no="";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Leave Management</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td width="100%" colspan="2" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                        <tr>
                                            <!--<td class="text_1" width="15%">Type<span class="red">*</span></td>
                                            <td width="20%">
                                            <select name="employee_type" id="employee_type" onChange="shift_check(this)" style="width:150px; height:22px;">
                                                <option value="">---Select---</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Worker">Worker</option>
                                            </select>
                                            </td>
                                            <td width="30%" class="text_1" style="padding-right:15px; text-align:right;">
                                            	<div id="div_shift">
                                                </div>
                                            </td>
                                             <td class="text_1" width="15%" style="text-align:right; padding-right:15px;">Name<span class="red">*</span></td>
                                            <td width="20%"><div id="div_txt_autocomplete"><input type="text" value="" id="txt1" onKeyPress="" style="width:150px; height:22px;"/></div></td>-->
                                            <td class="text_1" style="padding-left:15px;">Employee List</td>
                                    		<td>
                                			<input type="text" id="emp_search" name="emp_search" onkeydown="if(event.keyCode && event.keyCode == 13){get_frm_menu('get_employe_auto.php',this.value,'div_employee_list','');}" value="<?=$ticket_no?>"/>
                                            </td>
                                            <td width="60%" class="text_1" style="padding-top:5px;">
                                             <form name="frm_check" id="frm_check">
                                                <input type="radio" id="search_by" name="search_by" value="ID" checked="checked" onclick="get_frm_menu('get_employe_auto.php',document.getElementById('emp_search').value,'div_employee_list','')" />ID
                                                     <input type="radio" id="search_by" name="search_by"  value="Name" onclick="get_frm_menu('get_employe_auto.php',document.getElementById('emp_search').value,'div_employee_list','')"/>Name
                                       </form>  
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
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<? include ("inc/hr_footer.php"); ?>	