<? include ("inc/hr_header.php"); ?>
 <link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<!--eND HERE-->
<script>
$(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
</script>
<?
$date="";
$department="";
$shift="";

?>
<?
if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
{
$table_list="";
$where_string="";
$select_string="";
$date=$_POST['txt_date'];
$shift=$_POST['shift_detail'];
$department=$_POST['department'];
$sub_department=$_POST['sub_department'];

if($_POST["department"]!="" and $_POST["sub_department"]=="")
		{	
		
		$select_string= ",mpc_department_employee.*,mpc_department_master.*";
		$department=$_POST["department"];
		$table_list.= ",mpc_department_employee,mpc_department_master";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
		}
		if($_POST["sub_department"]!="")
		{
			$select_string= ",mpc_department_employee.*";	
			$department=$_POST["department"];
			$sub_department=$_POST["sub_department"];
			$table_list.= ",mpc_department_employee";
			
			$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
		}
if($sub_department=="")
{
	$sub_department=$_POST['department'];
}
$date=$_POST['txt_date'];
$shift=$_POST['shift_detail'];
}
?>
<?

?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        <td style="padding-left:5px; padding-top:5px;vertical-align:top;" >
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Shift Wise Over Time Report</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                    <form id="frm_absent_list" name="frm_absent_list" method="post" action="shift_wise_daily_good_work_report.php">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                                <td width="100%" colspan="2" align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                                        <tr>
                                            <td class="text_1" style="padding-left:15px;" width="7%">Date<span class="red">*</span></td>
                                            <td width="21%"><input type="text" name="txt_date" id="txt_date" value="<?=$date?>" style="width:140px; height:20px;" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']" />
                  </td>
                                             <td width="12%" class="text_1" style="padding-right:15px; text-align:right;">Shift<span class="red">*</span></td>											 
                                             <td>
                                          <select name="shift_detail" id="shift_detail">
                                          	<option value="">---Select---</option>
                                            <option value="A" <? if($shift=='A') {echo 'selected="selected"';}?>>A</option>
                                            <option value="B" <? if($shift=='B') {echo 'selected="selected"';}?>>B</option>
                                            <option value="C" <? if($shift=='C') {echo 'selected="selected"';}?>>C</option>
                                            <option value="G" <? if($shift=='G') {echo 'selected="selected"';}?>>G</option>
                                          </select>
                                            </td>
                                             <td width="24%" class="text_1">
                                                Dept.
													<?
                                                         $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
                                                         $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                         ?>
                                            <select name="department" id="department" style="width:150px; height:25px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
                                                        <option value="">Select</option>
                                                         <?
                                                      while ($row=mysql_fetch_array($result))
                                                        {	?>
                                                               <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$department){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
                                                        <?  }	?>
                                            </select>
                                          </td>
                                          <td width="32%" class="text_1">
                                                Sub Dept.
                               			    <div id="div_sub_dept" style="display:inline;">
								 			 <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                    <option value="">Select</option>
											  </select>
                                       		</div>
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
                <tr>
                    <td align="center" valign="top" style="padding-top:5px;">
                        <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                               <?  
							   $start=0;
							   
                            if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
                                {
								 $sql_emp = "select mpc_good_work_master.*, mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name $select_string from ".$mysql_table_prefix."employee_master,mpc_good_work_master $table_list where mpc_employee_master.rec_id = mpc_good_work_master.emp_id and date='".getdbdate($date)."' and shift='".$shift."' and mpc_good_work_master.good_work!='0:0' $where_string  order by ticket_no ASC";
                            $result_emp = mysql_query($sql_emp) or die("Error in Query :".$sql_emp."<br>".mysql_error().":".mysql_errno());
                                if(mysql_num_rows($result_emp)>0)
                                {
                                $sno = $start+1;
                                ?>
                                <tr>
                                   <td align="right">
                                            <table cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td>
                                                        <form action="shift_wise_good_work.php" method="post" name="frm_print" id="frm_print" target="_blank">
                                                            <input type="hidden" name="txt_date" id="txt_date" value="<?=$date?>"/>
                                                            <input type="hidden" name="shift_detail" id="shift_detail" value="<?=$shift?>"/>
                                                            <input type="hidden" name="department" id="department" value="<?=$department?>"/>
                                                            <input type="hidden" name="sub_department" id="sub_department" value="<?=$sub_department?>"/>
                                                            <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                        </form>
                                                            </td>
                                                            <td valign="top">
                                                        <form action="shift_wise_good_work_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                            <input type="hidden" name="txt_date" id="txt_date" value="<?=$date?>"/>
                                                            <input type="hidden" name="shift_detail" id="shift_detail" value="<?=$shift?>"/>
                                                            <input type="hidden" name="department" id="department" value="<?=$department?>"/>
                                                            <input type="hidden" name="sub_department" id="sub_department" value="<?=$sub_department?>"/>
                                                        </form>
                                                        <a href="javascript:;" onclick="frm_print_xls.submit()" class="AddMore" >Export To XLS</a>  
                                                      </td>
                                                </tr>
                                             </table>
                                   </td>
                                </tr> 
               					<tr>
                                 <td align="center" colspan="2">
                                        <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                <table width="100%">
                                                        <tr class="gredBg">
                                                            <td width="11%" align="center">
                                                                SNO                   
                                                            </td>
                                                            <td width="13%" align="center">
                                                                EMPLOYEE ID                    
                                                             </td>
                                                             <td width="33%" align="left">
                                                                NAME                  
                                                              </td>
                                                           <!-- <td width="22%" align="left">
                                                                Designation                
                                                            </td>-->
                                                             <td width="21%" align="center">
                                                                Over Time                 
                                                            </td>
                                                         </tr>	
                                                        <?
                                             
                                                        if(mysql_num_rows($result_emp)>0)
                                                                {
                                                                    $s=1;
                                                                 while($row_emp=mysql_fetch_array($result_emp))
                                                                        {
                                                                        ?>
                                                                        <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                            <td align="center"><?=$s?></td>
                                                                            <td align="center"><?=$row_emp['ticket_no']?></td>
                                                                            <td align="left">
                                                                                <?=$row_emp['first_name']?> <?=$row_emp['last_name']?>
                                                                            </td>
                                                                             <!--<td align="left">
                                                                             
                                                                                <?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$row_emp['emp_id'],getdbdate($date)));?>
                                                                            </td>-->
                                                                            <td align="center">
                                                                                <?=$row_emp['good_work']?>
                                                                            </td>
                                                                           
                                                                        </tr>                                
                                                                        <?		
                                                                        $s++;
                                                                        }
                                                                }		
                                                        ?>		                                              	
                                                    </table>
                                           </div>
                                 </td>
                       	 		</tr>
								 <?
                                 }	 
                                 else
                                 {
                                 ?>
                                 <tr class="table_rows">
                                    <td align="center" colspan="8">No records found</td>
                                  </tr>
                                 <?
                                  }
                                } 
                                  ?>
                         </table>
       				 </td>
                 </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	