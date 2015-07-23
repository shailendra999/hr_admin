<link rel="stylesheet" href="css/ss.css">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="js/ss.js"></script>
<script src="js/selected_menuoption.js"></script>
<style>
</style>
<div id='cssmenu'>
    <ul>
        <li class="class_home"><a href="hr_homepage.php"><span>Home</span></a></li>
        <li class='has-sub class_emp_master'><a href='#'><span>Employee Master</span></a>
            <ul class='ul_class_emp_master'>
                <li><a href='create_employee_login.php'><span>Create Login</span></a></li>
                <li><a href='employee_detail.php?unset'><span>Add Employee</span></a></li>
                <li class="emp_maste_one"><a  href='list_employee.php'><span>List Employee</span></a></li>
                <li><a href='list_releaved_employee.php'><span>Relieved Employee</span></a></li>
                <li><a href='list_department_employee.php'><span>List Department</span></a></li>
                <li><a href='list_designation_employee.php'><span>List Designation</span></a></li>
                <li><a href='emp_import.php'><span>Import Employee Detail</span></a></li>
            </ul>
        </li>
        <!--li class='has-sub class_atnd'><a href='#'><span>Content Master</span></a>	
            <ul class="ul_class_atnd">
                <li><a href='department_master.php'><span>Department</span></a></li>
                <li><a href='designation_master.php'><span>Designation</span></a></li>
                <li><a href='leave.php'><span>Leave</span></a></li>
            </ul>
        </li-->

<!--        <li class='has-sub class_attendence_master'><a href='#'><span>Attendance Master</span></a>
            <ul class="ul_class_attendence_master">
                <li><a href='leave_application.php'><span>Leave Applications</span></a></li>
                <li><a href='import_attendance.php'><span>Check Attendance</span></a></li>
                <li><a href='mark_attendance.php'><span>Mark Attendance</span></a></li> 
                <li><a href='atten.php'><span>Mark Attendance</span></a></li>
                <li><a href='monthly.php'><span>Mark Attendance Monthly and Import Attendance Monthly</span></a></li>  
                <li><a href='mark_good_work.php'><span>Mark OverTime</span></a></li>
                <li><a href='leave_manage.php'><span>Leave Management</span></a></li>
                <li><a href='month_wise_attendance.php'><span>Attendance Report</span></a></li>

   <li><a href='shift_wise_daily_attendence_report.php'><span>Shift Wise Daily Attendance</span></a></li>
<li><a href='shift_wise_daily_good_work_report.php'><span>Shift Wise Daily Good Work</span></a></li>
 <li><a href='shift_wise_absent_report.php'><span>Dept/Shift Absent</span></a></li>
<li><a href='shift_wise_long_leave_report.php'><span>Dept/Shift Long Leave</span></a></li>
                <li><a href="cofregister.php"><span>C/OFF REGISTER</span></a></li>
            </ul>
        </li>-->
        <!--My tab-->
        <li class='has-sub class_attendence_master'><a href='#'><span>Pay Roll</span></a>
            <ul class="ul_class_attendence_master">
                <li><a href='leave_application.php'><span>Leave Applications</span></a></li>
                <li><a href='attendance.php'><span>Mark Attendance</span></a></li>
                <li><a href='mark_good_work.php'><span>Mark OverTime</span></a></li>
                <li><a href='salary_deductions.php'><span>Salary Deduction</span></a></li>
                <li><a href='salary_slip.php'><span>Salary Slip</span></a></li>
                <li><a href="cofregister.php"><span>C/OFF Register</span></a></li>
                <li><a href="arrear.php"><span>Arrear Register</span></a></li>
            </ul>
        </li>
        <li class='has-sub class_report'><a href='#'><span>Report</span></a>	
            <ul class="ul_class_report">
                <li><a href='month_wise_attendance.php'><span>Attendance Report</span></a></li>

                <li><a href='import_attendance.php'><span>Check Attendance</span></a></li>
                <li><a href='ot_report.php'><span>Over Time Report</span></a></li>     
                <li><a href='pf_statement_report_employee.php'><span>PF Statement Report</span></a></li>
                <li><a href='esi_statement_report_employee.php'><span>ESI Statement Report</span></a></li>
                <li><a href='salary_report_employee.php'><span>Salary Report Employee</span></a></li>                
                <li><a href='ecs_report.php'><span>ECS Report</span></a></li>                
                <!--li><a href='salarysheet.php'><span>Salary Sheet</span></a></li-->
                <li><a href='salary_deduction_list.php'><span>Salary Deduction list</span></a></li>
                <li><a href='salary_report_department.php'><span>Salary Report Department</span></a></li>
                <li><a href='daily_salary_report_department.php'><span>Daily Salary Report Department</span></a></li>
                <li><a href='leave_report_employee.php'><span>Employee Leave Report</span></a></li>


                <li><a href='form5_report.php'><span>Form-5 Report</span></a></li>
                <li><a href='form10_report.php'><span>Form-10 Report</span></a></li>
                <li><a href='formc_bonus_report.php'><span>Form-C Bonus Report</span></a></li>
                <li><a href='formd_bonus_report.php'><span>Form-D Bonus Report</span></a></li>
                <li><a href='bonus_exgratia_report.php'><span>Bonus & Exgratia Report</span></a></li>
                <li><a href='gratuity_report.php'><span>Gratuity Statement</span></a></li>
                <li><a href='gratuity_summary.php'><span>Gratuity Summary</span></a></li>

                <li><a href='employee_list_report.php'><span>Employee List</span></a></li>

                <li><a href='list_salary_employee.php'><span>List Salary</span></a></li>



            </ul>
        </li>


        <!--My code end here-->



