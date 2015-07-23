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
if(isset($_POST["department"]) and isset($_POST["sub_department"]) and isset($_POST["plant_name"]))
{
	if($_POST["department"]!="" and $_POST["sub_department"]=="")
		{	
		$select_string= "";
		$department=$_POST["department"];
		$table_list.= "";
		
		$where_string.="and reference_id='$department'";
		}
		if($_POST["sub_department"]!="")
		{
		$select_string= "";	
		$department=$_POST["department"];
		$sub_department=$_POST["sub_department"];
		$table_list.= "";
		
		$where_string.="and rec_id='$sub_department'";
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
	$sql_prj = "select * $select_string from mpc_department_master $table_list where mpc_department_master.rec_id!='' and reference_id!='0' $where_string";
	 
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
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
                	<td align="left">Wages Sheet Department Wise MONTH -<?=date("F",mktime(0, 0, 0,$month, 1, 0))?>,<?=$year?></td>
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
                                                    <td align="center"><b>Basic</b></td>
                                                    <td align="center"><b>LTA<br/>P.TAX</b></td>
                                                    <td align="center"><b>CONV<br/>TDS</b></td>
                                                    <td align="center"><b>MEDICAL<br/>PF</b></td>
                                                    <td align="center"><b>HRA<br/>E.S.I.</b></td>
                                                    <td align="center"><b>S/A<br/></b></td>
                                                    <td align="center"><b>Total Earning<br/>TOtal Deduction</b></td>
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
													
                                                    while($row=mysql_fetch_array($result_prj))
                                                    {		
                                                        
                                                    $dept_total_salary_basic=0;
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
                                                    
                                                     $sql = "SELECT * FROM mpc_department_employee where to_date='0000-00-00' and dept_id='".$row['rec_id']."'";
                                                     $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());

                                                    if(mysql_num_rows($result)>0)	
                                                        {
                                                                while($row_dept=mysql_fetch_array($result))
                                                                {
                                                                    $start_date="01";																											
                                                                    $total_salary_basic=0;
                                                                    $total_lta=0;
                                                                    $total_convence=0;
                                                                    $total_medical=0;
                                                                    $total_hra=0;
                                                                    $other_deductions=0; 	
                                                                    $side_allowance=0;
                                                                    $prof_tax=0;
                                                                    $tds=0;
                                                                    $total_pf=0;
                                                                    $total_esi=0;
                                                                    $start_date="01";
                                                                    
                                                                    $emp_id=$row_dept['emp_id'];
                                                                    
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
                                                                    if(getLeavestatusBydate($emp_id,$date1)=='P')
                                                                        {			
                                                                            getSalaryDetail("basic",$emp_id,$date1);				 
                                                                            $total_salary_basic=$total_salary_basic+(getSalaryDetail("basic",$emp_id,$date1)/$day2);
                                                                            $total_lta=$total_lta+(getSalaryDetail("leave_travel_allow",$emp_id,$date1)/$day2);
                                                                            $total_convence=$total_convence+(getSalaryDetail("convence",$emp_id,$date1)/$day2);	
                                                                            $total_medical=$total_medical+(getSalaryDetail("medical",$emp_id,$date1)/$day2);	
                                                                            
                                                                            $total_hra=$total_hra+(getSalaryDetail("hra",$emp_id,$date1)/$day2);	
                                                                            
                                                                            $side_allowance=$side_allowance +(getSalaryDetail("side_allowance",$emp_id,$date1)/$day2);								
                                                                            $other_deductions=$other_deductions +(getSalaryDetail("other_deductions",$emp_id,$date1)/$day2);											
                                                                        }
                                                                    
                                                                    $i++;
                                                                
                                                                    }
                                                                $total_earning=$total_salary_basic+$total_lta+$total_convence+$total_medical+$total_hra+$side_allowance;		
                                                
                                                                
                                                                $total_pf=($total_salary_basic*getAccountDetail('pf_rate',$emp_id))/100;
                                                                $total_esi=($total_earning*getAccountDetail('esic_rate',$emp_id))/100;
                                                                
                                                                $total_advance=getadvance($emp_id,$mm,$yy);
                                                                $total_loan=getloan($emp_id);
                                                                $prof_tax=getSalaryDetail("professional_tax",$emp_id,$date1);
                                                                $tds=getSalaryDetail("other_deductions",$emp_id,$date1);
                                                                
                                                                $total_deductions=$total_pf+$total_esi+$total_advance+$other_deductions+$prof_tax+$tds;
                                                                
                                                                $net_salary=$total_earning-$total_deductions;	
                                                                
                                                                
                                                                $dept_total_salary_basic=$dept_total_salary_basic+$total_salary_basic;
                                                                $dept_total_lta=$dept_total_lta+$total_lta;
                                                                $dept_total_convence=$dept_total_convence+$total_salary_basic;
                                                                $dept_total_medical=$dept_total_medical+$total_medical;
                                                                $dept_total_hra=$dept_total_hra+$total_hra;
                                                                $dept_side_allowance=$dept_side_allowance+$side_allowance;
                                                                $dept_total_salary_basic=$dept_total_salary_basic+$other_deductions;
                                                                
                                                                $dept_prof_tax=$dept_prof_tax+$prof_tax;
                                                                $dept_tds=$dept_tds+$tds;
                                                                $dept_total_pf=$dept_total_pf+$total_pf;
                                                                $dept_total_esi=$dept_total_esi+$total_esi;
                                                                $dept_total_deductions=$dept_total_deductions+$total_deductions;
                                                                $dept_total_earning=$dept_total_earning+$total_earning;
                                                                $dept_net=$dept_net+$net_salary;																		
                                                                            
                                                                }	
                                                                                                                                
                                                            }
                                                             
                                                                    
                                                    ?>
                                                   <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                    <td width="5%" align="center"><?=$sno?></td>
                                                    <td width="5%" align="center">
                                                    <?=$row['department_name']?><br/>
                                                    </td>
                                                    <td align="center"><?=round($dept_total_salary_basic,2)?></td>
                                                    <td>
                                                        <?=round($dept_total_lta,2)?>
                                                        <br/>
                                                        <?=round($dept_prof_tax,2)?>
                                                    </td>
                                                    <td>
                                                        <?=round($dept_total_convence,2)?>
                                                        <br/>
                                                        <?=round($dept_tds,2)?>
                                                    </td>
                                                    <td>
                                                        <?=round($dept_total_medical,2)?>
                                                        <br/>
                                                        <?=round($dept_total_pf,2)?>
                                                    </td>
                                                    <td>
                                                        <?=round($dept_total_hra,2)?>
                                                        <br/>
                                                        <?=round($dept_total_esi,2)?>
                                                    </td>
                                                    <td>
                                                        <?=round($dept_side_allowance,2)?>
                                                    </td>
                                                    <td>
                                                        <?=round($dept_total_earning,2)?>
                                                        <br/>
                                                        <?=round($dept_total_deductions,2)?>
                                                    </td>
                                                     <td>
                                                        <?=round($dept_net,2)?>
                                                    </td>
                                                    <td>&nbsp;
                                                        
                                                    </td>
                                                  </tr>
                                                    <?
														$grand_basic=$dept_total_salary_basic+$grand_basic;
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
                                                        $sno++;
                                                    }	
                                                    ?>	
                                                    <tr>
                                                        <td colspan="2">
                                                            Total
                                                        </td>
                                                        <td>
                                                            <?=round($grand_basic,2)?>
                                                        </td>
                                                         <td>
                                                            <?=round($grand_lta,2)?>
                                                            <br/>
                                                            <?=round($grand_ptax,2)?>
                                                        </td>
                                                         <td>
                                                            <?=round($grand_con,2)?>
                                                            <br/>
                                                            <?=round($grand_tds,2)?>
                                                        </td>
                                                         <td>
                                                            <?=round($grand_medical,2)?>
                                                             <br/>
                                                            <?=round($grand_pf,2)?>
                                                        </td>
                                                         <td>
                                                            <?=round($grand_hra,2)?>
                                                             <br/>
                                                            <?=round($grand_esi,2)?>
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
                                                            <?=round($grand_net,2)?>
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
 
