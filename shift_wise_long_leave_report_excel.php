<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename=shift_wise_long_leave_report.xls");
?>
<?
$date=$_POST['txt_date'];
$shift=$_POST['shift_detail'];
$data_date=getdbDate($date);
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
    	<td>
        	DEPTT/SHIFT WISE LONG LEAVE REPORT OF DATE:<?=$date?>
        </td>
        <td>
        	SHIFT:<?=$shift?>
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
                    	Leave Type
                    </td>
                    <td>
                    	Leave Days
                    </td>
                    <td>
                    	From Date
                    </td>
                    <td>
                    	To Date
                    </td>
                </tr>
                  <?
$sql_prj = "select * from ".$mysql_table_prefix."department_master where reference_id='0'";

$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
if(mysql_num_rows($result_prj)>0)
		{
		 while($row=mysql_fetch_array($result_prj))
				{	
				$sql_sub = "select * from ".$mysql_table_prefix."department_master where reference_id='".$row['rec_id']."'";

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
				 $sql_emp = "select * from ".$mysql_table_prefix."employee_master,mpc_shift_detail,mpc_department_employee where mpc_employee_master.rec_id = mpc_shift_detail.emp_id and mpc_department_employee.emp_id = mpc_shift_detail.emp_id and mpc_shift_detail.shift='$shift' and mpc_shift_detail.to_date='0000-00-00' and mpc_department_employee.dept_id ='".$row_sub['rec_id']."' and mpc_department_employee.to_date='0000-00-00'";
				$result_emp = mysql_query($sql_emp) or die("Error in Query :".$sql_emp."<br>".mysql_error().":".mysql_errno());
				if(mysql_num_rows($result_emp)>0)
						{
							$s=1;
							
						 while($row_emp=mysql_fetch_array($result_emp))
								{
								
								 $sql = "SELECT * FROM mpc_leave_application where leave_date='$data_date' and emp_id='".$row_emp['emp_id']."'";
								$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
								$leave_type="";	
								
								if(mysql_num_rows($result)>0)
								{	
									
									while($row_leave = mysql_fetch_array($result))
									{
										$leave_type=$row_leave['leave_type'];
										$start_date=$row_leave['start_date'];
										$end_date=$row_leave['end_date'];
									}
								}	
								
								if($leave_type=="PL")
									{
								?>
								<tr>
                                	<td><?=$s?></td>
                                    <td><?=$row_emp['ticket_no']?></td>
                                	<td>
                                    	<?=$row_emp['first_name']?> <?=$row_emp['last_name']?>
                                   	</td>
                                    <td>
                                    	<?=$leave_type?>
                                    </td>
                                    <td>
                                    	<?=dateDiffDB("-", $end_date,$start_date)?>
                                    </td>
                                    <td>
                                    	<?=getDatetime($start_date)?>
                                    </td>
                                    <td>	
                                    	<?=getDatetime($end_date)?>
                                    </td>
                                </tr>                                
                                <?	
								}	
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