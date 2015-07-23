$(document).ready(function(){ 
     var base_adrs = window.location.pathname; 
     
     switch(base_adrs){
        case '/lss/hr_homepage.php':
            $('.class_home').addClass('active');
            break
        case '/lss/employee_detail.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break    
        case '/lss/list_employee.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break 
        case '/lss/list_releaved_employee.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break 
        case '/lss/list_department_employee.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break 
        case '/lss/list_designation_employee.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break 
        case '/lss/emp_import.php':
            $('.class_emp_master').addClass('active');
            $('.ul_class_emp_master').css('display', 'block');
            break 
		case '/lss/leave_application.php':
		     $('.class_attendence_master').addClass('active');
			 $('.ul_class_attendence_master').css('display', 'block');
            break
        case '/lss/import_attendance.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/mark_attendance.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/monthly.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/mark_good_work.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/month_wise_attendance.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/atten.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/cofregister.php':
            $('.class_attendence_master').addClass('active');
            $('.ul_class_attendence_master').css('display', 'block');
            break 
        case '/lss/list_salary_employee.php':
            $('.class_salary_master').addClass('active');
            $('.ul_class_salary_master').css('display', 'block');
            break 
        case '/lss/salary_slip.php':
            $('.class_salary_master').addClass('active');
            $('.ul_class_salary_master').css('display', 'block');
            break 
        case '/lss/salary_deductions.php':
            $('.class_salary_master').addClass('active');
            $('.ul_class_salary_master').css('display', 'block');
            break 
        case '/lss/salary_deduction_list.php':
            $('.class_salary_master').addClass('active');
            $('.ul_class_salary_master').css('display', 'block');
            break            
        case '/lss/insertadvanceloan.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break 
        case '/lss/pay_advance.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break 
        case '/lss/list_advance.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break 
        case '/lss/pay_loan.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break 
        case '/lss/list_loan.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break 
        case '/lss/list_advance_deduction.php':
            $('.class_atnd').addClass('active');
            $('.ul_class_atnd').css('display', 'block');
            break  
        case '/lss/salary_report_employee.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/salary_report_department.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/daily_salary_report_department.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/leave_report_employee.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/pf_statement_report_employee.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/esi_statement_report_employee.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/form5_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break       
        case '/lss/form10_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/formc_bonus_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/formd_bonus_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/bonus_exgratia_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/gratuity_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/gratuity_summary.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/employee_list_report.php':
            $('.class_report').addClass('active');
            $('.ul_class_report').css('display', 'block');
            break 
        case '/lss/notice_board.php':
            $('.class_notice_board').addClass('active');
            break 
 
     }
 });
