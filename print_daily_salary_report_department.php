<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$msg ='';
$plant="";
$dep="";
$dept_id="";
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
else if(isset($_GET['month']))
{	
	$month =$_GET['month'];
}
else
{
	$month =date("m");
}
if(isset($_POST['print_year']))
{	
	 $year =$_POST['print_year'];
}	
else if(isset($_GET['year']))
{	
	$year =$_GET['year'];
}
else
{
	$year =date("Y");
}
$employee_type="";
$department="";
$sub_department="";
$plant_name="";
$ticket_id="";
$select_string= "";
$table_list= "";
$where_string="";
$where_string_filter="";
if(isset($_POST["print_department"]) and isset($_POST["print_sub_department"]) and isset($_POST["plant_name"]))
{
	if($_POST["print_department"]!="" and $_POST["print_sub_department"]=="")
		{	
		$select_string= "";
		$department=$_POST["print_department"];
		$table_list.= "";
		
		$where_string.="and reference_id='$department'";
		}
		if($_POST["print_sub_department"]!="")
		{
		$select_string= "";	
		$department=$_POST["print_department"];
		$sub_department=$_POST["print_sub_department"];
		$table_list.= "";
		
		$where_string.="and rec_id='$sub_department'";
		}
		if($_POST["print_plant_name"]!="")
		{	
		$select_string= ",mpc_plant_employee.*";
		$plant_name=$_POST["print_plant_name"];
		$table_list.= ",mpc_plant_employee";
		
		$where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
		}
	}

$sql_prj = "select * $select_string from mpc_department_master $table_list where mpc_department_master.rec_id!='' and reference_id!='0' $where_string";
 
