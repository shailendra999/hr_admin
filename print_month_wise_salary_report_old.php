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
	$sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
}
$date_month=$year."-".$month."-01";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<thead>
                    <tr>
                        <td align="center">MAHIMA PURESPUN(A UNIT OF MAHIMA FIBRES PVT.LTD.)</td>
                    </tr>
                    <tr>
                        <td align="left">Salary Employee Report MONTH -<?=date("F",mktime(0, 0, 0,$month, 1, 0))?>,<?=$year?></td>
                    </tr>
                    <tr>
                        <td align="left">Salary Employee for <? if($_POST["print_plant_name"]!=""){echo '-Plant :'.$_POST["print_plant_name"]; } ?><? if($_POST["print_employee_type"]!=""){echo '-Employee Type :'.$_POST["print_employee_type"]; } ?> <? if($_POST["print_department"]!=""){echo '-Department:'.getdeptDetail('department_name','rec_id',$_POST["print_department"]);}?><? if($_POST["print_sub_department"]!="")
            {echo '-Sub Department:'.getdeptDetail('department_name','rec_id',$_POST["print_sub_department"]);}?><? if($_POST["print_ticket_id"]!="")
            {echo '-Employee ID.:'.$_POST["print_ticket_id"];}?></td>
                    </tr>
                   </thead>
                <tr>
                	<td valign="top">
                    	<?
                        if(mysql_num_rows($result_prj)>0)
                        {
                        $sno = $start+1;
                        ?>
                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                               <thead>
                                  <tr>
                                    <td width="5%" align="center"><b>S.No.</b></td>
                                    <td width="5%" align="center"><b>Emp Id .</b></td>
                                    <td width="5%" align="center"><b>Employee Name<br/></b></td>
                                    <td width="15%" align="center"><b>Father Name <br/> Designation</b></td>
                                    <td align="center"><b>BasicR <br/> H/Rent</b></td>
                                    <td align="center"><b>Paid Days<br/>ADVANCE</b><br /><b>Fine</b></td>
                                    <td align="center"><b>Basic<br/>LOAN</b><br/><b>Damage/loss</b></td>
                                    <td align="center"><b>LTA<br/>P.TAX</b><br/><b>Canteen</b></td>
                                    <td align="center"><b>CONV<br/>TDS</b><br/><b>Society Welfare</b></td>
                                    <td align="center"><b>MEDICAL<br/>PF</b><br/><b>Electrical</b></td>
                                    <td align="center"><b>HRA<br/>E.S.I.</b><br/><b>Security</b></td>
                                    <td align="center"><b>S/A<br/>Other</b></td>
                                    <td align="center"><b>Total Earning<br/>Total Deduction</b></td>
                                    <td align="center"><b>Net</b></td>
                                    <td align="center"  width="15%"><b>Signature</b></td>
                                  </tr>
                               </thead>
                                    <?
									$grand_basic=0;
									$grand_lta=0;
									$grand_ptax=0;
									$grand_con=0;
									$grand_tds=0;
									$grand_medical=0;
									$grand_pf=0;
									$grand_esi=0;
									$grand_sa=0;
									$grand_lta=0;
									$grand_earn=0;
									$grand_ded=0;
									$grand_net=0;
									$grand_hra=0;
									$grand_lta=0;
									$grand_advance=0;
									$grand_fine=0;
									$grand_loan=0;
									$grand_damage=0;
									$grand_canteen=0;
									$grand_society_fare=0;
									$grand_security =0;
									$grand_electrical =0;
									$grand_days=0;
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
										else if($leave_status=="Pl")
										{ 
											$Total++;
											$flag=1;
										}
									else if($leave_status=="Cl")
										{
											$Total++;
											$flag=1;
										}
										//else if(getLeavestatusBydate($row['id'],$date1)=="A")
//											{
//												$leave_status='A';
//											}
//										else if($leave_status=="Pl" and (validate_weekoff_after($row['id'],$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
//											{
//												$Total++;
//												$flag=1;
//											}
//										else if($leave_status=="Cl" and (validate_weekoff_after($row['id'],$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
//											{
//												$Total++;
//												$flag=1;
//											}
									}
									else if(getHoliday('rec_id',$date1)!="")
									{
										$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
										$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
										$before_date=getLeavestatusBydate($row['id'],$date_before);
										$after_date=getLeavestatusBydate($row['id'],$date_after);
										$weekday_before = date("l", mktime(0,0,0,$mm,$dd-1,$yy));
										$weekday_after = date("l", mktime(0,0,0,$mm,$dd+1,$yy));
										
										if($before_date=='P' or $before_date=='OD' or $after_date=='P' or $after_date=='OD')
										{
											$h++;
											$leave_status='H';
											$Total++;
											$flag=1;
										}
										else if(getweeklyoffDetail('off_day',$row['id'],$date_before)==$weekday_before)
										{
											if(validate_weekoff_before($row['id'],$mm,$dd-1,$yy))
											{
												$h++;
												$leave_status='H';
												$Total++;
												$flag=1;
											}
										}
										else if(getweeklyoffDetail('off_day',$row['id'],$date_after)==$weekday_after)
										{
											if(validate_weekoff_after($row['id'],$mm,$dd+1,$yy))
											{
												$h++;
												$leave_status='H';
												$Total++;
												$flag=1;
											}
										}
										else 
											{
												$leave_status=getLeavestatusBydate($row['id'],$date1);
												if($leave_status=="" or $leave_status=="A")
												{
													$leave_status='A';
													$absent++;
												}
												else if($leave_status=="Pl")
												{ 
													$Pl++;
													$Total++;
													$flag=1;
												}
												else if($leave_status=="Cl")
												{
													$Cl++;
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
									$total_pf=($total_salary_basic*getAccountDetail('pf_rate',$emp_id))/100;
									$total_esi=($total_earning*getAccountDetail('esic_rate',$emp_id))/100;
									
									$total_advance=getadvance($emp_id,$month,$year);
	
									$total_loan=getloanDeduction($emp_id,$month,$year);
									$prof_tax=getSalaryDetail("professional_tax",$emp_id,$date1);
									$tds=getSalaryDetail("tds",$emp_id,$date1);
									$monthDeduction=getSalaryDeduction($emp_id,$month,$year);
									
									$sql = "SELECT sum(salary_fine) as salary_fine,sum(salary_damage) as salary_damage,sum(salary_canteen) as salary_canteen ,sum(salary_society_welfare) as salary_society_welfare, sum(salary_electrical) as salary_electrical, sum(salarly_security) as salarly_security ,sum(salary_house_rent) as salary_house_rent FROM mpc_salary_deduction where emp_id  = '".$emp_id."' and  MONTH(salary_deduction_date)='".$month."' and YEAR(salary_deduction_date) ='".$year."'";
									
									$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
									if(mysql_num_rows($result)>0)
									{
										$row_salary_deduction=mysql_fetch_array($result);
									}
									$total_esi=ceil("$total_esi");
									
									
									$total_deductions=$total_pf+$total_esi+$total_advance+$other_deductions+$prof_tax+$tds+$total_loan+$monthDeduction;
									
									$net_salary=$total_earning-$total_deductions;
									$grand_days=$grand_days+$Total;
									if($Total>0)
									{
									?>
                                   <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt" style="height:85px;" height="85px">
                                        <td width="5%" align="center"><?=$sno?></td>
                                        <td width="5%" align="center"><?=$row['ticket_no']?></td>
                                        <td width="5%" align="center">
                                        <?=$row['first_name']?> <?=$row['last_name']?><br/>
                                        </td>
                                        <td width="15%" align="center"><?=getfamilyDetail('father_name',$emp_id)?><br/><?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$emp_id,$date_month));?></td>
                                        <td align="center">
                                            <?=$basic_rate?>
                                            <br/>
                                             <?=$row_salary_deduction['salary_house_rent']?>
                                        </td>
                                        <td align="center"><?=$Total?><br/> <?=$total_advance?> <br/> <?=$row_salary_deduction['salary_fine']?></td>
                                        <td align="center">
                                            <?=round($total_salary_basic)?>
                                            <br/>
                                            <?=round($total_loan)?>
                                            <br/> <?=$row_salary_deduction['salary_damage']?>
                                        </td>
                                        <td align="center">
                                            <?=round($total_lta)?>
                                            <br/>
                                            <?=round($prof_tax)?>
                                            <br/> <?=$row_salary_deduction['salary_canteen']?>
                                        </td>
                                        <td align="center">
                                            <?=round($total_convence)?>
                                            <br/>
                                            <?=round($tds)?>
                                            <br/> <?=$row_salary_deduction['salary_society_welfare']?>
                                        </td>
                                        <td align="center">
                                            <?=round($total_medical)?>
                                            <br/>
                                            <?=round($total_pf)?>
                                            <br/> <?=$row_salary_deduction['salary_electrical']?>
                                        </td>
                                        <td align="center">
                                            <?=round($total_hra)?>
                                            <br/>
                                            <?=round($total_esi)?>
                                            <br/> <?=$row_salary_deduction['salarly_security']?>
                                        </td>
                                        <td align="center">
                                            <?=round($side_allowance)?>
                                             <br/>
                                            <?=round($other_deductions)?>          
                                        </td>
                                        <td align="center">
                                            <?=round($total_earning)?>
                                            <br/>
                                            <?=round($total_deductions)?>
                                        </td>
                                         <td align="center">
                                            <?=round($net_salary);?>
                                        </td>
                                        <td>&nbsp;
                                        	
                                        </td>
                                      </tr>
                                    <?
										
                                        $sno++;
										$grand_basic=$total_salary_basic+$grand_basic;
										$grand_advance=$grand_advance+$total_advance;
										$grand_fine=$row_salary_deduction['salary_fine']+$grand_fine;
										$grand_loan=$total_loan+$grand_loan;
										$grand_damage=$row_salary_deduction['salary_damage']+$grand_damage;
										$grand_canteen=$row_salary_deduction['salary_canteen']+$grand_canteen;
										$grand_society_fare=$row_salary_deduction['salary_society_welfare']+$grand_society_fare;
										$grand_electrical=$row_salary_deduction['salary_electrical']+$grand_electrical;
										$grand_security=$row_salary_deduction['salarly_security']+$grand_security;
										
										$grand_lta=$total_lta+$grand_lta;
										$grand_hra=$total_hra+round($grand_hra);
										$grand_ptax=$prof_tax+$grand_ptax;
										$grand_con=$total_convence+$grand_con;
										$grand_tds=$tds+$grand_tds;
										$grand_medical=$total_medical+$grand_medical;
										$grand_pf+=$total_pf;
										$grand_esi=$total_esi+$grand_esi;
										$grand_sa=$side_allowance+$grand_sa;
										$grand_earn=$total_earning+$grand_earn;
										$grand_ded=$total_deductions+$grand_ded;
										$grand_net=$net_salary+$grand_net;
										}	
										}	
										?>
                                        <tr align="center" valign="middle">
                                            <td colspan="5" align="center">
                                                Total
                                            </td>
                                            <td>
                                                <?=$grand_days?>
                                                <br/>
                                                <?=round($grand_advance)?>
                                                <br/>
                                                <?=round($grand_fine)?>
                                            </td>
                                            <td>
                                                <?=round($grand_basic)?>
                                                <br/>
                                                <?=round($grand_loan)?>
                                                <br/>
                                                <?=round($grand_damage)?>
                                            </td>
                                             <td>
                                                <?=round($grand_lta)?>
                                                <br/>
                                                <?=round($grand_ptax)?>
                                                <br/>
                                                <?=round($grand_canteen)?>
                                            </td>
                                             <td>
                                                <?=round($grand_con)?>
                                                <br/>
                                                <?=round($grand_tds)?>
                                                <br/>
                                                <?=round($grand_society_fare)?>
                                            </td>
                                             <td>
                                                <?=round($grand_medical)?>
                                                 <br/>
                                                <?=round($grand_pf)?>
                                                 <br/>
                                                <?=round($grand_electrical)?>
                                            </td>
                                             <td>
                                                <?=round($grand_hra)?>
                                                 <br/>
                                                <?=round($grand_esi)?>
                                                 <br/>
                                                <?=round($grand_security)?>
                                            </td>
                                             <td>
                                                <?=round($grand_sa)?>
                                            </td>
                                             <td>
                                                <?=round($grand_earn)?>
                                                <br/>
                                                <?=round($grand_ded)?>
                                            </td>
                                             <td>
                                                <?=round($grand_net)?>
                                            </td>
                                       </tr>																 
                                </table>    
                            </td>
                       </tr> 
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
                   </table>                                    
        </td>
    </tr>
</table>
<script>
   window.print ();
 </script>