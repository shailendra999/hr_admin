<? include ("inc/dbconnection.php"); ?>
<? include ("inc/function.php"); ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Good Work Register</title>
        <link href="style/hr_style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?
        $msg = '';
        $plant = "";
        $month = "0";
        $year = "0";
        ?>
        <?
        if (isset($_GET['start'])) {
            if ($_GET['start'] == 'All') {
                $start = 0;
            } else {
                $start = $_GET['start'];
            }
        } else {
            $start = 0;
        }
        if (isset($_POST['print_month'])) {
            $month = $_POST['print_month'];
        }
        if (isset($_POST['print_year'])) {
            $year = $_POST['print_year'];
        }
        $start_date = "01";

        $day1 = $start_date;
        $month1 = $month;
        $year1 = $year;

        $day1 = $day1 + 1;

        $end_date = date("t", strtotime($year . "-" . $month . "-01"));

        $day2 = $end_date;
        $month2 = $month;
        $year2 = $year;


        $start_date = "$year1-$month1-$day1";

        $start_date_sql = "$year1-$month1-01";

        $end_date = "$year2-$month2-$day2";
        $employee_type = "";
        $department = "";
        $sub_department = "";
        $plant_name = "";
        $ticket_id = "";
        $select_string = "";
        $table_list = "";
        $where_string = "";
        if (isset($_POST["print_employee_type"]) and isset($_POST["print_ticket_id"]) and isset($_POST["print_department"]) and isset($_POST["print_sub_department"])
                and isset($_POST["print_plant_name"])) {
            if (($_POST["print_employee_type"] != "")) {
                $select_string = ",mpc_designation_employee.*,mpc_designation_master.*";
                $employee_type = $_POST["print_employee_type"];
                $table_list = ",mpc_designation_employee,mpc_designation_master";
                $where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
            }
            if ($_POST["print_ticket_id"] != "") {
                $select_string = "";
                $ticket_id = $_POST["print_ticket_id"];
                $table_list.= "";
                $where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
            }
            if ($_POST["print_department"] != "" and $_POST["print_sub_department"] == "") {
                $select_string = ",mpc_department_employee.*,mpc_department_master.*";
                $department = $_POST["print_department"];
                $table_list.= ",mpc_department_employee,mpc_department_master";

                $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
            }
            if ($_POST["print_sub_department"] != "") {
                $select_string = ",mpc_department_employee.*";
                $department = $_POST["print_department"];
                $sub_department = $_POST["print_sub_department"];
                $table_list.= ",mpc_department_employee";

                $where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
            }
            if ($_POST["print_plant_name"] != "") {
                $select_string = ",mpc_plant_employee.*";
                $plant_name = $_POST["print_plant_name"];
                $table_list.= ",mpc_plant_employee";

                $where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
            }
        }
        if (isset($_POST["btn_submit"]) or isset($_GET['month'])) {
            $sql_prj = "select cast( sum( cast(good_work AS TIME ) ) AS time ) as TotalGoodWork,DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving  $select_string from " . $mysql_table_prefix . "employee_master,mpc_official_detail,mpc_account_detail,mpc_good_work_master $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and mpc_employee_master.rec_id=mpc_good_work_master.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and date BETWEEN '$start_date_sql' and '$end_date' $where_string group by ticket_no HAVING TotalGoodWork!='00:00:00' order by mpc_employee_master.ticket_no ASC ";

            $result_prj = mysql_query($sql_prj) or die("Error in Query :" . $sql_prj . "<br>" . mysql_error() . ":" . mysql_errno());
        }
        ?>
        <table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
            <tr>      
                <td style="padding-left:5px; padding-top:5px;" valign="top">
                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                        <tr>
                            <td align="center">MAHIMA PURESPUN(A UNIT OF MAHIMA FIBRES PVT.LTD.)</td>
                        </tr>
                        <tr>
                            <td align="left">Good Work Register MONTH -<?= date("F", mktime(0, 0, 0, $month, 1, 0)) ?>,<?= $year ?></td>
                        </tr>
                        <tr>
                            <td align="left">Good Work Sheet for <?
                                if ($_POST["print_plant_name"] != "") {
                                    echo '-Plant :' . $_POST["print_plant_name"];
                                }
                                ?><?
                                if ($_POST["print_employee_type"] != "") {
                                    echo '-Employee Type :' . $_POST["print_employee_type"];
                                }
                                ?> <?
                                if ($_POST["print_department"] != "") {
                                    echo '-Department :' . $_POST["print_department"];
                                }
                                ?><?
                                if ($_POST["print_sub_department"] != "") {
                                    echo '-Sub Department :' . $_POST["print_sub_department"];
                                }
                                ?><?
                                if ($_POST["print_ticket_id"] != "") {
                                    echo '-Employee ID.:' . $_POST["print_ticket_id"];
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td valign="top">
                                <?
                                if (isset($_POST["btn_submit"]) or isset($_GET['month'])) {
                                    if (mysql_num_rows($result_prj) > 0) {
                                        $sno = $start + 1;
                                        ?>
                                        <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                            <tr>
                                                <td width="5%" align="center"><b>S.No.</b></td>
                                                <td width="5%" align="center"><b>Emp Id</b></td>
                                                <td width="15%" align="center"><b>Name</b></td>
                                                <?
                                                $start_date = "01";

                                                $day1 = $start_date;
                                                $month1 = $month;
                                                $year1 = $year;

                                                $day1 = $day1 + 1;

                                                $end_date = date("t", strtotime($year . "-" . $month . "-01"));

                                                $day2 = $end_date;
                                                $month2 = $month;
                                                $year2 = $year;


                                                $start_date = "$year1-$month1-$day1";

                                                $end_date = "$year2-$month2-$day2";

                                                $date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
                                                $date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
                                                $difference = $date1 - $date; //Calcuates Difference
                                                $daysago = floor($difference / 60 / 60 / 24); //Calculates Days Old

                                                $i = 0;
                                                while ($i <= $daysago + 1) {
                                                    if ($i != 0) {
                                                        $date = $date + 86400;
                                                    } else {
                                                        $date = $date - 86400;
                                                    }
                                                    $today = date('Y-m-d', $date);
                                                    //echo "$today ";

                                                    $yy = date('Y', $date);
                                                    $mm = date('m', $date);
                                                    $dd = date('d', $date);

                                                    echo "<td><b>";
                                                    echo "$dd";
                                                    echo "</b></td>";

                                                    $i++;
                                                }
                                                ?>
                                                <td align="center"><b>Total</b></td>
                                            </tr>
                                            <?
                                            while ($row = mysql_fetch_array($result_prj)) {
                                                $total_gw = "";

                                                $good_work_hour = 0;
                                                $good_work_min = 0;
                                                ?>
                                                <tr <? if ($sno % 2 == 1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                    <td width="5%" align="center"><?= $sno ?></td>
                                                    <td width="5%" align="center"><?= $row['ticket_no'] ?></td>
                                                    <td width="15%" align="left"><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                                                    <?
                                                    $start_date = "01";

                                                    $day1 = $start_date;
                                                    $month1 = $month;
                                                    $year1 = $year;

                                                    $day1 = $day1 + 1;

                                                    $end_date = date("t", strtotime($year . "-" . $month . "-01"));

                                                    $day2 = $end_date;
                                                    $month2 = $month;
                                                    $year2 = $year;


                                                    $start_date = "$year1-$month1-$day1";

                                                    $end_date = "$year2-$month2-$day2";

                                                    $date = mktime(0, 0, 0, $month1, $day1, $year1); //Gets Unix timestamp START DATE
                                                    $date1 = mktime(0, 0, 0, $month2, $day2, $year2); //Gets Unix timestamp END DATE
                                                    $difference = $date1 - $date; //Calcuates Difference
                                                    $daysago = floor($difference / 60 / 60 / 24); //Calculates Days Old

                                                    $i = 0;
                                                    while ($i <= $daysago + 1) {
                                                        if ($i != 0) {
                                                            $date = $date + 86400;
                                                        } else {
                                                            $date = $date - 86400;
                                                        }
                                                        $today = date('Y-m-d', $date);
                                                        //echo "$today ";

                                                        $yy = date('Y', $date);
                                                        $mm = date('m', $date);
                                                        $dd = date('d', $date);
                                                        $date1 = $yy . "-" . $mm . "-" . $dd;

                                                        echo "<td>";

                                                        if ($row['Day'] >= $dd and $row['Month'] == $mm and $row['Year'] == $yy) {
                                                            echo 'N/A';
                                                        } else {
                                                            $good_work = getGoodWorkBydate($row['emp_id'], $date1);
                                                            $daily_good_work_array = explode(':', $good_work);
                                                            if ($good_work != "") {
                                                                if ($daily_good_work_array[1] == 0) {
                                                                    $daily_good_work_array[1] = "00";
                                                                }
                                                                echo $daily_good_work_array[0] . ":" . $daily_good_work_array[1];
                                                            } else {
                                                                echo "0.0";
                                                            }
                                                            echo "</td>";

                                                            if ($good_work != "") {

                                                                $good_work_array = explode(':', $good_work);

                                                                $good_work_min = $good_work_min + $good_work_array[1];

                                                                $good_work_hour = $good_work_hour + $good_work_array[0];

                                                                if ($good_work_min == 60) {
                                                                    $good_work_hour = $good_work_hour + 1;

                                                                    $good_work_min = 0;
                                                                }
                                                                if ($good_work_min == 0) {
                                                                    $good_work_min = "00";
                                                                }
                                                                $total_gw = $good_work_hour . ":" . $good_work_min;
                                                            }
                                                        }

                                                        $i++;
                                                    }
                                                    ?>
                                                    <td align="center"><?= $total_gw ?></td>
                                                </tr>
                                                <?
                                                $sno++;
                                            }
                                            ?>														 
                                        </table>                                                           
                                    </td>
                                </tr> 
                                <?
                            } else {
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
        <script>
            window.print();
        </script>
    </body>
</html>