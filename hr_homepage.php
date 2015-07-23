<?
include ("inc/hr_header.php");
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
        <td align="left" valign="top" width="230px" style="padding-top:5px;box-shadow:1px 1px 1px 0 rgba(1,1,1,0.1);">
            <? include ("inc/snb.php"); ?>
        </td>

        <td style="padding-left:5px; padding-top:10px; float:left;" align="left" valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td align="center" class="gray_bg">&nbsp; Home</td>
                </tr>
                <tr>
                    <td height="400px" valign="top" style="padding-top:40px; padding-left:40px;">
                        <table width="96%" cellpadding="0" cellspacing="0" align="left" border="0">
                            <tr>
                                <td align="left" valign="top" width="100%">
                                    <div class="emp">

                                        <a href="employee_detail.php?unset"><img src="images/empoyee.png"/><br />Add Employee</a>
                                    </div>
                                    <div class="emp">

                                        <a href="list_employee.php"><img src="images/list-employee.png"/><br />List Employee</a>
                                    </div>
                                    <!-- <div style="float:left;">
                                     
                                      <a href="employee_detail.php"><img src="images/empoyee.png"/><br />Make Offer</a>
                                  </div>-->
                                    <div class="emp">

                                        <a href="atten.php"><img src="images/calendar.png"/><br />Mark Attendance</a>
                                    </div>
                                    <div class="emp">

                                        <a href="leave_manage.php"><img src="images/leave-mngmt.png"/><br />Leave Management</a>
                                    </div>
                                    <div class="emp">

                                        <a href="month_wise_attendance.php"><img src="images/att-report.png"/><br />Attendance Report</a>
                                    </div>

                                </td>

<!-- <td align="left" valign="top" width="20%">
        <img src="images/calendar.png" />
    <div class="heading_red">Attendence Master</div>
        <div class="link_green">
        <a href="mark_attendance.php">Mark Attendance</a><br />
        <a href="leave_manage.php">Leave Management</a><br />
        <a href="month_wise_attendance.php">Attendance Report</a><br />
      
    </div>
</td>
<td align="left" valign="top" width="20%">
        <img src="images/money.png"/>
    <div class="heading_red">Advance/Loan</div>
    <div class="link_green">
        <a href="pay_loan.php">Loan</a><br />
        <a href="pay_advance.php">Advance</a><br />
        <a href="insertadvanceloan.php">Insert Loan/Advance</a>
    </div>
</td>
                                -->

                            </tr>
                            <tr>
                                <td>
                                    <!--<div class="emp">
                                   
                                   <a href="month_wise_attendance.php"><img src="images/money.png"/><br />Advance/Loan</a>  
                                   </div>   -->
                                    <div class="emp">

                                        <a href="insertadvanceloan.php"><img src="images/loan.png"/><br />Loan</a>
                                    </div>
                                    <div class="emp">
                                        <a href="request_status.php">
                                            <!--<img src="images/advance.png"/>-->
                                            <br/>
                                            Approved Edit Request
                                        </a>
                                    </div>
                                    <!--div class="emp">
                                   
                                   <a href="month_wise_attendance.php"><img src="images/att-report.png"/><br />Insert Loan/Advance</a>
                                   </div>  -->
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