<!-- date picker -->
<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<!-- end -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">

<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>

<table>
  <tr>
    <td valign="top"><table width="100%" cellpadding="2" cellspacing="2" class="border" border="0" height="707px">
        <tr>
          <td class="text_1">First Name<span class="red">*</span></td>
          <td align="left" style="padding-top:5px;"><input type="text" name="first_name" id="first_name" style="width:150px; height:20px;" value="<?=$first_name?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Last Name<span class="red">*</span></td>
          <td align="left" style="padding-top:5px;"><input type="text" name="last_name" id="last_name" style="width:150px; height:20px;" value="<?=$last_name?>"/></td>
        </tr>
        <!--<tr>
          <td class="text_1">Father's/Husband's Name</td>
          <td align="left" style="padding-top:5px;"><input type="text" name="father_husband_name" id="father_husband_name" style="width:150px; height:20px;" value="<?=$father_husband_name?>"/></td>
        </tr>-->
        <tr>
          <td class="text_1" valign="top">Address(permanent)</td>
          <td align="left" style="padding-top:5px;"><textarea name="address" id="address" rows="4" cols="32" style="height:105px;"><?=$address?>
</textarea></td>
        </tr>
        <tr>
          <td class="text_1" valign="top">Correspondance</td>
          <td align="left" style="padding-top:5px;"><textarea name="correspondance" id="correspondance" rows="4" cols="32" style="height:105px;"><?=$correspondance?>
