<?php
include ("inc/hr_header.php");
?>
<div style="float:left;margin-left: 10px;">
    <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
            <td align="left" valign="top" width="230px" style="padding-top:5px;"><? include ("inc/snb.php"); ?></td>
        </tr>
    </table>
</div>
<div style="float:left;margin-left: 15px;width: 78.2%;padding-top:5px">
    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
        <tbody>
            <tr>
                <td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Employee master-> </a>import employee detail</td>
            </tr>
        </tbody>
    </table>
</div>

<div style="float:left;background-color:#F9F9F9;margin: 10px 0 0 15px;width:30%;">

    <form style="padding:0px;margin:0px;" enctype='multipart/form-data' action='' method='post'>

        <div style="height:9%;border-top: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;padding-top: 1%;padding-left: 3%;text-align: center;"> <p>Add Employee By CSV File</p> </div>
        <div style="height:9%;border-bottom: 1px solid #d5d5d5;padding-top: 3%;padding-left: 3%;"> <span style="margin-right: 5%;">Select file: </span> <input size='50' type='file' name='filename' id="filename"></div>
        <div style="height:9%;border-bottom: 1px solid #d5d5d5;padding-top: 3%;padding-right: 10%;padding-left: 3%;text-align: right;"><input type='submit' name='submit' id='submit' value='Upload'></div>
    </form>
</div>
<div id="form">
    <?php
