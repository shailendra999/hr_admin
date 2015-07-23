<?
$id="";
$emp_id = $_GET["id"];
$year = $_GET["str"];
$year = intval($year); 
include("inc/dbconnection.php");
include("inc/function.php");
$date_month=date('Y')."-".date('m')."-01";
?>
<table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
	<tr>
    	<td align="center" colspan="3">
        	<h3>FORM-18</h3>
            (Prescribed Under Rule 102)
            <h3>Register Of Leave With Wages</h3>
        </td>
        <td>
        	<form action="print_yearly_leave_register.php" method="post" name="frm_print" id="frm_print" target="_blank">
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
                    	FULL NAME
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
                <tr>
                	<td>
                    	DATE OF DISCHARGE
                    </td>
                    <td>
                    	:<?=getDatetime(getAccountDetail('date_releaving',$emp_id))?>
                    </td>
                </tr>
            </table>
        </td>
        <td>
        	DESIGNATION :<?=getdesignationMaster('designation_name','rec_id',getdesignationDetail('designation_id',$emp_id,$date_month));?>
        </td>
        <td>
        	DEPARTMENT:</td><td><?=getdeptDetail('department_name','rec_id',getdepartmentDetail('dept_id',$emp_id,$date_month));?>
        </td>
    </tr>
	<tr>
    	<td colspan="4">
            <table border="1" width="100%">
              <tr>
                <td rowspan="2">Month</td>
                <td rowspan="2">No. of <br/>Working Days</td>
                <td rowspan="2">No of Days <br/>Work Performed</td>
                <td rowspan="2">Wage Rate</td>
                <!--<td rowspan="2">No.of Days Maternity Leave With Wage</td>
                <td rowspan="2">No. Of Days Layoff</td>-->
                <td colspan="3">PREVILAGE EARNED LEAVE</td>
                <td colspan="3">CASUAL LEAVE</td>
                <td rowspan="2">Total Paid <br/>Leave</td>
              </tr>
              <tr>
                <td>From</td>
                <td>To</td>
                <td>No. of Days</td>
                <td >From</td>
                <td>To</td>
                <td>No. of Days</td>
              </tr>
              <tr>
                <td colspan="3">Balance From the preceed year</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">Credit for the current year</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">Total leave to credit</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <?
			  	for($i=1;$i<=12;$i++)
				{
			  ?>
              	<tr>
                	<td><?=date("F", mktime(0, 0, 0, $i+1, 0, 0, 0));?></td>
                    <td><?=$month_days=date("t", strtotime($year. "-" .$i. "-01"));?></td>
                    <td><?=$no_present=getleavecountMonthly($emp_id,"P",$i,$year)?></td>
                	<td><? if($i<=date('m'))
						    {
							$total_month=0;
							for($j=1;$j<=$month_days;$j++)
							{

								$date = mktime(0,0,0,$i,$j,$year);
								$dd = date('d',$date);
								$salary_ann = getSalaryDetail("basic",$emp_id,$year.'-'.$i.'-'.$dd);
								if(getofficeDetail('employee_typ',$emp_id)=='daily_wages')
								{
									$per_day=($salary_ann)/$month_days;
								}
								else
								{
									$per_day=$salary_ann/$month_days;
								}
								

								$total_month=$total_month+$per_day;
							}
							$total_month =round($total_month,2);
							echo round(($no_present*$total_month)/$month_days);
						}
						?>
                    </td>
                    <!--<td>&nbsp;</td>
                    <td>&nbsp;</td>-->
                    <td colspan="2"><? 	 
										if($i<=date('m'))
										{	$k=0;
											$temp = "";
											$temp2="";
											$to_date = "";
											$from_date = "";
											$total_pl=0;
											for($j=1;$j<=$month_days;$j++)
											{
												$date = mktime(0,0,0,$i,$j,$year);
												$dd = date('d',$date);
												$mm = date('m',$date);
												$date=$year."-".$mm."-".$dd; 
												$check=PLeave($emp_id,$date,'PL');											
												if($check!="")
												{
													$k++;
													if($temp=="")
													{		
														$from_date = $check;												
														$temp = $check;
													}	
													else if($temp2!="")
													{
														$to_date = $check;													
													}												
												}
											  
											   else if($temp!="" and $temp2!="")
														{
															if($k==1)
																{
																	$to_date=$from_date;
																}
															echo getDatetime($from_date)." to ".getDatetime($to_date);
															$total_pl=$total_pl+(dateDiffDB("-",$to_date,$from_date))+1;
															echo "<br/>";
															echo "<br/>";
															$temp = "";
															$temp2 = "";
															$k=0;													
														}
														else
														{
														  $temp2="0";
														}					
											}
										}
						?>
                        </td>
                    <td><?=$total_pl?></td>
                     <td colspan="2"><? 	 
										if($i<=date('m'))
										{	$k=0;
											$temp = "";
											$temp2="";
											$to_date = "";
											$from_date = "";
											$total_cl=0;
											for($j=1;$j<=$month_days;$j++)
											{
												$date = mktime(0,0,0,$i,$j,$year);
												$dd = date('d',$date);
												$mm = date('m',$date);
												$date=$year."-".$mm."-".$dd; 
												$check=PLeave($emp_id,$date,'CL');											
												if($check!="")
												{
													$k++;
													if($temp=="")
													{		
														$from_date = $check;												
														$temp = $check;
													}	
													else if($temp2!="")
													{
														$to_date = $check;													
													}												
												}
											  
											   else if($temp!="" and $temp2!="")
														{
															if($k==1)
																{
																	$to_date=$from_date;
																}
															echo getDatetime($from_date)." to ".getDatetime($to_date);
															$total_cl=$total_cl+(dateDiffDB("-",$to_date,$from_date))+1;
															echo "<br/>";
															$temp = "";
															$temp2 = "";
															$k=0;													
														}
														else
														{
														  $temp2="0";
														}					
											}
										}
						?>
                        </td>
                    <td><?=$total_cl?></td>
                    <td><? $wage_days=$total_cl+$total_pl ;
						  echo $wage_days;				
					?>&nbsp;</td>
                </tr>
              <?
			  	}
			  ?>
            </table>
        </td>
	</tr>
</table>