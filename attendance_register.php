<?php
include ("inc/hr_header.php");
?>
<style>
    select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Attendance Master-> </a>Attendance Register</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                            <tr>
                                <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Mark Attendance</td>
                            </tr>
                            <tr>
                                <td class="heading" valign="top" style="padding-top:5px;"><form id="frm_emp_list" name="frm_emp_list" method="GET" action="#">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                            <tr>
                                                <td width="100%" colspan="2" align="center">
                                                    <table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg" style="margin-bottom:20px;">
                                                        <tr>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance From Date<span class="red">*</span></td>
                                                            <td width="15%">
                                                                <input type="text" name="mon_txt_date" id="mon_txt_date" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']"  value="<?= $date ?>" data-beatpicker="true" style="width:100px; height:25px;" />  </td>
                                                            <td class="text_1" style="padding-left:15px;" width="12%">Attendance To Date<span class="red">*</span></td>
                                                            <td width="15%">
                                                                <input type="text" name="mon_txt_date1" id="mon_txt_date1" data-beatpicker-position="['right','*']" data-beatpicker-format="['DD','MM','YYYY']"  value="<?= $date ?>" style="width:100px; height:25px;" data-beatpicker="true" /></td>
                                                            <td width="7%" class="text_1" style="padding-right:15px; text-align:right;">Type <span class="red">*</span></td>
                                                            <td width="13%">
                                                                <select name="mon_employee_type" id="mon_employee_type" onChange="shift_check(this)" style="width:100px; height:25px;" onkeydown="if (event.keyCode && event.keyCode == 13) {

                                                                        }">

                                                                    <option value="">---Select---</option>
                                                                    <?php
                                                                    $que = mysql_query("select type_name from mpc_employee_type_master");

                                                                    while ($row = mysql_fetch_array($que)) {
                                                                        ?>

                                                                        <option value="<?php echo $row['type_name'] ?>" ><?php echo $row['type_name']; ?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>

                                                            <td width="25%" class="text_1" style="padding-right:15px; text-align:right;"> Emp Id<span class="red">*</span></td>
                                                            <td width="24%" align="left" style="padding-left:20px;">
                                                                <div id="div_txt_autocomplete">
                                                                    <input type="text" name="mon_employee_id" id="mon_employee_id" value="">
                                                                </div> 
                                                            </td>
                                                            <td>
                                                                <!--input type="submit" name="mon_submit" id="mon_submit" value="submit"-->
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div>
                                                        <p>
                                                            <a href="javascript:show_popup()" class="eventDetail impAtt" >
                                                                Import Attendance
                                                            </a>&nbsp;
                                                            <label class="btn" for="modal-1"> 
                                                                ?
                                                            </label>
                                                        </p>
                                                    </div>
                                                    <input class="modal-state" id="modal-1" type="checkbox" />
                                                    <div class="modal">
                                                        <label class="modal__bg" for="modal-1"></label>
                                                        <div class="modal__inner">
                                                            <label class="modal__close" for="modal-1"></label>
                                                            <center>
                                                                <h2>CSV File Formate</h2>
                                                                <table bordercolordark="#000000" border="5px">
                                                                    <tr>
                                                                        <td>id</td><td>110</td></tr>
                                                                    <tr><td>EmpId</td><td>2015105</td></tr>
                                                                    <tr><td>Name</td><td>MR. Been</td></tr>
                                                                    <tr><td>1</td><td>P</td></tr>
                                                                    <tr><td>2</td><td>A</td></tr>
                                                                    <tr><td>3</td><td>CL</td></tr>
                                                                    <tr><td>:</td><td>ML,LWP,HD,L etc</td></tr>
                                                                    <tr><td>:</td><td>LC</td></tr>
                                                                    <tr><td>31</td><td>P</td></tr>
                                                                    <tr><td>Date</td><td>DD-MM-YY</td></tr>
                                                                </table>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <!-- End herer-->
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
                                        <div id="vpb_pop_up_background"></div>
                                        <div id="vpb_signup_pop_up_box">
                                            <p>
                                                <a href="javascript:hide_popup()" style="float:right;">
                                                    close
                                                </a>
                                            </p>
                                            <div id="form">
                                                <?php
//Upload File
                                                if (isset($_POST['submit'])) {
                                                    $file_name = $_FILES['filename']['tmp_name'];
                                                    if (empty($file_name)) {
                                                        echo "PLz Select file";
                                                        ?><script>
                                                                    alert("PLz Select file");
                                                        </script>
                                                        <?
                                                        return false;
                                                    }
                                                    $type = explode(".", $_FILES['filename']['tmp_name']);
                                                    if (strtolower(end($type)) != 'csv') {
                                                        echo "Plz enter csv file";
                                                        return false;
                                                    } else {
                                                        $handle = fopen($_FILES['filename']['tmp_name'], "r");
                                                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                            if (!empty($data[34])) {
                                                                $date = getdbDate($data[34]);
                                                                $date = str_replace("/", "-", $date);
                                                                $date = explode("-", $date);
                                                                $year = $date[0];
                                                                $month = $date[1];
                                                            }

                                                            $sql1 = "SELECT `emp_id` FROM `mpc_employee_master` WHERE `ticket_no` = $data[1]";
                                                            $result = mysql_query($sql1) or die(mysql_error());
                                                            if (mysql_num_rows($result) > 0) {
                                                                $row = mysql_fetch_array($result);
                                                                $empid = $row[0];

                                                                $j = 1;
                                                                for ($c = 3; $c < 34; $c++) {
                                                                    $status = $data[$c];
                                                                    $date = $year . '-' . $month . '-' . $j;
                                                                    $j++;
                                                                    if (!empty($status) and $empid != '0' and $empid != NULL) {
                                                                        $import = "INSERT into mpc_attendence_master(rec_id,emp_id,attendance_status,date) values('','$empid','$status','$date')";
                                                                        $i++;
                                                                        mysql_query($import) or die(mysql_error());
                                                                    }
                                                                }
                                                            }
                                                        }

                                                        fclose($handle);

                                                        print "Import done";

                                                        //view upload form
                                                    }
                                                } else {

                                                    print "Upload new csv by browsing to file and clicking on Upload<br />\n";

                                                    print "<form enctype='multipart/form-data' action='' method='post'>";

                                                    print "File name to import:<br />\n";

                                                    print "<input size='50' type='file' name='filename'><br />\n";

                                                    print "<input type='submit' name='upload_submit' value='Upload'></form>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        <?php
        include ("inc/hr_footer.php");
        ?>	
