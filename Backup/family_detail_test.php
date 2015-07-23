<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<!--<script>
$(function() {
    $( "#father_dob" ).datepicker();
	$("#mother_dob").datepicker();
	$("#mother_dob").datepicker();
  });
  </script>  -->
<script>
  $(function() {
    //$( "#dob" ).datepicker();
		$('.footer').hide();
  });
</script>



<div <? if($mode=='personal_detail'){ echo 'class="current"';}else{echo 'class="simpleTabsContent"';} ?>>
      
      <form name="empolyee_family" id="empolyee_family" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px">
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1" width="35%">Father Name(Mr.)<span class="red">*</span></td>
                  <td align="left" width="65%"><input type="text" name="father_name" id="father_name" style="width:150px; height:20px;" value="<?=$father_name?>" required /></td>
                </tr>
                <tr>
                  <td class="text_1">Depended</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes" <? if($Dependant_father=='Yes'){ ?>checked="checked"<? }?>/>
                    Yes
                    <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No" <? if($Dependant_father=='No'){ ?>checked="checked"<? }?>/>
                    No </td>
                </tr>
                <tr>
                  <td class="text_1">Mother Name(Mrs.) <span class="red">*</span></td>
                  <td align="left"><input type="text" name="mother_name" id="mother_name" style="width:150px; height:20px;" value="<?=$mother_name?>" required /></td>
                </tr>
                <tr>
                  <td class="text_1">Depended</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"<? if($Dependant_mother=='Yes'){ ?>checked="checked"<? }?>/>
                    Yes
                    <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"<? if($Dependant_mother=='No'){ ?>checked="checked"<? }?>/>
                    No </td>
                </tr>
                <?php 

				if($_SESSION['marital_sta'] === 'yes'){ ?>
                <tr>
                  <td class="text_1">Spouse Name </td>
                  <td align="left"><input type="text" name="wife_name" id="wife_name" style="width:150px; height:20px;" value="<?=$wife_name?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Depended</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member3" name="Dependant_member3" value="Yes"<? if($Dependant_wife =='Yes'){ ?>checked="checked"<? }?>/>
                    Yes
                    <input type="radio" id="Dependant_member3" name="Dependant_member3" value="No"<? if($Dependant_wife =='No'){ ?>checked="checked"<? }?>/>
                    No </td>
                </tr>
                <?php } ?>
                <?php //if($_SESSION['marital_sta'] === 'yes'){ ?>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1" width="35%">Father's DOB</td>
                  <td align="left" width="65%"><input type="text" name="father_dob" id="father_dob" style="width:150px; height:20px;" value="<?=$father_dob?>" data-beatpicker="true"/>
                    </td>
                </tr>
                <tr>
                  <td class="text_1">Father Qualification</td>
                  <td align="left"><input type="text" name="father_qualification" id="father_qualification" style="width:150px; height:20px;" value="<?=$father_qualification?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Occupation</td>
                  <td align="left"><input type="text" name="father_occupation" id="father_occupation" style="width:150px; height:20px;" value="<?=$father_occupation?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Mother's DOB</td>
                  <td align="left"><input type="text" name="mother_dob" id="mother_dob" style="width:150px; height:20px;" value="<?=$mother_dob?>" data-beatpicker="true"/>
                    </td>
                </tr>
                <tr>
                  <td class="text_1">Mother Qualification</td>
                  <td align="left"><input type="text" name="mother_qualification" id="mother_qualification" style="width:150px; height:20px;" value="<?=$mother_qualification?>"/></td>
                </tr>
                <tr>
                  <td class="text_1">Occupation</td>
                  <td align="left"><input type="text" name="mother_occupation" id="mother_occupation" style="width:150px; height:20px;" value="<?=$mother_occupation?>"/></td>
                </tr>
                <?php   if($_SESSION['marital_sta'] === 'yes'){ ?>
                <tr>
                  <td class="text_1">Date of Birth </td>
                  <td align="left"><input type="text" name="wife_dob" id="wife_dob" style="width:150px; height:20px;" value="<?=$wife_dob?>" data-beatpicker="true"/>
                    </td>
                </tr>
                <tr>
                  <td class="text_1">Spouse Qualification</td>
                  <td align="left"><input type="text" name="wife_qualification" id="wife_qualification" style="width:150px; height:20px;" value="<?=$wife_qualification?>"/></td>
                </tr>
               <td class="text_1">Occupation</td>
                  <td align="left"><input type="text" name="wife_occupation" id="wife_occupation" style="width:150px; height:20px;" value="<?=$wife_occupation?>"/></td>
                </tr>
                <?php } ?>
              </table></td>
          </tr>
          <?php   //if($_SESSION['marital_sta'] === 'yes'){ ?>
          
          <!------------------- Child Information------------------------->
          <!--<tr>
            <td align="left" width="10px">Childrens information</td>
          </tr>
          <tr>
              <td align="left" colspan="3" style="padding-top:3px;">
            <table align="left" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
              <tr class="text_1" bgcolor="#EAE3E1">
                <td width="24%"><b>child Name</b></td>
                <td width="24%"><b>Gender</b></td>
                <td width="24%"><b>Dependent</b></td>
                <td width="24%"><b>Date of Birth</b></td>
                <td width="4%"></td>
              </tr>
              <tr>
                <td align="left"><input name="child_name[]" id="child_name[]" type="text" value="" style="width:180px; height:20px;"/></td>
                <td align="left"> male
                  <input name="child_gender0[]" id="child_gender[]" type="radio" value="male" />
                  female
                  <input name="child_gender0[]" id="gen[]" type="radio" value="female" /></td>
                </td>
              
              
                <td align="left"> yes
                  <input name="child_dependent0[]" id="child_dependent[]" type="radio" value="yes" />
                  no
                  <input name="child_dependent0[]" id="child_dependent[]" type="radio" value="no" /></td>
                <td align="left"><input name="child_dob[]" id="child_dob[]" type="text" value="" style="width:150px; height:20px;"/></td>
                <td class="AddMore" style="padding-right:10px;"><input type="hidden" name="h_hidden" id="h_hidden"/>
                  <a href="javascript:;"  onclick="addElements();"><img src="images/add_icon.jpg" border="0"/></a></td>
              </tr>
          -->    <?php //} ?>
              <tr>
                <td style="text-align:center;" colspan="4">
                <input type="submit"  value="Submit" name="emp_family" id="emp_family"/>
              <? if(isset($_SESSION['emp_id'])){
								    ?>
              <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/></td></tr>
             
              
            </table>
            </div>
          
            </td>
          <?php }?>
          
          <!-------------------Child Information Ends Here ------------------------------------>
          <tr>
            <td colspan="2" style="text-align:center;"><div id="myDiv1"></div></td>
          </tr>
          <tr>
         
          
            <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
              </td>
          </tr>
        </table>
      </form>
    </div>
     <script>
function addElements() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td align='left' style='width:256px;'><input name='child_name[]' type='text' value='' style='width:180px;height:20px;' /></td><td align='left' style='width:251px;'>male<input name='child_gender"+num+"[] 'id='child_gender' type='radio' value='male' />female<input name='child_gender"+num+"[]' id='child_gender' type='radio' value='female' /></td><td align='left' style='width: 253px;'>yes<input name='child_dependent"+num+"[]' id='child_dependent' type='radio' value='yes' />no<input name='child_dependent"+num+"[]' type='radio' value='no' /></td><td align='left' style='width:246px;'><input name='child_dob[]' id='chil_dob' type='text' value='' style='width:150px;height:20px;'/></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElements(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
 ni.appendChild(newdiv);
}
</script> 

              
           