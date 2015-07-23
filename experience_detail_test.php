<script type="text/javascript">
 var _validFileExtensions = [".pdf", ".docs", ".docx"];    
function Validate_file(oForm) { 
var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        if (arrInputs[i].type == "file") {
            var sFileName = arrInputs[i].value;
            var get_size = document.getElementById('file').files[0].size;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase() && get_size < 500000) {
                         blnValid = true;
                        break;
                    }
                }
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", ")+" and Size must be less than 450kb");
                    return false;
                }
            }
        }
    }  
    return true;
}
</script>
<?php
/*if (isset($_POST['emp_experience_pre'])) {
    $pre_employee_id = $_POST['employee_id'];
    $pre_employer_name = $_POST['pre_employer_name'];
    $pre_employer_designation = $_POST['pre_employer_designation'];
    $Industry = $_POST['Industry'];
    $experince_from = $_POST['experince_from'];
    $experince_to = $_POST['experince_to'];
    $relevent = $_POST['relevent'];
    $salary = $_POST['salary'];
	$file_name = $_FILES["file"]["name"];
    echo $_SESSION['emp_experience_pre'] = $_SESSION['emp_id'];
    echo  $mode = 'experience_detail';
    
    if($file_name!='')
	{
		$file_arr = explode('.',$file_name);
		$file_ext = strtolower($file_arr[sizeof($file_arr) - 1]);
		if (($file_ext == 'pdf' || $file_ext == 'doc' || $file_ext == 'docx') && $_FILES["file"]["size"] < 500000)
        {
			$filename = str_replace(" ","_", $file_name);
			$time = time();
			$file = $time . "_" . $file_name;
			$up_file = "upload/".$file;
			move_uploaded_file($_FILES['file']['tmp_name'],$up_file);  
			if ($emp_experience_edit == "") {
            // current job
			$que = mysql_query("insert into mpc_experience_master values('','$pre_employee_id',
			'$pre_employer_name','$pre_employer_designation',
			'$Industry','$experince_from',
			'$experince_to','$relevent',
			'$salary','$file')");
			}else {
				$query = mysql_query("update mpc_experience_master set employer_name='$pre_employer_name',
				employer_designation='$pre_employer_designation',
				Industry='$Industry',experince_from='$experince_from',
				experince_to='$experince_to',relevent='$relevent',salary='$salary',
				file='$file' where emp_id='$pre_employee_id'");
			}
		}
        else
        {
		   echo "error in uploading  file";
           // While file is wrong then data is insert into database.
           if ($emp_experience_edit == "") {
            // current job
            $que = mysql_query("insert into mpc_experience_master values('','$pre_employee_id',
            '$pre_employer_name','$pre_employer_designation',
            '$Industry','$experince_from',
            '$experince_to','$relevent',
            '$salary')");
            }else {
                $query = mysql_query("update mpc_experience_master set employer_name='$pre_employer_name',
                employer_designation='$pre_employer_designation',
                Industry='$Industry',experince_from='$experince_from',
                experince_to='$experince_to',relevent='$relevent',salary='$salary'
                where emp_id='$pre_employee_id'");
            }
        }
	}
    else
    {
        if ($emp_experience_edit == "") {
            // current job
            $que = mysql_query("insert into mpc_experience_master values('','$pre_employee_id',
            '$pre_employer_name','$pre_employer_designation',
            '$Industry','$experince_from',
            '$experince_to','$relevent',
            '$salary')");
            }else {
                $query = mysql_query("update mpc_experience_master set employer_name='$pre_employer_name',
                employer_designation='$pre_employer_designation',
                Industry='$Industry',experince_from='$experince_from',
                experince_to='$experince_to',relevent='$relevent',salary='$salary'
                where emp_id='$pre_employee_id'");
            }
    }
}
*/?>
<style>
    .border {
        border: 1px solid #e4e4e4;
        margin-top: -6px;
        width: 100%;
    }
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table class="border">
    <tr>
        <td>
            <div <?
            if ($mode == 'education_detail') {
                echo 'class="current"';
            } else {
                echo 'class="simpleTabsContent"';
            }
            ?>>
                <div style=" padding-left:15px; padding-top:10px;">Last Association</div>

                <form name="experience_detail" id="experience_detail" action="<?php
                if ($p == 'User_details.php') {
                    echo 'User_details.php?mode=salary_details';
                } else {
                    echo 'employee_detail.php?mode=experience_detail';
                }
                ?>" enctype="multipart/form-data" method="post" onsubmit ="return Validate_file(this);"><!--onSubmit="return valid_customer(this);"-->
                    <div class="border" style="width:97%; margin:10px auto;">
                        <?php $emp_id = $_SESSION['emp_id']; ?>
                        <table cellpadding="5" cellspacing="4">
                            <tr style="display:none;">
                                <td width="265" class="text_1">Employee Id</td>
                                <td width="335"><input type="readonly" name="employee_id" id="employee_id" value="<?= $emp_id ?>"/></td>
                            </tr>
                            <tr>
                                <td width="265" class="text_1">Previous Employer</td>
                                <td width="335"><input type="text" name="pre_employer_name" id="pre_employer_name" value="<?= $pre_employer_name ?>"/></td>
                            </tr>
                            <tr>
                                <td width="265" class="text_1">Designation</td>
                                <td width="335"><input type="text" name="pre_employer_designation" id="pre_employer_designation" value="<?= $pre_employer_designation ?>"/></td>
                            </tr>
                            <tr>
                                <td width="265" class="text_1">Industry</td>
                                <td width="335"><select class="reg_text2 cls_industry_sts cls_multi_tooltip" id="id_Industry" name="Industry">
                                        <option value="" selected="selected">- Select Industry -</option>
                                        <optgroup label="-- Top Industries -- ">
                                            <option value="IT - Software"<?
                                            if ($Industry == 'IT - Software') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>IT - Software</option>
                                            <option value="Banking / Financial Services"<?
                                            if ($Industry == 'Banking / Financial Services') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Banking / Financial Services</option>
                                            <option value="Manufacturing"<?
                                            if ($Industry == 'Manufacturing') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Manufacturing</option>
                                            <option value="Engineering / Construction"<?
                                            if ($Industry == 'Engineering / Construction') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Engineering / Construction</option>
                                            <option value="Education / Training"<?
                                            if ($Industry == 'Education / Training') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Education / Training</option>
                                            <option value="BPO / Call Center"<?
                                            if ($Industry == 'BPO / Call Center') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>BPO / Call Center</option>
                                            <option value="IT - Hardware / Networking"<?
                                            if ($Industry == 'IT - Hardware / Networking') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>IT - Hardware / Networking</option>
                                            <option value="Automobile / Auto Ancillaries"<?
                                            if ($Industry_pre == 'Automobile / Auto Ancillaries') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Automobile / Auto Ancillaries</option>
                                            <option value="Telecom / ISP"<?
                                            if ($industry == 'Telecom / ISP') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Telecom / ISP</option>
                                            <option value="Medical / Healthcare"<?
                                            if ($Industry == 'Medical / Healthcare') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Medical / Healthcare</option>
                                        </optgroup>
                                        <optgroup label="-- Other Industries -- ">
                                            <option value="Advertising / MR / PR / Events"<?
                                            if ($Industry == 'Advertising / MR / PR / Events') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Advertising / MR / PR / Events</option>
                                            <option value="Agriculture / Dairy"<?
                                            if ($Industry == 'Agriculture / Dairy') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Agriculture / Dairy</option>
                                            <option value="Architecture / Interior Design"<?
                                            if ($Industry == 'Architecture / Interior Design') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Architecture / Interior Design</option>
                                            <option value="Astrology"<?
                                            if ($industry == 'Astrology') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Astrology</option>
                                            <option value="Aviation / Airline"<?
                                            if ($Industry == 'Aviation / Airline') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Aviation / Airline</option>
                                            <option value="Cement / Building Material"<?
                                            if ($Industry == 'Cement / Building Material') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Cement / Building Material</option>
                                            <option value="Chemical / Plastic / Rubber / Glass"<?
                                            if ($Industry == 'Chemical / Plastic / Rubber / Glass') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Chemical / Plastic / Rubber / Glass</option>
                                            <option value="Consumer Durables / Electronics"<?
                                            if ($Industry == 'Consumer Durables / Electronics') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Consumer Durables / Electronics</option>
                                            <option value="Travel / Tourism"<?
                                            if ($industry == 'Travel / Tourism') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Travel / Tourism</option>
                                            <option value="Unskilled Labor / Domestic Help"<?
                                            if ($Industry == 'Unskilled Labor / Domestic Help') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Unskilled Labor / Domestic Help</option>
                                            <option value="Veterinary Science / Pet Care"<?
                                            if ($Industry == 'Veterinary Science / Pet Care') {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Veterinary Science / Pet Care</option>
                                        </optgroup>
                                    </select></td>
                            </tr>
                            <tr><td>Total Experience</td></tr>
                            <tr>
                                <td class="text_1">Experience From</td>
                                <td align="left"><input type="text" name="experince_from" id="experince_from" style="width:150px; height:20px;" value="<?= $experience_from ?>" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']" />

                                </td>
                            </tr>
                            <tr>
                                <td class="text_1">Experience To</td>
                                <td align="left"><input type="text" name="experince_to" id="experince_to" style="width:150px; height:20px;" value="<?= $experience_to ?>" data-beatpicker="true" data-beatpicker-format="['DD','MM','YYYY']" />

                                </td>
                            </tr>
                            <tr><td class="text_1">Relevant Experience</td><td><input type="text" name="relevent" id="relevent" value="<?= $relevent ?>"/></td>
                            </tr>

                            <tr><td class="text_1">Last Salary</td><td><input type="text" name="salary" id="salary" value="<?= $salary ?>"/></td>
                            </tr>
                            <tr>

                                <td class="text_1">Upload Resume(in pdf)</td><td><input type="file" name="file" id="file"></td>
                                <?php if ($file != "") {
                                    ?>

                                    <td><a href="upload/<?php echo $file; ?>" class="btn_bg">View</a></td>

                                <?php } ?></tr>

                        </table>

                        <?php /* ?><div align="center">
                          <input type="submit"  value="Submit" name="emp_experience" id="emp_experience"/>
                          <? if(isset($_SESSION['emp_id'])){

                          ?>
                          <input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?=$ticket_no?>';"/>
                          <?
                          }
                          ?>
                          <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                          </div><?php */ ?>
                    </div>

                    <div align="center">
                        <input type="submit"  value="Next" name="emp_experience_pre" id="emp_experience_pre"/>
                        <? if (isset($_SESSION['emp_id'])) {
                            ?>
                                                <!--<input type="button"  value="Done" name="Submit_emp2" id="Submit_emp2" onClick="document.location='list_employee.php?ticket_no=<?= $ticket_no ?>';"/>-->
                        <? } ?>
                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                    </div>
                </form>

            </div>
        </td>
    </tr>
</table>

<br />
</div>
