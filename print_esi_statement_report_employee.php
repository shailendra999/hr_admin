<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$msg ='';
$plant="";
$month="0";
$year="0";
?>
<?
if(isset($_GET['start']))
{
	if($_GET['start']=='All')
	{
		$start = 0;
	}
	else
	{
		$start = $_GET['start'];
	}
}
else
{
	$start = 0;
}		
if(isset($_POST['print_month']))
{	
	 $month =$_POST['print_month'];
}	
if(isset($_POST['print_year']))
{	
	 $year =$_POST['print_year'];
}	
$employee_type="";
$department="";
$sub_department="";
$plant_name="";
$ticket_id="";
$select_string= "";
$table_list= "";
$where_string="";
if(isset($_POST["print_employee_type"]) and isset($_POST["print_ticket_id"]) and isset($_POST["print_department"]) and isset($_POST["print_sub_department"])
and isset($_POST["print_plant_name"]))
	{
	if(($_POST["print_employee_type"]!=""))
		{	
		$select_string=",mpc_designation_employee.*,mpc_designation_master.*";
		$employee_type=$_POST["print_employee_type"];
		$table_list= ",mpc_designation_employee,mpc_designation_master";
		$where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
	    }
	if($_POST["print_ticket_id"]!="")
		{
		$select_string= "";
		$ticket_id=$_POST["print_ticket_id"];
		$table_list.= "";
		$where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
		}
	if($_POST["print_department"]!="" and $_POST["print_sub_department"]=="")
		{	
		$select_string= ",mpc_department_employee.*,mpc_department_master.*";
		$department=$_POST["print_department"];
		$table_list.= ",mpc_department_employee,mpc_department_master";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_master.reference_id ='$department' and mpc_department_employee.to_date='0000-00-00' and mpc_department_master.rec_id=mpc_department_employee.dept_id";
		}
		if($_POST["print_sub_department"]!="")
		{
		$select_string= ",mpc_department_employee.*";	
		$department=$_POST["print_department"];
		$sub_department=$_POST["print_sub_department"];
		$table_list.= ",mpc_department_employee";
		
		$where_string.="and mpc_department_employee.emp_id =mpc_employee_master.rec_id and mpc_department_employee.dept_id ='$sub_department' and mpc_department_employee.to_date='0000-00-00'";
		}
		if($_POST["print_plant_name"]!="")
		{	
		$select_string= ",mpc_plant_employee.*";
		$plant_name=$_POST["print_plant_name"];
		$table_list.= ",mpc_plant_employee";
		
		$where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
		}
	}