$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
if((isset($_POST["print_employee_type"])!=""))
{	
	$select_string_filter=",mpc_designation_employee.*,mpc_designation_master.*";
	$employee_type=$_POST["print_employee_type"];
	$table_list_filter= ",mpc_designation_employee,mpc_designation_master";
	$where_string_filter.="and mpc_designation_employee.emp_id = mpc_department_employee.emp_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00' and mpc_designation_employee.emp_id!='0'";
}
$date_month=$year."-".$month."-01";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>      
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" >
            	<tr>
                	<td align="center">Laxyo Solution Soft Pvt. Ltd.</td>
                </tr>
                <tr>
                	<td align="left">Wages Sheet Department -<?=$_POST['txt_date_from']?>,<?=$_POST['txt_date_to']?></td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                                           <?  
                                            if(mysql_num_rows($result_prj)>0)
                                            {
                                            $sno = $start+1;
                                            ?>
                                       <tr>
                                            <td align="center">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0"  class="table1" border="1"> 
                                                  <tr class="gredBg">
                                                    <td width="5%" align="center"><b>S.No.</b></td>
                                                    <td width="5%" align="center"><b>Department Name.</b></td>
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
                                                    <td align="center"><b>Signature</b></td>
                                                  </tr>
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
														$total_grand_days=0;
                                                                while($row=mysql_fetch_array($result_prj))
                                                                {		
																	$dept_total_salary_basic_rate=0;	
																	$dept_total_house_rent_deduction=0;	
																	$dept_total_paid_days=0;
																	$dept_total_advance=0;	
																	$dept_total_fine=0;
																	$dept_total_loan=0;
																	$dept_total_salary_basic=0;
																	$dept_total_damage=0;
																	$dept_total_lta=0;
																	$dept_total_convence=0;
																	$dept_total_medical=0;
																	$dept_total_hra=0;
																	$dept_other_deductions=0; 	
																	$dept_side_allowance=0;
																	$dept_prof_tax=0;
																	$dept_tds=0;
																	$dept_total_pf=0;
																	$dept_total_esi=0;
																	$dept_total_deductions=0;
																	$dept_total_earning=0;
																	$dept_net=0;
																	$dept_total_canteen=0;
																	$dept_total_society_welfare=0;
																	$dept_total_electrical=0;
																	$dept_total_security=0;
																$sql = "SELECT * $select_string_filter FROM mpc_department_employee,mpc_account_detail,mpc_official_detail $table_list_filter where mpc_department_employee.to_date='0000-00-00' and dept_id='".$row['rec_id']."' and  mpc_department_employee.emp_id=mpc_account_detail.emp_id and  mpc_official_detail.emp_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string_filter";
																$result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																if(mysql_num_rows($result)>0)	
                													{
																			while($row_dept=mysql_fetch_array($result))
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
																				$Total=0;

																				$flag=0;
																				$grand_days=0;
																								
																				$emp_id=$row_dept['emp_id'];
																				
																				$employee_typ=getofficeDetail('employee_typ',$emp_id);
																				
																				$start_date =getdbDateSepretoe($_POST['txt_date_from']);
																				
																				$end_date = getdbDateSepretoe($_POST['txt_date_to']);
																				
																				$day1 = substr($_POST['txt_date_from'],0,2); 
																				$month1 = substr($_POST['txt_date_from'],3,2);
																				$year1 = substr($_POST['txt_date_from'],6,4);
																				
																				$day2 = substr($_POST['txt_date_to'],0,2); 
																				$month2 = substr($_POST['txt_date_to'],3,2);
																				$year2 = substr($_POST['txt_date_to'],6,4);
																				
																				//$day1 = $day1 + 1;
																				
																				
																				$date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
																				$date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
																				$difference = $date1-$date; //Calcuates Difference
																				
																				$daysago = floor($difference /60/60/24); //Calculates Days Old
																				
																				$i = 0;
																				while ($i <= $daysago) {
																				if ($i != 0) { $date = $date + 86400; }
																
																				$today = date('Y-m-d',$date);
																				//echo "$today ";
																				
																				$yy = date('Y',$date);
																				$mm = date('m',$date);
																				$dd = date('d',$date);
																				
																				$date1=$yy."-".$mm."-".$dd;
																				
																				$weekday = date("l", mktime(0,0,0,$mm,$dd,$yy));																
																				if(getweeklyoffDetail('off_day',$emp_id,$date1)==$weekday and $row_dept['employee_typ']!='daily_wages')
																				{						
																					$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
																					$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
																					$before_date=getLeavestatusBydate($emp_id,$date_before);
																					$after_date=getLeavestatusBydate($emp_id,$date_after);
																					if($before_date=='P' or $before_date=='OD' or $after_date=='P' or $after_date=='OD')
																					{
																						if($employee_typ!='daily_wages')
																						{
																							$Total++;
																							$flag=1;
																						}
																					}
																					else if(getHoliday('rec_id',$date_before)!="")
																						{
																							if(validate_weekoff_before($emp_id,$mm,$dd-1,$yy))
																							{
																								$Total++;
																								$flag=1;
																							}
																							else
																							{
																								$flag=1;
																								$wo++;
																								$Total++;
																								$leave_status='W';
																							}
																						}
																						else if(getHoliday('rec_id',$date_after)!="")
																						{
																							if(validate_weekoff_after($emp_id,$mm,$dd+1,$yy))
																							{
																								$Total++;
																								$flag=1;
																							}
																						}
																						else if($leave_status=="Pl"  and (validate_weekoff_after($emp_id,$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
																							{
																								$Total++;
																								$flag=1;
																							}
																						else if($leave_status=="Cl"  and (validate_weekoff_after($emp_id,$mm,$dd+1,$yy) or $after_date=="Pl" or $after_date=="Cl"))
																							{
																								$Total++;
																								$flag=1;
																							}
																				}
																				else if(getHoliday('rec_id',$date1)!="")
																				{
																					$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
																					$date_after=date('Y-m-d',mktime(0,0,0,$mm,$dd+1,$yy));
																					$before_date=getLeavestatusBydate($emp_id,$date_before);
																					$after_date=getLeavestatusBydate($emp_id,$date_after);
																					
																					if($before_date=='Cl')
																					{
																						$i_before = 1;
																						do
																						{
																							$date_before=date('Y-m-d',mktime(0,0,0,$mm,$dd-$i_before,$yy));
																							
																							$before_date=getLeavestatusBydate($emp_id,$date_before);
																							$i_before++;
																							
																							//echo $date_before." : ".$i_before;
																							//$before_date = 
																						}while($before_date=='Cl');
																					}
																					
																					if($before_date=='P' or $before_date=='OD' or $after_date=='P' or $after_date=='OD')
																					{
																						$Total++;
																						$flag=1;
																					}
																					else if($before_date=='W')
																					{
																						$before_date2=date('Y-m-d',mktime(0,0,0,$mm,$dd-1,$yy));
																						$before_date2=getLeavestatusBydate($emp_id,$before_date2);
																						if($before_date2=='P' or $before_date2=='OD')
																						{
																							$Total++;
																							$flag=1;
																						}
																					}
																					else if($after_date=='W')
																					{
																						$after_date2=date('Y-m-d',mktime(0,0,0,$mm,$dd-2,$yy));
																						$after_date2=getLeavestatusBydate($emp_id,$after_date2);
																						if($after_date2=='P' or $after_date2=='OD')
																						{
																							$Total++;
																							$flag=1;
																						}
																					}
																				}
																				else
																				{
																					$leave_status = getLeavestatusBydate($emp_id,$date1);
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
																						if($employee_typ=='daily_wages')
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
																						if($employee_typ=='daily_wages')
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
																				
																				$result_fine = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
																				if(mysql_num_rows($result_fine)>0)
																				{
																					$row_salary_deduction=mysql_fetch_array($result_fine);
																				}
																			
																			$total_esi=ceil("$total_esi");
																				
																				
																			$total_deductions=round($total_pf)+$total_esi+$total_advance+$other_deductions+$prof_tax+$tds+$total_loan+$monthDeduction;
																				
																			$net_salary=$total_earning-$total_deductions;
																			$grand_days=$grand_days+$Total;
																			
																			$dept_total_salary_basic=$dept_total_salary_basic+$total_salary_basic;
																			$dept_total_salary_basic_rate=$dept_total_salary_basic_rate+$basic_rate;
																			$dept_total_house_rent_deduction=$dept_total_house_rent_deduction+$row_salary_deduction['salary_house_rent'];
																			$dept_total_paid_days=$dept_total_paid_days+$Total;
																			$dept_total_advance=$dept_total_advance+$total_advance;
																			$dept_total_fine=$dept_total_fine+$row_salary_deduction['salary_fine'];
																			
																			$dept_total_loan=$dept_total_loan+$total_loan;
																			$dept_total_damage=$dept_total_damage+$row_salary_deduction['salary_damage'];
																			$dept_total_canteen=$dept_total_canteen+$row_salary_deduction['salary_canteen'];
																			$dept_total_lta=$dept_total_lta+$total_lta;
																			$dept_total_convence=$dept_total_convence+$total_convence;
																			$dept_total_medical=$dept_total_medical+$total_medical;
																			$dept_total_hra=$dept_total_hra+$total_hra;
																			$dept_side_allowance=$dept_side_allowance+$side_allowance;
																			
																			$dept_other_deductions=$dept_other_deductions+$other_deductions;
																			
																			$dept_prof_tax=$dept_prof_tax+$prof_tax;
																			$dept_tds=$dept_tds+$tds;
																			$dept_total_pf=$dept_total_pf+round($total_pf);
																			$dept_total_electrical=$dept_total_electrical+$row_salary_deduction['salary_electrical'];
																			$dept_total_esi=$dept_total_esi+$total_esi;
																			$dept_total_deductions=$dept_total_deductions+$total_deductions;
																			$dept_total_earning=$dept_total_earning+$total_earning;
																			$dept_net=$dept_net+$net_salary;	
																			
																			$dept_total_society_welfare=$dept_total_society_welfare+$row_salary_deduction['salary_society_welfare'];																	
																			$dept_total_security=$dept_total_security+$row_salary_deduction['salarly_security'];	
																			
																				
																			}																      	
																?>
                                                               <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                <td width="5%" align="center"><?=$sno?></td>
                                                                <td width="5%" align="center">
																<?=$row['department_name']?>(<?=mysql_num_rows($result)?>)<br/>                                                                </td>
                                                                <td align="center"><?=round($dept_total_salary_basic_rate)?>
                                                                <br/>
																	<?=round($dept_total_house_rent_deduction)?></td>
                                                          <td>
                                                                	<?=round($dept_total_paid_days)?>
                                                                    <br/>
                                                                    <?=round($dept_total_advance)?>
                                                                    <br/>
                                                                    <?=round($dept_total_fine)?>                                                                </td>
                                                                <td>
                                                                	<?=round($dept_total_salary_basic)?>
                                                                    <br/>
                                                                    <?=round($dept_total_loan)?>
                                                                    <br/>
                                                                    <?=round($dept_total_damage)?>                                                                </td>
                                                                <td>
                                                                	<?=round($dept_total_lta)?>
                                                                    <br/>
                                                                    <?=round($dept_prof_tax)?>
                                                                    <br/>
                                                                    <?=round($dept_total_canteen)?>                                                                </td>
                                                                <td>
                                                                	<?=round($dept_total_convence)?>
                                                                    <br/>
                                                                    <?=round($dept_tds)?>
                                                                    <br/>
                                                                    <?=round($dept_total_society_welfare)?>                                                                </td>
                                                                <td>
                                                                	<?=round($dept_total_medical)?>
                                                                    <br/>
                                                                    <?=round($dept_total_pf)?>
                                                                    <br/>
                                                                    <?=round($dept_total_electrical)?>                                                                </td>
                                                                 <td>
                                                                	<?=round($dept_total_hra)?>
                                                                    <br/>
                                                                    <?=round($dept_total_esi)?>
                                                                    <br/>
                                                                    <?=round($dept_total_security)?>                                                                </td>
                                                          <td>
                                                                	<?=round($dept_side_allowance)?>
                                                                    <br/>
                                                                    <?=round($dept_other_deductions)?>                                                                </td>
                                                                <td>
                                                                	<?=round($dept_total_earning)?>
                                                                    <br/>
                                                                    <?=round($dept_total_deductions)?>                                                                </td>
                                                              <td>
                                                                	<?=round($dept_net)?>                                                             
                                                               </td>
                                                               <td>                                                               
                                                               </td>                                                            
                                                           </tr>
                                                                <?
																	$sno++;
																	$grand_basic=$dept_total_salary_basic_rate+$grand_basic;
																	$grand_advance=$grand_advance+$dept_total_advance;
																	$grand_fine=$dept_total_fine+$grand_fine;
																	$grand_loan=$dept_total_loan+$grand_loan;
																	$grand_damage=$dept_total_damage+$grand_damage;
																	$grand_canteen=$dept_total_canteen+$grand_canteen;
																	$grand_society_fare=$dept_total_society_welfare+$grand_society_fare;
																	$grand_electrical=$dept_total_electrical+$grand_electrical;
																	$grand_security=$dept_total_security+$grand_security;
																	
																	$grand_lta=$dept_total_lta+$grand_lta;
																	$grand_hra=$dept_total_hra+$grand_hra;
																	$grand_ptax=$dept_prof_tax+$grand_ptax;
																	$grand_con=$dept_total_convence+$grand_con;
																	$grand_tds=$dept_tds+$grand_tds;
																	$grand_medical=$dept_total_medical+$grand_medical;
																	$grand_pf=$dept_total_pf+$grand_pf;
																	$grand_esi=$dept_total_esi+$grand_esi;
																	$grand_sa=$dept_side_allowance+$grand_sa;
																	$grand_earn=$dept_total_earning+$grand_earn;
																	$grand_ded=$dept_total_deductions+$grand_ded;
																	$grand_net=$dept_net+$grand_net;
																	$total_grand_days=$grand_days+$total_grand_days;
																}	
															}
																?>	
                                                                 <tr align="center" valign="middle">
                                                                <td colspan="3" align="center">
                                                                    Total
                                                                </td>
                                                               	<td>
                                                                    <?=$total_grand_days?>
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
                                                                    <?=floor($grand_esi)?>
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
                                                 </div>  
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
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<script>
   window.print ();
 </script>
 