<!--        <li class='has-sub class_salary_master'><a href='#'><span>Salary Master</span></a>	
    <ul class="ul_class_salary_master">
        <li><a href='list_salary_employee.php'><span>List Salary</span></a></li>
        <li><a href='salary_slip.php'><span>Salary Slip</span></a></li>
        <li><a href='salary_deductions.php'><span>Salary Deduction</span></a></li>
        <li><a href='salary_deduction_list.php'><span>Salary Deduction list</span></a></li>
    </ul>
</li>-->

        <li class='has-sub class_atnd'><a href='#'><span>Advance/Loan</span></a>	
            <ul class="ul_class_atnd">
                <li><a href='insertadvanceloan.php'><span>Insert Loan/Advance</span></a></li>
                <li><a href='pay_advance.php'><span>Advance</span></a></li>
                <li><a href='list_advance.php'><span>Advance Report</span></a></li>
                <li><a href='pay_loan.php'><span>Loan</span></a></li>
                <li><a href='list_loan.php'><span>Loan Report</span></a></li>
                <li><a href='list_advance_deduction.php'><span>Adv Deduction Report</span></a></li>
               <!--<li><a href='list_loan_installment.php'><span>Loan Installment Report</span></a></li>-->
            </ul>
        </li>

<!--        <li class='has-sub class_report'><a href='#'><span>Report</span></a>	
            <ul class="ul_class_report">
                <li><a href='salary_report_employee.php'><span>Salary Report Employee</span></a></li>
                <li><a href='salary_report_department.php'><span>Salary Report Department</span></a></li>
                <li><a href='daily_salary_report_department.php'><span>Daily Salary Report Department</span></a></li>
                <li><a href='month_wise_good_work.php'><span>Over Time Report</span></a></li>
                <li><a href='daily_good_work_payment.php'><span>Daily Over Time Payment</span></a></li>
                <li><a href='leave_wages.php'><span>Leave Wages Report</span></a></li>
               <li><a href='leave_detail.php'><span>Yearly Leave Report</span></a></li>
                <li><a href='leave_report_employee.php'><span>Employee Leave Report</span></a></li>
                <li><a href='daily_working_report.php'><span>Daily Working Report</span></a></li>
                <li><a href='daily_depoyment_report.php'><span>Daily Deployment Report</span></a></li>
                <li><a href='pf_statement_report_employee.php'><span>PF Statement Report</span></a></li>
                <li><a href='esi_statement_report_employee.php'><span>ESI Statement Report</span></a></li>
                <li><a href='form5_report.php'><span>Form-5 Report</span></a></li>
                <li><a href='form10_report.php'><span>Form-10 Report</span></a></li>
                <li><a href='formc_bonus_report.php'><span>Form-C Bonus Report</span></a></li>
                <li><a href='formd_bonus_report.php'><span>Form-D Bonus Report</span></a></li>
                <li><a href='bonus_exgratia_report.php'><span>Bonus & Exgratia Report</span></a></li>
                <li><a href='gratuity_report.php'><span>Gratuity Statement</span></a></li>
                <li><a href='gratuity_summary.php'><span>Gratuity Summary</span></a></li>
                <li><a href='employee_list_report.php'><span>Employee List</span></a></li>
            </ul> 

        </li>-->

        <li class="class_notice_board"><a href="notice_board.php"><span>Notice Board</span></a></li>

        <li><a href="logoff.php"><span>Logoff</span></a></li>
    </ul>
</div>


