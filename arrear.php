<?php
error_reporting(0);
include("inc/hr_header.php");
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;">
            <? include ("inc/snb.php"); ?>
        </td> 
        <td style="padding-left:5px; padding-top:5px;" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">
                        &nbsp;
                        <a href="#" style="text-decoration:none;color:gray;">
                            Arrear Master                       
                        </a>
                        Arrear Registered
                    </td>
                </tr>
                <tr>
                    <td>

                        <div style="overflow:scroll;height:350px;width:100%; margin-top:10px;">
                            <form name="arrear_form" action="arrear_submit.php" method="post">
                                <table class="loginbg">
                                    <tr>
                                        <td>Arrear Date</td>
                                        <td>
                                            <select name="arrear_month" id="arrear_month" >
                                                <?php
                                                for ($i = 1; $i <= 6; $i++) {
                                                    $month = date("Y-F", strtotime("-" . $i . "Months"));
                                                    $m = date('Y-m', strtotime("-" . $i . "Months"));
                                                    ?>
                                                    <option value="<?= $m ?>">
                                                        <?= $month ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            Id
                                        </td>
                                        <td>
                                            <input type="text" name="emp_id" id="emp_id" required/>
                                        </td>
                                        <td>
                                            Pay Date 
                                        </td>
                                        <td>
                                            <input type="date" name="pay_date" id="pay_date" value="<?= date("Y-m-d") ?>" required/>
                                        </td>
                                        <td>
                                            Arrear Amount
                                        </td>    
                                        <td>
                                            <input type="text" name="arrear_amount" id="arrear_amount" required/>
                                        </td>
                                        <td>
                                            Arrear Reason
                                        </td>
                                        <td>
                                            <select name="arrear_res" id="arrear_res">
                                                <option value="1">Attendance deduction</option>
                                                <option value="2">Others</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="hidden" id="mode" name="mode" value="<?= $mode ?>"/>
                                            <input type="hidden" id="<?= $PageKey ?>" name="<?= $PageKey ?>" value="<?= $PageKeyValue ?>" />                  
                                            <input type="hidden" name="save_data" value="1">
                                            <input type="submit" name="save" id="save" value="save"  />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <table class="loginbg">
                                <tr>
                                    <td>
                                        S.No.
                                    </td>

                                    <td>
                                        Emp Id
                                    </td>
                                    <td>
                                        Employee Name
                                    </td>
                                    <td>
                                        Arrear Date
                                    </td>
                                    <td>
                                        Arrear Pay Date
                                    </td>
                                    <td>
                                        Arrear Amount
                                    </td>
                                    <td>
                                        Arrear Reason 
                                    </td>
                                    <td>
                                        Status
                                    </td>
                                </tr>
                                <?php
                                $sno = 1;
                                $select_arrear = mysql_query("select * from mpc_arrear_master");
                                while ($row = mysql_fetch_array($select_arrear)) {
                                    $emp_select = mysql_query("Select * from mpc_employee_master where emp_id = $row[emp_id]");
                                    $result = mysql_fetch_array($emp_select);
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $sno ?>
                                        </td>
                                        <td>
                                            <?= $result['ticket_no'] ?>
                                        </td>
                                        <td>
                                            <?= $result['first_name'] . " " . $result['last_name'] ?>
                                        </td>
                                        <td>
                                            <?= date('Y-F', strtotime($row['arrear_month'])) ?>
                                        </td>
                                        <td>
                                            <?= $row['arrear_pay'] ?>
                                        </td>    
                                        <td>
                                            <?= $row['arrear_amount'] ?>
                                        </td>
                                        <td>
                                            <?= $row['arrear_reason'] ?>

                                        </td>
                                        <td>
                                            <?
                                            if ($row['status'] == 1) {
                                                echo "Paid";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?
                                    $sno++;
                                }
                                ?>
                            </table>
                        </div>
                        <div>

                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