if(isset($_POST["btn_submit"]) or isset($_GET['month']))
{			
 $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.date_releaving $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by mpc_employee_master.ticket_no  ASC ";
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<thead>
                <tr>
                    <th align="center">Laxyo Solution Soft Pvt. Ltd.</th>
                </tr>
                <tr>
                    <th align="left">ESI STATMENT MONTH -<?=date("F",mktime(0, 0, 0,$month, 1, 0))?>,<?=$year?></th>
                </tr>
                <tr>
                    <th align="left">ESI STATMENT for <? if($_POST["print_plant_name"]!=""){echo '-Plant :'.$_POST["print_plant_name"]; } ?><? if($_POST["print_employee_type"]!=""){echo '-Employee Type :'.$_POST["print_employee_type"]; } ?> <? if($_POST["print_department"]!=""){echo '-Department :'.getdeptDetail('department_name','rec_id',$_POST["print_department"]);}?><? if($_POST["print_sub_department"]!="")
        {echo '-Sub Department :'.getdeptDetail('department_name','rec_id',$_POST["print_sub_department"]);}?><? if($_POST["print_ticket_id"]!="")
        {echo '-Employee ID.:'.$_POST["print_ticket_id"];}?></th>
                </tr>
                  </thead>
                <tbody>
                <tr>
                	<td valign="top">
                    	<?php
                        if(mysql_num_rows($result_prj)>0)
                        {
                        $sno = $start+1;
                        ?>
                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                <thead>
                                  <tr>
                                    <td width="5%" align="center"><b>S.No.</b></td>
                                    <td width="5%" align="center"><b>IsDisable</b></td>
                                    <td width="5%" align="center"><b>IPNo.</b></td>
                                    <td width="15%" align="center"><b>IPName<br/></b></td>
                                    <td align="center"><b>No.Days</b></td>
                                    <td align="center"><b>TotalWages</b></td>
                                    <td align="center"><b>IPContribution</b></td>
                                    <td align="center"><b>Reason</b></td>
                                   </tr>
									<?
                                    while($row=mysql_fetch_array($result_prj))
										{
										$total_salary_basic=0;
										$total_lta=0;
										$total_convence=0;
										$total_medical=0;
										$total_hra=0;
										$other_deductions=0; 	
										$side_allowance=0;
										$prof_tax=0;
										$tds=0;
										$start_date="01";
										$emp_id=$row['id'];
										$Total=0;
										$flag=0;
										
										$start_date="01";
										$emp_id=$row['id'];
										
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
										
										$date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
										$date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
										$difference = $date1-$date; //Calcuates Difference
										$daysago = floor($difference /60/60/24); //Calculates Days Old
										
										$i = 0;
										while ($i <= $daysago +1) {
										if ($i != 0) { $date = $date + 86400; }
										else { $date = $date - 86400; }
										$today = date('Y-m-d',$date);
										//echo "$today ";
										
										$yy = date('Y',$date);
										$mm = date('m',$date);
										$dd = date('d',$date);
										
										$date1=$yy."-".$mm."-".$dd;
										$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));																
										if(getweeklyoffDetail('off_day',$row['id'],$date1)==$weekday and $row['employee_typ']!='daily_wages')
										{						
											$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
											$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
											$before_date=getLeavestatusBydate($row['id'],$date_before);
											$after_date=getLeavestatusBydate($row['id'],$date_after);
											if($before_date=='P' or $before_date=='OD' or $after_date=='P' or $after_date=='OD')
											{
												if($row['employee_typ']!='daily_wages')
												{
													$Total++;
													$flag=1;
												}
											}
											else if(getHoliday('rec_id',$date_before)!="")
												{
													if(validate_weekoff_before($row['id'],$mm,$dd-1,$yy))
													{
														$Total++;
														$flag=1;
													}
												}
												else if(getHoliday('rec_id',$date_after)!="")
												{
													if(validate_weekoff_after($row['id'],$mm,$dd+1,$yy))
													{
														$Total++;
														$flag=1;
													}
												}
												else if($leave_status=="Pl"  and (validate_weekoff_after($row['id'],$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
													{
														$Total++;
														$flag=1;
													}
												else if($leave_status=="Cl"  and (validate_weekoff_after($row['id'],$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
													{
														$Total++;
														$flag=1;
													}
										}
										else if(getHoliday('rec_id',$date1)!="")
										{
											$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
											$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
											$before_date=getLeavestatusBydate($row['id'],$date_before);
											$after_date=getLeavestatusBydate($row['id'],$date_after);
											
											if($before_date=='P' or $before_date=='OD' or $after_date=='P' or $after_date=='OD')
											{
												$Total++;
												$flag=1;
											}
											else if($before_date=='W')
											{
												$before_date2=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
												$before_date2=getLeavestatusBydate($row['id'],$before_date2);
												if($before_date2=='P' or $before_date2=='OD')
												{
													$Total++;
													$flag=1;
												}
											}
											else if($after_date=='W')
											{
												$after_date2=date('Y-m-d',mktime(0,0,0,$mm,$dd-2,$yy));
												$after_date2=getLeavestatusBydate($row['id'],$after_date2);
												if($after_date2=='P' or $after_date2=='OD')
												{
													$Total++;
													$flag=1;
												}
											}
										}
										else
										{
											$leave_status = getLeavestatusBydate($row['id'],$date1);
											if($leave_status=="P" or $leave_status=="CO/COF" or $leave_status=="OD" or $leave_status=="Cl" or $leave_status=="Pl")
												{
													$Total++;
													$flag=1;
												}	
											else if($leave_status=="HD")
												{
												   $Total=$Total+.5;
												   $flag=2;
												}
											}
										if($flag==1)
											{						
												if($row['employee_typ']=='daily_wages')
													{
													
														$total_salary_basic=$total_salary_basic+(getSalaryDetail("basic",$emp_id,$date1));
														$total_lta=$total_lta+(getSalaryDetail("leave_travel_allow",$emp_id,$date1));
														$total_convence=$total_convence+(getSalaryDetail("convence",$emp_id,$date1));	
														$total_medical=$total_medical+(getSalaryDetail("medical",$emp_id,$date1));	
														
														$total_hra=$total_hra+(getSalaryDetail("hra",$emp_id,$date1));	
														
														$side_allowance=$side_allowance +(getSalaryDetail("side_allowance",$emp_id,$date1));								
														$other_deductions=$other_deductions +(getSalaryDetail("other_deductions",$emp_id,$date1));											
	
													}
													else
													{		 
														$total_salary_basic=$total_salary_basic+(getSalaryDetail("basic",$emp_id,$date1)/$day2);
														$total_lta=$total_lta+(getSalaryDetail("leave_travel_allow",$emp_id,$date1)/$day2);
														$total_convence=$total_convence+(getSalaryDetail("convence",$emp_id,$date1)/$day2);	
														$total_medical=$total_medical+(getSalaryDetail("medical",$emp_id,$date1)/$day2);	
														
														$total_hra=$total_hra+(getSalaryDetail("hra",$emp_id,$date1)/$day2);	
														
														$side_allowance=$side_allowance +(getSalaryDetail("side_allowance",$emp_id,$date1)/$day2);								
														$other_deductions=$other_deductions +(getSalaryDetail("other_deductions",$emp_id,$date1)/$day2);											
													}
											}
											if($flag==2)
											{														 
												if($row['employee_typ']=='daily_wages')
													{
															$total_salary_basic=$total_salary_basic+((getSalaryDetail("basic",$emp_id,$date1))/2);
															$total_lta=$total_lta+((getSalaryDetail("leave_travel_allow",$emp_id,$date1))/2);
															$total_convence=$total_convence+((getSalaryDetail("convence",$emp_id,$date1))/2);	
															$total_medical=$total_medical+((getSalaryDetail("medical",$emp_id,$date1))/2);	
															
															$total_hra=$total_hra+((getSalaryDetail("hra",$emp_id,$date1))/2);	
															
															$side_allowance=$side_allowance +((getSalaryDetail("side_allowance",$emp_id,$date1))/2);								
															$other_deductions=$other_deductions +((getSalaryDetail("other_deductions",$emp_id,$date1))/2);											
													}
													else
													{									
														$total_salary_basic=$total_salary_basic+((getSalaryDetail("basic",$emp_id,$date1)/$day2)/2);
														$total_lta=$total_lta+((getSalaryDetail("leave_travel_allow",$emp_id,$date1)/$day2)/2);
														$total_convence=$total_convence+((getSalaryDetail("convence",$emp_id,$date1)/$day2)/2);	
														$total_medical=$total_medical+((getSalaryDetail("medical",$emp_id,$date1)/$day2)/2);
														
														$total_hra=$total_hra+((getSalaryDetail("hra",$emp_id,$date1)/$day2)/2);
														
														$side_allowance=$side_allowance +((getSalaryDetail("side_allowance",$emp_id,$date1)/$day2)/2);							
														$other_deductions=$other_deductions +((getSalaryDetail("other_deductions",$emp_id,$date1)/$day2)/2);											
													}
											}
										$flag=0;
										$i++;
										
										}
												
										$basic_rate=getSalaryDetail("basic",$emp_id,$date1);
	
										$total_earning=$total_salary_basic+$total_lta+$total_convence+$total_medical+$total_hra+$side_allowance;
										$esic_rate=getAccountDetail('esic_rate',$emp_id);
										$total_esi=($total_earning*$esic_rate)/100;
										
										$total_esi=ceil("$total_esi");
	
										if($esic_rate>0)
										{
									?>
								   <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                    <td width="5%" align="center"><?=$sno?></td>
                                    <td width="5%" align="center">
                                        -
                                    <td>
                                        <?=getAccountDetail('esic_number',$row['id'])?>
                                    </td>
                                    <td width="15%" align="left"><?=$row['first_name']?> <?=$row['last_name']?><br/></td>
                                    <td align="center">
                                        <?=$Total?>
                                    </td>
                                    <td align="center">
                                        <?=round($total_earning)?>
                                    </td>
                                    <td align="center"> 
                                       <?=round($total_esi)?>
                                    </td>
                                    <td align="center">
                                        <?
                                            if($Total==0)
                                            {
                                                echo "On Leave";
                                            }
                                            else
                                            {
                                                echo "-";
                                            }
                                        ?>
                                    </td>
                                  
                                  </tr>
                                    <?
                                        $sno++;
                                    }	
                                }
                                    ?>			 
                           </table>                                                             
						<?
                         }	 
                         else
                         {
                         ?>
                                 <tr class="table_rows">
                                    <td align="center" colspan="8">No records found</td>
                                  </tr>
						 <?
                          } 
                         ?>   
                </tbody>       	
            </table>
        </td>
    </tr>
</table>
<style>
@media print {
   thead {display: table-header-group;}
}
</style>
<script>
   window.print ();
</script>
