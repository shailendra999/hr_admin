<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
/*$(function() {
    $( "#date_joining" ).datepicker();
	$("#date_pf").datepicker();
	$("#wife_dob").datepicker();
  });*/
  $(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
  </script>


<div <? if($mode=='experience_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';}?>>
<form name="offical_profile" id="offical_profile" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
  <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
    <tr>
      <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
          <tr>
            <td class="text_1">Date of Joining</td>
            <td align="left"><input type="text" name="date_joining" id="date_joining" style="width:150px; height:20px;" value="<?=$date_joining?>" data-beatpicker="true" />
              </td>
          </tr>
          <tr>
            <td class="text_1">Plant</td>
            <td  align="left"><?
													 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
              <select name="plant_name" id="plant_name" style="width:150px; height:25px;">
                <option value="">Select</option>
                <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant){?> selected="selected" <? } ?>>
                <?=$row["plant_name"]?>
                </option>
                <?  }	?>
              </select></td>
          </tr>
          <tr>
            <td class="text_1">Department</td>
            <td align="left"><?
													 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
              <select name="department" id="department" style="width:150px; height:25px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
                <option value="">Select</option>
                <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dep){?> selected="selected" <? } ?>>
                <?=$row["department_name"]?>
                </option>
                <?  }	?>
              </select></td>
          </tr>
          <tr>
            <td class="text_1">Sub Department</td>
            <td align="left"><div id="div_sub_dept">
                <?
													 $sql = "SELECT * FROM mpc_department_master where reference_id !='0' order by department_name";
													 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onChange="">
                  <option value="">Select</option>
                  <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
                  <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$dept_id){?> selected="selected" <? } ?>>
                  <?=$row["department_name"]?>
                  </option>
                  <?  }	?>
                </select>
              </div></td>
          </tr>
          <tr>
            <td class="text_1">Reporting Authority name</td>
            <td align="left"><input type="text" name="authority_name" id="authority_name" style="width:150px; height:20px;" value="<?=$reporting_authority_name?>"/></td>
          </tr>
        </table></td>
      <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" height="185px">
          <tr>
            <td class="text_1">Grade</td>
            <td align="left">
            <select name="grade">
            <option value="E1"<? if($grade=='E1'){echo 'selected="selected"';}?>>E1</option>
            <option value="E2"<? if($grade=='E2'){echo 'selected="selected"';}?>>E2</option>
            <option value="E3"<? if($grade=='E3'){echo 'selected="selected"';}?>>E3</option>
            <option value="E4"<? if($grade=='E4'){echo 'selected="selected"';}?>>E4</option>
            <option value="E5"<? if($grade=='E5'){echo 'selected="selected"';}?>>E5</option>
            <option value="E6"<? if($grade=='E6'){echo 'selected="selected"';}?>>E6</option>
            
            </select>
            
            
            
            
            </td>
          </tr>
          <tr>
            <td class="text_1">PAN No.</td>
            <td align="left"><div id="div_add_div">
                <input type="text" name="pan_no" id="pan_no" style="width:150px; height:20px;" value="<?=$pan_no?>"/>
              </div></td>
          </tr>
          <tr>
            <td class="text_1">Employee Type</td>
            <td align="left"><select name="emp_type" id="emp_type">
                <option value="fix_salary" <? if($employee_typ=='fix_salary'){ echo 'selected="selected"';} ?> >Fix Salary</option>
                <option value="daily_wages" <? if($employee_typ=='daily_wages'){ echo 'selected="selected"';} ?>>Daily Wages</option>
              </select></td>
          </tr>
          <tr>
            <td class="text_1">Employee Catagory</td>
            <td align="left"><select  name="emp_category" id="emp_category" onChange="get_frm('get_designation.php',this.value,'designation_div','designation');">
                <option value="staff" <? if($emp_category=='staff'){ echo 'selected="selected"';}?>>Staff</option>
                <option value="worker" <? if($emp_category=='Worker'){ echo 'selected="selected"';}?>>Worker</option>
              </select></td>
          </tr>
          <tr>
            <td class="text_1">Designation</td>
            <td align="left"><div id="designation_div">
                <?
													$sql = "SELECT * FROM  mpc_designation_master where emp_category  = '$emp_category' order by designation_name";
													$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
												?>
                <select name="designation" id="designation" style="width:150px; height:25px;">
                  <option value="">Select</option>
                  <?
														if(mysql_num_rows($result_city)>0)
														{
															while($row_city = mysql_fetch_array($result_city))
															{
															?>
                  <option value="<?=$row_city['rec_id']?>" <? if($row_city['rec_id']==$designation_id){ echo 'selected="selected"';}?>>
                  <?=$row_city['designation_name']?>
                  </option>
                  <?
															}
														}
													?>
                </select>
              </div></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:center;"><!-- ************************************Added pf details************************************************  *** -->
        
        <div id="div_show" >
          <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
            <tr>
              <td colspan="2">PF Detail</td>
            </tr>
            <tr>
              <td align="left" width="50%"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td class="text_1">PF Number(If Any)</td>
                    <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value="<?=$pf_number?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">PF Rate</td>
                    <td><input type="text" name="pf_rate" id="pf_rate" style="width:180px; height:20px;" value="<?=$pf_rate?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Date of PF Membership</td>
                    <td align="left"><input type="text" name="date_pf" id="date_pf" style="width:150px; height:20px;" value="<?=getDatetime($date_pf)?>" data-beatpicker="true" />
                      </td>
                  </tr>
                </table></td>
              <td width="50%"><table width="100%" height="100px" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td class="text_1">PF Nominee</td>
                    <td><input type="text" name="pf_nominee" id="pf_nominee" style="width:180px; height:20px;" value="<?=$pf_nominee?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="pf_relationship" id="pf_relationship" style="width:180px; height:20px;" value="<?=$pf_relationship?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">PF</td>
                    <td>Celling
                <input type="radio" name="pf_deduction" id="celling" value="yes" <?php if($pf_deduction=='yes'){ ?>checked="checked"<? }?>/>
                Not Celling
                <input type="radio" name="pf_deduction" id="nocelling" value="no" <?php if($pf_deduction=='no'){ ?>checked="checked"<? }?> /></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td colspan="2">Bonus Detail</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top" width="50%"><table width="100%" height="67px" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1" width="100%">Bonus Rate&nbsp;&nbsp;Bonus <span class="red">*</span>
                            <input type="text" name="bonus_rate" id="bonus_rate" value="<?=$bonus_rate?>" required /></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center"><!--<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_insert_bank',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'<?//=$id?>')"/>--></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td colspan="2">ESIC Detail (Employee State Insurance Corporation)
                Applicable
                <input type="radio" name="esic_applicable" id="applicable" value="applicable" <?php if($esic_applicable=='applicable'){ ?>checked="checked"<? }?>/>
                Not Applicable
                <input type="radio" name="esic_applicable" id="notapplicable" value="notapplicable" <?php if($esic_applicable=='notapplicable'){ ?>checked="checked"<? }?> /></td>
            </tr>
            
            
            <tr class="test">
              <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td width="35%" class="text_1">ESIC Number</td>
                    <td width="65%"><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value="<?=$esic_number?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">ESIC Rate</td>
                    <td><input type="text" name="esic_rate" id="esic_rate" style="width:180px; height:20px;" value="<?=$esic_rate?>"/></td>
                  </tr>
                </table></td>
              <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td class="text_1">ESIC Nominee</td>
                    <td><input type="text" name="esic_nominee" id="esic_nominee" style="width:180px; height:20px;" value="<?=$esic_nominee?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">RelationShip</td>
                    <td><input type="text" name="esic_relationship" id="esic_relationship" style="width:180px; height:20px;" value="<?=$esic_relationship?>"/></td>
                  </tr>
                 
                </table></td>
            </tr>
            <tr>
              <td align="center" colspan="2"><?php /*?><input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm_long('pf_update.php',document.getElementById('pf_no').value,'div_detail',document.getElementById('pf_rate').value,document.getElementById('pf_nominee').value,document.getElementById('pf_relationship').value,document.getElementById('esic_no').value,document.getElementById('esic_rate').value,document.getElementById('esic_nominee').value,document.getElementById('esic_relationship').value,'<?=$id?>','','')"/><?php */?>
                <input type="hidden" name="emp_id" id="emp_id" value="<?=$id?>"/>
                <input type="hidden" name="update" id="update" value="<?=$id?>"/></td>
            </tr>
          </table>
        </div></td>
      <!--****************************************End**************************************************--> 
      
      <!--****************************************Shift_details************************************************-->
      
      <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
        <tr>
          <td colspan="2">Shift Detail</td>
        </tr>
        <tr>
          <td align="left"><table border="0" align="center" width="123%" cellspacing="2" cellpadding="2" class="border" style="margin-left:0px">
              <tr>
                <td class="text_1" width="40%">Rotation Type</td>
                <td align="left" width="60%"><div id="div_rotation_type_edit">
                    <div id="div_rotation_type"></div>
                  </div></td>
                <!--<td class="text_1"></td>-->
                <td align="center" valign="middle"><select name="rotation_type" id="rotation_type" style="width:150px; height:25px;">
                    <option <?php if($rotation_type == 'Weekly'){echo 'selected';} ?> value="Weekly">Weekly</option>
                    <option <?php if($rotation_type == '2 Week'){echo 'selected';} ?> value="2 Week">2 Week</option>
                    <option <?php if($rotation_type == 'Monthly'){echo 'selected';} ?> value="Monthly">Monthly</option>
                  </select>
                  <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                  <input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
              </tr>
              <tr>
                <td class="text_1">Shift</td>
                <td align="left"><div id="div_shift_type_edit">
                    <div id="div_shift_type"></div>
                  </div></td>
                <!-- <td class="text_1"></td>-->
                <td align="center" valign="middle"><select name="shift_duration" id="shift_duration" style="width:150px; height:25px;">
                    <option <?php if($shift == 'A'){echo 'selected';} ?>  value="A">A</option>
                    <option <?php if($shift == 'B'){echo 'selected';} ?> value="B">B</option>
                    <option <?php if($shift == 'C'){echo 'selected';} ?> value="C">C</option>
                    <option <?php if($shift == 'D'){echo 'selected';} ?> value="G">G</option>
                  </select>
                  <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                  <input type="hidden" name="emp_id" id="emp_id" value="<?=$shift?>" />
                <td><!--   <a href="javascript:;" onclick="get_frm('change_shift.php','<?=$shift?>','div_shift_type_edit','<?//=$id?>')">Change</a>  --></td>
              </tr>
            </table></td>
          <td><table style="width:500px;margin-right:0px;" height="91px" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
              <tr>
                <td class="text_1" width="40%">Weekly OFF day</td>
                <td align="left" width="60%"><div id="div_weekly_off_edit">
                    <?=$off_day?>
                    <div id="div_weekly_off"></div>
                  </div></td>
                <td class="text_1"><!--  <a href="javascript:;" onclick="get_frm('change_weekly.php','<?//=$off_day?>','div_weekly_off_edit','<?//=$id?>')">Change</a>  -->
                  
                  <div id="change_weekly_off">
                    <table width="60%" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="center" valign="middle"><select name="off_days" id="off_days" style="width:150px; height:25px;">
                            <option <?php if($off_day == 'Sunday'){echo 'selected';} ?> value="Sunday">Sunday</option>
                            <option <?php if($off_day == 'Monday'){echo 'selected';} ?> value="Monday">Monday</option>
                            <option <?php if($off_day == 'Tuesday'){echo 'selected';} ?> value="Tuesday">Tuesday</option>
                            <option <?php if($off_day == 'Wednesday'){echo 'selected';} ?> value="Wednesday">Wednesday</option>
                            <option <?php if($off_day == 'Thursday'){echo 'selected';} ?> value="Thursday">Thursday</option>
                            <option <?php if($off_day == 'Friday'){echo 'selected';} ?> value="Friday">Friday</option>
                            <option <?php if($off_day == 'Saturday'){echo 'selected';} ?> value="Saturday">Saturday</option>
                          </select>
                          <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                          <input type="hidden" name="emp_id" id="emp_id" value="<?=$product_id?>" />
                       
                      </tr>
                    </table>
                  </div></td>
              </tr>
          
            </table></td>
        </tr>
      
      </table>
      
      <!--**************************************end*************************************************************--> 
      <!--*************************************Department Designation***************************************** --> 
      
      <!--****************************************end**********************************************************--> 
      <!--********************************Bank detailos******************************************************  -->
      
      <div id="div_insert_bank">
        <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
          <tr>
            <td colspan="2">Bank Detail</td>
          </tr>
          <tr>
            <td align="left" valign="top" width="50%"><table width="100%" height="67px" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                  <td class="text_1" width="60%">Mode of Payment</td>
                  <td align="left" width="40%"><select id="payment_mode" name="payment_mode">
                      <option <?php if($payment_mode == 'Cash'){echo 'selected';} ?> selected value="Cash">Cash</option>
                      <option <?php if($payment_mode == 'Cheque'){echo 'selected';} ?> value="Cheque">Cheque</option>
                      <option <?php if($payment_mode == 'Online'){echo 'selected';} ?> value="Online">Online</option>
                    </select></td>
                </tr>
              </table></td>
            <td width="50%"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                  <td class="text_1" width="40%">Bank Name</td>
                  <td align="left" width="60%"><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" id="bank_name" style="width:150px; height:20px;"/></td>
                </tr>
                <tr>
                  <td class="text_1" width="40%">Account Number</td>
                  <td align="left" width="60%"><input type="text" name="account_no" value="<?php echo $account_no; ?>" id="account_no" style="width:150px; height:20px;"/></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="4" align="center"><!--<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_insert_bank',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'<?//=$id?>')"/>--></td>
          </tr>
        </table>
      </div>
      
      <!--****************************************end**********************************************************-->
      
        <div align="center">
      <input type="submit"  value="Submit" name="emp_offical" id="#emp_offical"/>
      <? if(isset($_SESSION['emp_id'])){
								    ?>
      <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
      <?	
                                        							}
								 ?>
      <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
        </td>
    </tr>
  </table>
  </div>
</form>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
<script>
				   var jj = jQuery.noConflict();
                jj(document).ready(function(){
					var value_radio = jj('input[name=esic_applicable]:radio:checked').val();
	if(value_radio == 'applicable'){
		
		jj(".test").show();
		}
		else{
			jj(".test").hide();
			}

				jj("#notapplicable").click(function(){
					
                jj(".test").hide();
                 });
                jj("#applicable").click(function(){
                jj(".test").show();
                });
                });
                </script> 