</textarea></td>
        </tr>
        <tr>
          <td class="text_1">Country</td>
          <td align="left"><?
                                            $sql = "SELECT * FROM mpc_countries order by countries_name";
                                            $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                            ?>
            <select name="country" id="country" onChange="get_frm1('get_state.php',this.value,'div_add_state','state');" style="width:200px;">
              <option value="">-select country-</option>
              <? 
                                            
                                            while ($row=mysql_fetch_array($result))
                                            {	?>
              <option value="<?=$row['countries_id']?>" <? if($row['countries_id']==$country){?> selected="selected" <? } ?>>
              <?=$row["countries_name"]?>
              </option>
              <?  }	?>
            </select></td>
        </tr>
        <tr>
          <td class="text_1">State</td>
          <td align="left"><div id="div_add_state">
              <?
											if($other_state=="")
											{
											 $sql = "SELECT * FROM mpc_state_master where country_id = '99' order by state_name";
                                            $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                            ?>
              <select name="state" id="state" onChange="get_frm('get_city_reg.php',this.value,'div_city','city_select');" style="width:200px;">
                <option value="">-select state-</option>
                <? 
                                            while ($row=mysql_fetch_array($result))
                                            {
                                            ?>
                <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$state){?> selected="selected" <? } ?>>
                <?=$row["state_name"]?>
                </option>
                <?
                                            }
                                            ?>
              </select>
              <?
												}
												else
												{
											?>
              <input type="text" name="txt_other_state" id="txt_other_state" value="<?=$other_state?>">
              <?
												}
											?>
            </div></td>
        </tr>
        <tr>
          <td class="text_1">City</td>
          <td align="left"><div id="div_city">
              <?
											if($other_city=="")
											{
                                            $sql = "SELECT * FROM  ".$mysql_table_prefix."city_master order by city_name ";
$result_city = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
											?>
              <select name="city_select" id="city_select" style="width:200px;">
                <option value="">-select city-</option>
                <? 
                                            while ($row=mysql_fetch_array($result_city))
                                            {
                                            ?>
                <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$city){?> selected="selected" <? } ?>>
                <?=$row["city_name"]?>
                </option>
                <?
                                            }
                                            ?>
              </select>
              <?
												}
												else
												{
											?>
              <input type="text" name="other_city" id="other_city" value="<?=$other_city?>">
              <?   
												}
											?>
            </div></td>
        </tr>
        <tr>
          <td class="text_1">Pin Code</td>
          <td align="left"><input type="text" name="pin_code" id="pin_code" style="width:150px; height:20px;" value="<?=$pincode?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Date Of Birth</td>
          <td align="left">
          <input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>" data-beatpicker="true"/>
            </td>
        </tr>
        <tr>
          <td class="text_1">Place Of Birth</td>
          <td align="left"><input type="text" name="pob" id="pob" style="width:150px; height:20px;"value="<?= $pob?>"/></td>
        </tr>
      </table></td>
    <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
        <tr>
          <td width="43%" class="text_1">Gender</td>
          <td width="57%" align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="gender" name="gender" value="Male" <? if($gender=='male') {?>checked="checked"<? }?>/>
            Male
            <input type="radio" id="gender" name="gender" value="Female"<? if($gender=='female'){ ?>checked="checked"<? }?>/>
            Female </td>
        </tr>
        <tr>
          <td class="text_1">Eye Vision</td>
          <td align="left"><input type="text" name="eye" id="eye" style="width:150px; height:20px;"value="<?= $eye?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Major Illnes</td>
          <td align="left"><input type="text" name="illness" id="illness" style="width:150px; height:20px;"value="<?= $illness?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Height</td>
          <td align="left" width="202px">Foot
            <input type="text" name="height" id="height" style="width:60px; height:20px;" value="<?= $height?>"/>
            &nbsp;Inch
            <input type="text" name="height_inch"  style="width:60px; height:20px;" value="<?=$height_inch?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Weight</td>
          <td align="left"><input type="text" name="weight" id="weight" style="width:150px; height:20px;"value="<?= $weight?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Phone(Tel.)</td>
          <td align="left"><input type="text" name="phone_no" id="phone_no" style="width:150px; height:20px;" value="<?=$phone_no?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Phone(Mob.)</td>
          <td align="left"><input type="text" name="mobile_no" id="mobile_no" style="width:150px; height:20px;" value="<?=$mobile_no?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Emergancy Contact No.</td>
          <td align="left"><input type="text" name="emergancy_contact" id="emergancy_contact" style="width:150px; height:20px;" value="<?=$emergancy_contact?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Email Id</td>
          <td align="left"><input type="email" name="email_id" id="email_id" style="width:150px; height:20px;" value="<?=$email_id?>" required="required"/></td>
        </tr>
        <tr>
          <td class="text_1">Marital Status</td>
          <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="hide" name="marital" value="yes" onClick="marriage_date(this)" <? if($marital_status =='yes'){ ?>checked="checked"<? }?>/>
            Married
            <input type="radio" id="show" name="marital" value="no" onClick="marriage_date(this)" <? if($marital_status =='no'){ ?>checked="checked"<? }?>/>
            Single </td>
        </tr>
        <tr id="ss">
          <td class="text_1">if Married then date of Marriage</td>
          <td align="left"><input type="text" name="marr_date" id="marr_date" disabled="disabled" style="width:150px; height:20px;" value="<?=$marriage_date?>"/>
            <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.marr_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
        </tr>
        <tr>
          <td class="text_1">Blood Group</td>
          <td align="left"><select name="blood_group" id="blood_group">
              <option value="">-Select-</option>
              <option value="O-" <? if($blood_group=='O-'){echo 'selected="selected"';}?> >O-</option>
              <option value="O+" <? if($blood_group=='O+'){echo 'selected="selected"';}?>>O+</option>
              <option value="A-" <? if($blood_group=='A-'){echo 'selected="selected"';}?>>A-</option>
              <option value="A+" <? if($blood_group=='A+'){echo 'selected="selected"';}?>>A+</option>
              <option value="B-" <? if($blood_group=='B-'){echo 'selected="selected"';}?>>B-</option>
              <option value="B+" <? if($blood_group=='B+'){echo 'selected="selected"';}?>>B+</option>
              <option value="AB-" <? if($blood_group=='AB-'){echo 'selected="selected"';}?>>AB-</option>
              <option value="AB+"  <? if($blood_group=='AB+'){echo 'selected="selected"';}?>>AB+</option>
            </select></td>
        </tr>
        <tr>
          <td class="text_1">Cast</td>
          <td align="left"><input type="text" name="cast" id="cast" style="width:150px; height:20px;" value="<?=$cast?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Category</td>
          <td align="left"><select name="category" style="width:100px;">
              <option value="">-select-</option>
              <option value="Gen"<? if($category=='Gen'){echo 'selected="selected"';}?>>GEN</option>
              <option value="Obc"<? if($category=='Obc'){echo 'selected="selected"';}?>>OBC</option>
              <option value="St"<? if($category=='St'){echo 'selected="selected"';}?>>ST</option>
              <option value="Sc"<? if($category=='Sc'){echo 'selected="selected"';}?>>SC</option>
              <option value="Other"<? if($category=='Other'){echo 'selected="selected"';}?>>OTHER</option>
            </select></td>
        </tr>
        <tr>
          <td class="text_1">Religion</td>
          <td align="left"><input type="text" name="religion" id="religion" style="width:150px; height:20px;" value="<?=$religion?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Nationality</td>
          <td align="left"><input type="text" name="nationality" id="nationality" style="width:150px; height:20px;" value="<?=$nationality?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Reference</td>
          <td align="left"><input type="text" name="reference" id="reference" style="width:150px; height:20px;" value="<?=$reference?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Reference Contact</td>
          <td align="left"><input type="text" name="reference_contact" id="reference_contact" style="width:150px; height:20px;" value="<?=$reference_contact?>"/></td>
        </tr>
        <tr>
          <td class="text_1">Hobbies</td>
          <td align="left"><textarea name="hobby"><?=$hobby?>
</textarea></td>
        </tr>
        <tr>
          <td class="text_1">Habits(Good & Bed)</td>
          <td align="left"><textarea name="habit"><?=$habit?>
</textarea></td>
        </tr>
        <tr>
          <td class="text_1">Employee picture</td>
          <td align="left"><input type="file" name="emp_pic" id="emp_pic" style="width:210px; height:26px;"/></td>
          <?php $img_path = "http://".$_SERVER['HTTP_HOST']."employee_picture/thumb/".$employee_picture ; ?>
          <?php if(!empty($employee_picture)){ ?>
          <td><img src="<?php echo "http://solutionsofts.com/mah_database/"?>employee_picture/thumb/<?php echo $employee_picture ; ?>"></td>
          <?php } ?>
        </tr>
      </table></td>
  </tr>
</table>