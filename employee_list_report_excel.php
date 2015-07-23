<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$date=$_POST['txt_date'];
$db_date=getdbDate($date);
$where_string_sub_department="";

if($_POST["department"]!="")
	{	
		$department=$_POST["department"];
		$where_string_department=" rec_id ='$department'";
	}
	else
	{
		$where_string_department=" reference_id='0'";
	}
if($_POST["sub_department"]!="" and $_POST["department"]!="")
{
	$sub_department=$_POST["sub_department"];	
	$where_string_sub_department="and rec_id ='$sub_department'";
}

if((isset($_POST["employee_type"])!=""))
{	
	$select_string=",mpc_designation_employee.*,mpc_designation_master.*";
	$employee_type=$_POST["employee_type"];
	$table_list= ",mpc_designation_employee,mpc_designation_master";
	$where_string="and mpc_designation_employee.emp_id = mpc_department_employee.emp_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
}
?>
<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=employee_list".$date.".xls");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="style/hr_style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
         <td align="center">Laxyo Solution Soft Pvt. Ltd.</td>
    </tr>
	<tr>
    	<td>
        	List  of  Empolyee(STAFF/SEMISTAFF/WORKERS):<?=$date?>
        </td>
    </tr>
    <tr>
    	<td colspan="1">
        	<table width="100%">
            	<tr>
                	<td width="3%">
                    	SNO
                    </td>
                    <td width="10%">
                    	EMPLOYEE ID
                    </td>
                    <td width="35%">
                    	NAME
                    </td>
                    <td width="35%">
                    	Designation
                    </td>
                    <td>
                    	Date Join
                    </td>
                </tr>
                  <?
$sql_prj = "select * from ".$mysql_table_prefix."department_master where $where_string_department";
$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
if(mysql_num_rows($result_prj)>0)
		{
		 while($row=mysql_fetch_array($result_prj))
				{	

				$sql_sub = "select * from ".$mysql_table_prefix."department_master where reference_id='".$row['rec_id']."' $where_string_sub_department";
				$result_sub = mysql_query($sql_sub) or die("Error in Query :".$sql_sub."<br>".mysql_error().":".mysql_errno());
				if(mysql_num_rows($result_prj)>0)
						{
						 while($row_sub=mysql_fetch_array($result_sub))
								{	
				?>
                            <tr>
                                <td colspan="8" align="left">
                                    <?=$row['department_name']?>(<?=$row_sub['department_name']?>)                      
                                </td>
                            </tr>  
                <?
				   $sql_emp = "select * $select_string from ".$mysql_table_prefix."employee_master,mpc_department_employee,mpc_official_detail,mpc_account_detail $table_list where mpc_official_detail.emp_id=mpc_employee_master.rec_id and mpc_account_detail.emp_id=mpc_employee_master.rec_id and mpc_employee_master.rec_id=mpc_department_employee.emp_id and mpc_department_employee.dept_id ='".$row_sub['rec_id']."' and mpc_department_employee.to_date='0000-00-00' and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no ASC";
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
                                    	<?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$row_emp['emp_id'],$db_date))?>
                                    </td>
                                    <td>
                                    	<?=getDatetime($row_emp['date_joining'])?>
                                    </td>
                                </tr>                                
                                <?		
								$s++;
								}
						}		
								}	
						}		
				}
		}
				?>		                                              	
            </table>
        </td>
    </tr>
</table>
</body>
</html>
