<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=shift_wise_daily_good_work_report_".$date.".xls");
?>
<?
$table_list="";
$where_string="";
$select_string="";
$date=$_POST['txt_date'];
$shift=$_POST['shift_detail'];
$department=$_POST['department'];
$sub_department=$_POST['sub_department'];

if($_POST["department"]!="" and $_POST["sub_department"]=="")
		{	
		
		$select_string= ",mpc_department_employee.*,mpc_department_master.*";
		$department=$_POST["department"];
		$table_list.= ",mpc_department_employee,mpc_department_master";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
		}
		if($_POST["sub_department"]!="")
		{
			$select_string= ",mpc_department_employee.*";	
			$department=$_POST["department"];
			$sub_department=$_POST["sub_department"];
			$table_list.= ",mpc_department_employee";
			
			$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
		}
if($sub_department=="")
{
	$sub_department=$_POST['department'];
}
?>
<?
$date=$_POST['txt_date'];
$shift=$_POST['shift_detail'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="style/hr_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="1000px" cellpadding="0" cellspacing="0" border="1">
	<tr>
    	<td align="center" colspan="2">
       				Laxyo Solution Soft Pvt. Ltd.
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        	<table width="1000px">
            	<tr>
                <td width="51%">
                    DEPT/SHIFT WISE Attendance REPORT OF DATE:<?=$date?>              
                </td>
                <td width="49%" align="right">
                    SHIFT:<?=$shift?>                
                </td>
                </tr>
          </table>
    </tr>
    <tr>
    	<td>
        	Department-<?=getdeptDetail('department_name','rec_id',$sub_department)?>
    	</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<table width="100%">
            	<tr>
                	<td>
                    	SNO
                    </td>
                    <td>
                    	EMPLOYEE ID
                    </td>
                    <td>
                    	NAME
                    </td>
                    <td>
                    	Good Work
                    </td>
                </tr>	
                <?
				
				 $sql_emp = "select mpc_good_work_master.*, mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name $select_string from ".$mysql_table_prefix."employee_master,mpc_good_work_master $table_list where mpc_employee_master.rec_id = mpc_good_work_master.emp_id and date='".getdbDate($date)."' and shift='".$shift."'  and mpc_good_work_master.good_work!='0:0' $where_string  order by ticket_no ASC";
				 
				$result_emp = mysql_query($sql_emp) or die("Error in Query :".$sql_emp."<br>".mysql_error().":".mysql_errno());
				if(mysql_num_rows($result_emp)>0)
						{
							$s=1;
						 while($row_emp=mysql_fetch_array($result_emp))
								{
								?>
								<tr>
                                	<td><?=$s?></td>
                                    <td><?=$row_emp['ticket_no']?></td>
                                	<td>
                                    	<?=$row_emp['first_name']?> <?=$row_emp['last_name']?>
                                   	</td>
                                    <td>
                                    	<?=$row_emp['good_work']?>
                                    </td>
                                </tr>                                
                                <?		
								$s++;
								}
						}		
				?>		                                              	
            </table>
        </td>
    </tr>
</table>
</body>
</html>