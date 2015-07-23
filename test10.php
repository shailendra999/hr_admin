<? include ("inc/hr_header.php"); ?>
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
if(isset($_POST['month']))
{	
	 $month =$_POST['month'];
}	
else if(isset($_GET['month']))
{	
	$month =$_GET['month'];
}
else
{
	$month =date("m");
}
if(isset($_POST['year']))
{	
	 $year =$_POST['year'];
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
if(isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
and isset($_POST["plant_name"]))
	{
	if(($_POST["employee_type"]!=""))
		{	
		$select_string=",mpc_designation_employee.*,mpc_designation_master.*";
		$employee_type=$_POST["employee_type"];
		$table_list= ",mpc_designation_employee,mpc_designation_master";
		$where_string.="and mpc_designation_employee.emp_id =mpc_employee_master.rec_id and mpc_designation_employee.designation_id=mpc_designation_master.rec_id and mpc_designation_master.emp_category='$employee_type' and mpc_designation_employee.to_date='0000-00-00'";
	    }
	if($_POST["ticket_id"]!="")
		{
		$select_string= "";
		$ticket_id=$_POST["ticket_id"];
		$table_list.= "";
		$where_string.="and mpc_employee_master.ticket_no ='$ticket_id'";
		}
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
		if($_POST["plant_name"]!="")
		{	
		$select_string= ",mpc_plant_employee.*";
		$plant_name=$_POST["plant_name"];
		$table_list.= ",mpc_plant_employee";
		
		$where_string.="and mpc_plant_employee.emp_id =mpc_employee_master.rec_id and mpc_plant_employee.plant_id ='$plant_name' and mpc_plant_employee.to_date='0000-00-00'";
		}
	}
if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
{			
	 $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
}
$date_month=$year."-".$month."-01";
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Wages Sheet</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                         </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="40%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="center">
                                                        <form name="frm_month" id="frm_month" action="" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                	<td colspan="8">
                                                                    <table align="center">
                                                                    	<tr>                                                                  
                                                                    <td align="center" class="text_1"><b>Year</b></td>
                                                                    <td align="center">
                                                                   <?    
                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from ".$mysql_table_prefix."attendence_master ";
                                                                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
																		$row_prd = mysql_fetch_array($result_prd);	
																		 $min_year=substr($row_prd["MINDATE"],0,4);
																		 $max_year=substr($row_prd["MAXDATE"],0,4);
                                                                        ?>    
                                                                            <select name="year" id="year" style="width:150px; height:20px;" onchange="get_frm('get_month.php',this.value,'div_month','');">
                                                                                <option value="">--select--</option>
                                                                                
                                                                            <? 
                                                                          for($i=$min_year;$i<=$max_year;$i++)
                                                                            {
                                                                            ?>
                                                                                <option value="<?=$i?>" <? if($i==$year)  { echo 'selected="selected"';}?>><?=$i?>
                                                                                </option>
                                                                            <?
                                                                            }
                                                                            ?>
                                                                            </select>                                                                    </td>
                                                                                                                                        <td align="left" class="text_1"><b>Month</b></td>
                                                                    <td align="left">
                                                                    <div id="div_month">
                                                                    <select id="month" name="month" style="width:150px; height:20px;">
                                                                        <?
																		 for($i=01;$i<=$month;$i++)
																		 {
																		   $j=sprintf("%02d",$i);
																		 ?>
                                                                          <option value="<?=$j?>" <? if($j==$month)  { echo 'selected="selected"';}?>><?=date("F",mktime(0, 0, 0,$i, 1, 0))?></option>
                                                                          <?
                                                                          }
																		  ?>
                                                                    </select>
                                                                    </div>                                                                    </td>
                                                                    </tr>
                                                                    </table>                                                                    </td>
                                                                </tr>
                                                                 <tr> 
                                                                 	<td class="text_1">
                                                                    	Filter By:                                                                    </td>
                                                                	<td class="text_1">
                                                                    	 Emp Type<select name="employee_type" id="employee_type">
                                                                                    <option value="">Select</option>
                                                                                    <option value="Staff" <? if($employee_type=='Staff'){echo 'selected="selected"';}?> >Staff</option>
                                                                                    <option value="Worker" <? if($employee_type=='Worker'){echo 'selected="selected"';}?>>Worker</option>
                                                                                </select>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Emp ID <input type="text" name="ticket_id" id="ticket_id" value="<?=$ticket_id?>" size="4"/>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Department<?
																				 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
																				 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																				 ?>
																			<select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
																				<option value="">Select</option>
																				 <?
																			  while ($row=mysql_fetch_array($result))
																				{	?>
																					   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$department){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
																				<?  }	?>
																			</select>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Sub Department
                                                                         <div id="div_sub_dept">
                                                                        <select name="sub_department" id="sub_department" style="width:150px; height:20px;" onchange="">
                                                                          <option value="">Select</option> 
                                                                        </select>
                                                                        </div>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Plant<?
																			 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
																			 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																			 ?>
																		<select name="plant_name" id="plant_name" style="width:150px; height:20px;">
																			<option value="">Select</option>
																			 <?
																		  while ($row=mysql_fetch_array($result))
																			{	?>
																				   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant_name){?> selected="selected" <? } ?>><?=$row["plant_name"]?></option>
																			<?  }	?>
																		</select>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	OT
                                                                        <input type="checkbox" name="over_time" id="over_time"/>                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        <a href="javascript:;" onclick="document.location='salary_report_employee.php';"><img src="images/submit_button_Mahima.jpg" name="over" border="0"></a></td>
                                                                </tr>     
                                                            </table>
                                                          </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #E4E4E4;">
                                                       <?  
                                                    if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
                                                        {
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                        $sno = $start+1;
                                                        ?>
                                                   <tr>
                                                  		 <td align="right">
                                                         	<table cellpadding="0" cellspacing="0" border="0">
                                                            	<tr>
                                                                	<td>
                                                                        <form action="print_month_wise_salary_report.php" method="post" name="frm_print" id="frm_print" target="_blank">
                                                                            <input type="hidden" name="print_month" id="print_month" value="<?=$month?>"/>
                                                                            <input type="hidden" name="print_year" id="print_year" value="<?=$year?>"/>
                                                                            <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?=$employee_type?>"/>
                                                                            <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?=$ticket_id?>"/>
                                                                            <input type="hidden" name="print_department" id="print_department" value="<?=$department?>"/>
                                                                            <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?=$sub_department?>"/>
                                                                            <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?=$plant_name?>"/>
                                                                            <input type="image" src="images/btn_print.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        </form>
                                                                            </td>
                                                                            <td valign="top">
                                                                        <form action="month_wise_salary_report_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
                                                                            <input type="hidden" name="print_month" id="print_month" value="<?=$month?>"/>
                                                                            <input type="hidden" name="print_year" id="print_year" value="<?=$year?>"/>
                                                                            <input type="hidden" name="print_employee_type" id="print_employee_type" value="<?=$employee_type?>"/>
                                                                            <input type="hidden" name="print_ticket_id" id="print_ticket_id" value="<?=$ticket_id?>"/>
                                                                            <input type="hidden" name="print_department" id="print_department" value="<?=$department?>"/>
                                                                            <input type="hidden" name="print_sub_department" id="print_sub_department" value="<?=$sub_department?>"/>
                                                                            <input type="hidden" name="print_plant_name" id="print_plant_name" value="<?=$plant_name?>"/>
            
                                                                        </form>
                                                                        <a href="javascript:;" onclick="frm_print_xls.submit()" class="AddMore" >Export To XLS</a>  
                                                         </td>
                                                         </tr>
                                                         </table>
                                                         </td>
                                                   </tr> 
                                                   <tr>
                                                        <td align="center">
                                                      <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                              <tr class="gredBg">
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
																echo $total_salary_basic."+".$total_lta."+".$total_convence."+".$total_medical."+".$total_hra."+".$side_allowance;
																echo "<br>";
																
																
																echo ceil($total_salary_basic)."+".ceil($total_lta)."+".ceil($total_convence)."+".ceil($total_medical)."+".ceil($total_hra)."+".ceil($side_allowance);
																echo "<br>";
																
																echo ceil($total_earning);
																
																
																
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
																
																
																$total_deductions=round($total_pf)+$total_esi+$total_advance+$other_deductions+$prof_tax+$tds+$total_loan+$monthDeduction;
																
																$net_salary=$total_earning-$total_deductions;
																$grand_days=$grand_days+$Total;
																?>
                                                               <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
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
                                                                	<?=round($total_salary_basic,2)?>
                                                                    <br/>
                                                                    <?=round($total_loan,2)?>
                                                                    <br/> <?=$row_salary_deduction['salary_damage']?>
                                                                </td>
                                                                <td align="center">
                                                                	<?=round($total_lta,2)?>
                                                                    <br/>
                                                                    <?=round($prof_tax,2)?>
                                                                    <br/> <?=$row_salary_deduction['salary_canteen']?>
                                                                </td>
                                                                <td align="center">
                                                                	<?=round($total_convence,2)?>
                                                                    <br/>
                                                                    <?=round($tds,2)?>
                                                                    <br/> <?=$row_salary_deduction['salary_society_welfare']?>
                                                                </td>
                                                                <td align="center">
                                                                	<?=round($total_medical,2)?>
                                                                    <br/>
                                                                    <?=round($total_pf)?>
                                                                    <br/> <?=$row_salary_deduction['salary_electrical']?>
                                                                </td>
                                                                <td align="center">
                                                                	<?=round($total_hra,2)?>
                                                                    <br/>
                                                                    <?=floor($total_esi)?>
                                                                    <br/> <?=$row_salary_deduction['salarly_security']?>
                                                                </td>
                                                                <td align="center">
                                                                	<?=round($side_allowance,2)?>
                                                 					 <br/>
                                                                    <?=round($other_deductions,2)?>          
																</td>
                                                                <td align="center">
                                                                	<?=round($total_earning,2)?>
                                                                    <br/>
                                                                    <?=round($total_deductions,2)?>
                                                                </td>
                                                                 <td align="center">
                                                                	<?=round($net_salary);?>
                                                                </td>
                                                                <td>
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
																$grand_hra=$total_hra+$grand_hra;
																$grand_ptax=$prof_tax+$grand_ptax;
																$grand_con=$total_convence+$grand_con;
																$grand_tds=$tds+$grand_tds;
																$grand_medical=$total_medical+$grand_medical;
																$grand_pf=$total_pf+$grand_pf;
																$grand_esi=$total_esi+$grand_esi;
																$grand_sa=$side_allowance+$grand_sa;
																$grand_earn=$total_earning+$grand_earn;
																$grand_ded=$total_deductions+$grand_ded;
																$grand_net=$net_salary+$grand_net;
																	
																}	
																?>
                                                            <tr align="center" valign="middle">
                                                                <td colspan="5" align="center">
                                                                    Total
                                                                </td>
                                                               	<td>
                                                                    <?=$grand_days?>
                                                                    <br/>
                                                                    <?=round($grand_advance,2)?>
                                                                    <br/>
                                                                    <?=round($grand_fine,2)?>
                                                                </td>
                                                                <td>
                                                                    <?=round($grand_basic,2)?>
                                                                    <br/>
                                                                    <?=round($grand_loan,2)?>
                                                                    <br/>
                                                                    <?=round($grand_damage,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_lta,2)?>
                                                                    <br/>
                                                                    <?=round($grand_ptax,2)?>
                                                                    <br/>
                                                                    <?=round($grand_canteen,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_con,2)?>
                                                                    <br/>
                                                                    <?=round($grand_tds,2)?>
                                                                    <br/>
                                                                    <?=round($grand_society_fare,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_medical,2)?>
                                                                     <br/>
                                                                    <?=round($grand_pf)?>
                                                                     <br/>
                                                                    <?=round($grand_electrical,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_hra,2)?>
                                                                     <br/>
                                                                    <?=floor($grand_esi)?>
                                                                     <br/>
                                                                    <?=round($grand_security,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_sa,2)?>
                                                                </td>
                                                                 <td>
                                                                    <?=round($grand_earn,2)?>
                                                                    <br/>
                                                                    <?=round($grand_ded,2)?>
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
                                                    } 
                                                      ?>          	
                                               </table>
                                          </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                        </table> 
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>   
<? include ("inc/hr_footer.php"); ?>