//Upload File
    if (isset($_POST['submit'])) {

        /* ________ Check Uploded File is Present or not___________ */
        if (!file_exists($_FILES['filename']['tmp_name']) || !is_uploaded_file($_FILES['filename']['tmp_name'])) {
            echo 'No upload';
            return FALSE;
        }
        /* ________End Check Uploded File is Present or not___________ */




        /* ________ Check Uplode Files number of rows____________ */

        $fp = file($_FILES['filename']['tmp_name']);
        $lines = count($fp);
        if ($lines <= 1) {
            echo "Please Check The File,It contant only headers.";
            return FALSE;
        } else {
            $handle = fopen($_FILES['filename']['tmp_name'], "r");
            $i = 1;
        }
        /*      $k = 0;
          while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {

          if ($data[0] == "Sr. No." && $data[1] == "Employee code" && $data[2] == "Name Of Employee's" &&
          $data[3] == "Father's Name" && $data[4] == "Sex" && $data[5] == "Date Of Joining" &&
          $data[6] == "Department" && $data[7] == "Designation" && $data[8] == "Date Of Birth(M(MM/DD/YY)" &&
          $data[9] == "Mobile No" && $data[10] == "Blood Group" && $data[11] == "Category" && $data[12] == "Employee Grade" &&
          $data[13] == "Marital Status") {

          }

          if ($data[0] != "Sr. No." && $data[1] != "Employee code" && $data[2] != "Name Of Employee's") {
          $sDes = "Select * From ";
          $sql_insert_personal = "insert into " . $mysql_table_prefix . "employee_master  set ticket_no = '$data[1]',
          emp_id = '$emp_login',first_name='$data[2]',dob='$data[8]',father_husband_name='$data[3]',
          address='$data[21]',correspondance='$data[22]',phone_no='$data[9]',marital_status='$data[13]',
          designation='$designationId',Date_joining='$Doj'";



          $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());
          $emp_rec_id = mysql_insert_id();
          $sql_insert = "update " . $mysql_table_prefix . "employee_master set
          emp_id = '$emp_rec_id'
          where rec_id = '$emp_rec_id'";
          $result_insert = mysql_query($sql_insert) or die("Error in query:" . $sql_insert . "<br>" . mysql_error() . "<br>" . mysql_errno());


          $sql_insert_femaily = "insert into " . $mysql_table_prefix . "family_master set
          emp_id = '$emp_rec_id',
          father_name='$data[11]',
          father_dob='$fdob',
          mother_name='$data[31]',
          mother_dob='$mdob',
          wife_name='$data[36]',
          wife_dob='$wdob'";

          $result_insert_femily = mysql_query($sql_insert_femaily) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());

          $sql_insert_official = "insert into " . $mysql_table_prefix . "official_detail set
          emp_id = $emp_rec_id,
          date_joining='$Doj'";

          $result_insert_official = mysql_query($sql_insert_official) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());
          }
          }
          die;
         */
        /* ________End Of Check Uplode Files number of rows____________ */
        $i = 0;
        while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
            echo count($data);
            echo "<pre>";

            var_dump($data);

            $i++;
            if ($data[0] == "Sr.no" and $data[1] == "PF NO" and $data[4] == "ESIC NO") {
//                echo 'yes';
//                die;
            } else {

                $year = date("Y");
                $sql = "SELECT ticket_no FROM " . $mysql_table_prefix . "employee_master ORDER BY rec_id DESC LIMIT 1";
                $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());

                $row = mysql_fetch_row($result);

                if ($row == "") {

                    $emp_login = $year . '101';
                } else {
                    $emp_login = substr($row[0], 4);
                    $emp_login++;
                }
                $DoB = $data[7] . "/" . $data[6] . "/" . $data[5];
                $fdob = $data[15] . "/" . $data[14] . "/" . $data[13];
                $mdob = $data[34] . "/" . $data[33] . "/" . $data[32];
                $wdob = $data[39] . "/" . $data[38] . "/" . $data[37];
                $pf_no = $data[1] . $data[2];
                $username = "$data[4]" . rand();
                $password = rand();
                $Doj = $data[10] . "/" . $data[9] . "/" . $data[8];
                $sql = "SELECT ticket_no FROM " . $mysql_table_prefix . "employee_master ORDER BY rec_id DESC LIMIT 1";
                $result = mysql_query($sql) or die("Error in : " . $sql . "<br>" . mysql_errno() . " : " . mysql_error());
                $que = "select rec_id FROM " . $mysql_table_prefix . "designation_master where designation_name='$data[16]'";
                $results = mysql_query($que) or die("Error in : " . $que . "<br>" . mysql_errno() . " : " . mysql_error());
                $rows = mysql_fetch_array($results);
                $designationId = $rows[0];
                $sql_insert_personal = "insert into " . $mysql_table_prefix . "employee_master  set 
																				ticket_no = '$emp_login',
																				emp_id = '$emp_login',
         																		first_name='$data[4]',
																				dob='$DoB',
																				father_husband_name='$data[12]',
																				address='$data[21]',
																				correspondance='$data[22]',
																				phone_no='$data[23]',
																				marital_status='$data[35]',
																				designation='$designationId',
																				Date_joining='$Doj'";



                $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());
                $emp_rec_id = mysql_insert_id();
                $sql_insert = "update " . $mysql_table_prefix . "employee_master set 
																			emp_id = '$emp_rec_id'
																			where rec_id = '$emp_rec_id'";
                $result_insert = mysql_query($sql_insert) or die("Error in query:" . $sql_insert . "<br>" . mysql_error() . "<br>" . mysql_errno());


                $sql_insert_femaily = "insert into " . $mysql_table_prefix . "family_master set
																					emp_id = '$emp_rec_id',
																					father_name='$data[11]',
																					father_dob='$fdob',
																					mother_name='$data[31]',
																					mother_dob='$mdob',
																					wife_name='$data[36]',
																					wife_dob='$wdob'";

                $result_insert_femily = mysql_query($sql_insert_femaily) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $sql_insert_official = "insert into " . $mysql_table_prefix . "official_detail set
			 																	emp_id = $emp_rec_id,
																				date_joining='$Doj'";

                $result_insert_official = mysql_query($sql_insert_official) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $sql_insert_pf = "insert into " . $mysql_table_prefix . "account_detail set
			 																		emp_id = '$emp_rec_id',
																					pf_number='$pf_no',
																					bank_name='$data[28]',
																					account_no='$data[29]',
																					esic_number='$data[3]'";

                $result_insert_pf = mysql_query($sql_insert_pf) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());


                $sql_insert_salary = "insert into " . $mysql_table_prefix . "salary_master set
			 																			emp_id = '$emp_rec_id',
																						basic='$data[17]'";

                $result_insert_salary = mysql_query($sql_insert_salary) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $sql_loan = "insert into " . $mysql_table_prefix . "loan_employee set 
																			emp_id = '$emp_rec_id',
																			loan_amount = '$loan'";

                mysql_query($sql_loan) or die("Error in query:" . $sql_loan . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $sql_advance = "insert into " . $mysql_table_prefix . "advance_employee set 
																				emp_id = '$emp_rec_id',
																				ad_date = now()";

                mysql_query($sql_advance) or die("Error in query:" . $sql_advance . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $que = mysql_query("INSERT INTO `ssofts_lss`.`assets_detail` (`rec_id`, `emp_id`) VALUES ('', '$emp_login')");

                $sql_check = "insert into " . $mysql_table_prefix . "plant_employee set
																		emp_id='$emp_rec_id',
																		from_date='0000-00-00',
																		to_date='0000-00-00'";
                $result_check = mysql_query($sql_check) or die("Query Failed" . mysql_error());

                $sql_check = "insert into  " . $mysql_table_prefix . "shift_detail set	
																emp_id  ='$emp_rec_id',
																off_day='$off_days',
																InsertBy ='$emp_login',
																InsertDate =now(),
																IpAddress ='$ip'";

                $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());

                $sql_insert_dept = "insert into " . $mysql_table_prefix . "department_employee  set 
																						emp_id = '$emp_rec_id',
																						from_date = now()";

                mysql_query($sql_insert_dept) or die("Error in query:" . $sql_insert_dept . "<br>" . mysql_error() . "<br>" . mysql_errno());



                $sql_insert_desi = "insert into " . $mysql_table_prefix . "designation_employee  set 
																						emp_id = '$emp_rec_id',
																						from_date = now()";

                mysql_query($sql_insert_desi) or die("Error in query:" . $sql_insert_desi . "<br>" . mysql_error() . "<br>" . mysql_errno());


                $sql_check = "insert into  " . $mysql_table_prefix . "rotation_type_employee set	
																emp_id  ='$emp_rec_id',
																from_date =now(),
																to_date ='0000-00-00'";

                $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());

                //  weekly off
                $sql_check = "insert into  " . $mysql_table_prefix . "weekly_off_employee set	
																emp_id  ='$emp_rec_id',
																from_date =now(),
																to_date ='0000-00-00'";

                $result_check = mysql_query($sql_check) or die("Query Failed " . mysql_error());

                $sql_insert_education = "insert into " . $mysql_table_prefix . "education_master  set
 																emp_id  ='$emp_rec_id'";

                $result_family_education = mysql_query($sql_insert_education) or die("Error in query:" . $sql_insert_education . "<br>" . mysql_error() . "<br>" . mysql_errno());

                $sql = "insert into mpc_login_master set 
		Username = '$username',Password = '$password',UserType = 'User',IsActive= '1'";

                $result_insert_personal = mysql_query($sql) or die("Error in query:" . $sql_insert_personal . "<br>" . mysql_error() . "<br>" . mysql_errno());



                /*
                  $sql_insert_personal = "insert into ".$mysql_table_prefix."employee_master  set
                  emp_id = '$emp_login',
                  ticket_no='$emp_login',
                  empType ='$data[1]',
                  first_name = '$data[4]',
                  last_name = '$data[3]',                                                                                email_id = '$data[4]'";
                 */




                /* $sql_insert_personal = "insert into ".$mysql_table_prefix."employee_master  set 
                  emp_id = '$emp_login',
                  ticket_no='$emp_login',
                  empType ='$data[1]',
                  first_name = '$data[2]',
                  last_name = '$data[3]',                                                                                email_id = '$data[4]'";


                  $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());

                  $emp_rec_id = mysql_insert_id();

                  $sql_insert_personal = "insert into ".$mysql_table_prefix."account_detail  set
                  emp_id = '$emp_rec_id',
                  date_releaving='0000-00-00'";

                  $result_insert_personal = mysql_query($sql_insert_personal) or die("Error in query:".$sql_insert_personal."<br>".mysql_error()."<br>".mysql_errno());

                  $sql_insert = "update ".$mysql_table_prefix."employee_master set
                  emp_id = '$emp_rec_id'
                  where rec_id = '$emp_rec_id'";
                  $result_insert = mysql_query($sql_insert) or die("Error in query:".$sql_insert."<br>".mysql_error()."<br>".mysql_errno()); */
            }
//            } else {
//                echo "formate is wrong plz check it..";
//                return false;
//            }
        }

        fclose($handle);

        print "Import done";

        //view upload form
    }
    /* else{
      ?>
      <h1 style="background:#F00"><center>Please select the file</center></h1>
      <?php //echo "<p style='background:red'>Please select the file</p>";
      } */
    ?>
</div>
