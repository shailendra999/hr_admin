<?
$id="";
$emp_id = $_GET["id"];
$year = $_GET["str"];
include("inc/dbconnection.php");
include("inc/function.php");
$date_month=date('Y')."-".date('m')."-01";
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td align="center" colspan="3">
            <h3>Yearly Leave Report</h3>
        </td>
         <td>
        	<form action="print_yearly_leave_summary.php" method="post" name="frm_print" id="frm_print" target="_blank">
                <input type="hidden" name="emp_id" id="emp_id" value="<?=$emp_id?>"/>
                <input type="hidden" name="print_year" id="print_year" value="<?=$year?>"/>
                <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
            </form>
        </td>
    </tr>
    <tr>
    	<td>
        	<table>
            	 <tr>
                	<td>
                    	Emp Code
                    </td>
                    <td>
                    	:<?=getemployeeDetail('ticket_no',$emp_id)?>
                    </td>
                </tr>
            	<tr>
                	<td>
                    	 NAME
                    </td>
                    <td>
                    	:<?=getemployeeDetail('first_name',$emp_id)?> <?=getemployeeDetail('last_name',$emp_id)?>
                    </td>
                </tr>
                <tr>
                	<td>
                    	DATE OF JOINING
                    </td>
                    <td>
                    	:<?=getDatetime(getofficeDetail('date_joining',$emp_id))?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
        	DESIGNATION :<?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$emp_id,$date_month));?>
        </td>
        <td>
        	DEPARTMENT:<?=getdeptDetail('department_name','rec_id',getdepartmentDetail('dept_id',$emp_id,$date_month))?>
        </td>
    </tr>
	<tr>
    	<td colspan="3">
            <table border="1" width="100%">
              <tr>
                <td>Month/Year</td>
                <td>Total Days </td>
                <td>Present</td>
                <td>Weekly Off</td>
                <td>CL</td>
                <td>PL</td>
                <td>Leave Without Pay</td>
                <td>Absent</td>
              </tr>
              <?
			  	$total_month_day=0;
				$month_days=0;
				$total_no_present=0;
				$no_present=0;
				$total_no_weekOff=0;
				$no_weekOff=0;
				$total_no_cl=0;
				$no_cl=0;
				$no_pl=0;
				$total_no_pl=0;
				$total_no_lwp=0;
				$no_lwp=0;
				$no_absent=0;
				$total_no_absent=0;
			  	for($i=1;$i<=12;$i++)
				{
			  ?>
              	<tr>
                	<td><?=date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));?></td>
                    <td><?
					echo $month_days=date("t", strtotime($year. "-" .$i. "-01"));
						$total_month_day=$total_month_day+$month_days;
                    	?></td>
                    <td><? 
						echo $no_present=getleavecountMonthly($emp_id,"P",$i,$year);
						$total_no_present=$total_no_present+$no_present;
						?>
                        </td>
                	<td><? 
						echo $no_weekOff=getleavecountMonthly($emp_id,"W",$i,$year);
						 $total_no_weekOff=$total_no_weekOff+$no_weekOff;
						?>
                        </td>
                    <td><?
                  	  echo $no_cl=getleavecountMonthly($emp_id,"CL",$i,$year);
					$total_no_cl=$total_no_cl+$no_cl;
					?></td>
                    <td><?
                    	echo $no_pl=getleavecountMonthly($emp_id,"PL",$i,$year);
						$total_no_pl=$total_no_pl+$no_pl;
						?>
                        </td>
                    <td><?
                    echo $no_lwp=getleavecountMonthly($emp_id,"LWP",$i,$year);
					$total_no_lwp=$total_no_lwp+$no_lwp;
					?></td>
                    <td><?
                    echo $no_absent=getleavecountMonthly($emp_id,"A",$i,$year);
					$total_no_absent=$total_no_absent+$no_absent;
					?></td>
                </tr>
              <?
			  	}
			  ?>
              <tr>
              	 <td>Total</td>
                <td><?=$total_month_day?></td>
                <td><?=$total_no_present?></td>
                <td><?=$total_no_weekOff?></td>
                <td><?=$total_no_cl?></td>
                <td><?=$total_no_pl?></td>
                <td><?=$total_no_lwp?></td>
                <td><?=$total_no_absent?></td>
              </tr>
            </table>
        </td>
	</tr>
</table>