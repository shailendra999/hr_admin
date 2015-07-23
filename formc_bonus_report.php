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
if(isset($_POST["btn_submit_x"]) or isset($_GET['year']))
{			
	 $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving  $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id  and YEAR(mpc_official_detail.date_joining)<='$year' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string order by mpc_employee_master.ticket_no ASC";
	 
	//$query_count = "select count(*) as count from ".$mysql_table_prefix."employee_master";
	//$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	//$query_count = $query_count;
//	$result = mysql_query($query_count);
//	$row_count = mysql_fetch_array($result);
//	$numrows = $row_count['count'];
//	$count = ceil($numrows/$row_limit);
}
?>
<style>
select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>form-c bonus report</td>
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
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;" bgcolor="#f3fbd2">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="left">
                                                        <form name="frm_month" id="frm_month" action="" method="post">
                                                            <table align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                	<td align="left" class="text_1" style="text-align:left;">
                                                                    <?    
																	$sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from ".$mysql_table_prefix."attendence_master ";
																	$result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
																	$row_prd = mysql_fetch_array($result_prd);	
											 $min_year=2014;
																	 $max_year=2015;
                                                                        ?>
                                                                       Financial Year</td>
                                                                       <td align="left"> <select name="year" id="year" style="width:150px; height:25px;">
                                                                                <option value="">--select--</option>
                                                                                
                                                                            <? 
                                                                          for($i=$min_year;$i<=$max_year;$i++)
                                                                            {
                                                                            ?>
                                                                                <option value="<?=$i?>" <? if($i==$year)  { echo 'selected="selected"';}?>><?=$i?>-<?=$i+1;?>
                                                                                </option>
                                                                            <?
                                                                            }
                                                                            ?>
                                                                            </select> 
                                                                   	</td>
                                                                </tr>
                                                                 <tr> 
                                                                 	<td class="text_1" colspan="2">
                                                                    	Filter By:
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                	<td class="text_1">
                                                                    	 Emp Type</td>
                                                                         <td><select name="employee_type" id="employee_type">
                                                                         
                                                                         
                                                                          <option value="">---Select---</option>
                                                     <?php 
												$que=mysql_query("select type_name from mpc_employee_type_master");
												
												while($row=mysql_fetch_array($que))
												 {
												 ?>
                                                   <option value="<?php echo $row['type_name']?>" <?php if ($employee_type == $row['type_name']) {
                                                                                    echo 'selected="selected"';
                                                                                } ?> ><?php  echo $row['type_name'];  ?> </option>
										<?php } ?>
  						</select>
                                                                        		   
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1">
                                                                    	Emp ID</td>
                                                                        <td><input type="text" name="ticket_id" id="ticket_id" value="<?=$ticket_id?>" size="4"/>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1">
                                                                    	Department</td>
																		<td><?
																				 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
																				 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																				 ?>
																			<select name="department" id="department" style="width:150px; height:25px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
																				<option value="">Select</option>
																				 <?
																			  while ($row=mysql_fetch_array($result))
																				{	?>
																					   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$department){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
																				<?  }	?>
																			</select>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1">
                                                                    	Sub Department</td>
                                                                        <td>
                                                                         <div id="div_sub_dept">
																			
                                                                        <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                            <option value="">Select</option>
                                                           
                                                                        </select>
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1">
                                                                    	Plant</td>
																		<td><?
																			 $sql = "SELECT * FROM mpc_plant_master order by plant_name";
																			 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																			 ?>
																		<select name="plant_name" id="plant_name" style="width:150px; height:25px;">
																			<option value="">Select</option>
																			 <?
																		  while ($row=mysql_fetch_array($result))
																			{	?>
																				   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant_name){?> selected="selected" <? } ?>><?=$row["plant_name"]?></option>
																			<?  }	?>
																		</select>
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        	
                                                   <a href="javascript:;" onclick="document.location='formc_bonus_report.php';">
                                                    <img src="images/submit_button_Mahima.jpg" name="over" border="0"></a>
                                                                    </td>
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
                                                         	<form action="print_month_wise_attendance.php" method="post" name="frm_print" id="frm_print" target="_blank">
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
                                                   </tr> 
    <tr>
        <td align="center">
        <div id="div_attandance_list" style="overflow:scroll;height:500px;width:100%">
        <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
            <tr class="gredBg">
                <td width="5%" align="center"><b>S.No.</b></td>
                <td width="5%" align="center"><b>Employee Code</b></td>
                <td width="5%" align="center"><b>Department</b></td>
                <td width="5%" align="center"><b>Name of Employee's</b></td> 
                <td width="15%" align="center"><b>Father's Name</b></td>
                <td align="center">
                    <b>Whether he has completed years of age at the beginning of the accounting year<br/></b>
                </td>
                <td align="center"><b>Designation</b></td>
                <td align="center"><b>No.of days worked in the year</b></td>
                <td align="center"><b>Total salary of wages in respect of the accounting year</b></td>
                <td align="center"><b>Rate of Bonus</b></td>
                <td align="center"><b>Amount of Bonus payable under sec.1 C or sec 11 of the case may be</b></td>
                <td align="center"><b>Puja Bonus or other customary Bonus paid during paid year</b></td>
                <td align="center"><b>Interim bonus paid in advance</b></td>
                <td align="center"><b>Duduction on account of financial miscon-duct of the employee</b></td>
                <td align="center"><b>Total sum deducted(columns 09-10)</b></td>
                <td align="center"><b>Net Amount  payable(Columns 7-11)</b></td>
                <td align="center"><b>Amount Actually paid</b></td>
                <td align="center"><b>Date on which paid</b></td>
                <td align="center"><b>Signature</b></td>
                <td align="center"><b>Remarks</b></td>
    		</tr>
				<?
                while($row=mysql_fetch_array($result_prj))
                {
					$emp_id=$row['id'];														
					$month=4;
					$d=0;
					$total_salary_earing=0;
                for($k=1;$k<=12;$k++)
				{
						$total_salary_basic=0;
						$start_date="01";
						$day1 = $start_date; 
						$month_year = date("M/y", mktime(0, 0, 0,$month,$day1,$year));
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
								
								$total_salary_basic=$total_salary_basic+(getSalaryDetail("basic",$emp_id,$date1)/$day2);
							}
							
						$i++;
						$d++;
						}
				   $total_salary_earing=$total_salary_earing+$total_salary_basic;
				   $month++;
				   }
				   $total_bonus=($total_salary_earing*8.33)/100;
				 ?>
                  <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                    <td width="5%" align="center"><?=$sno?></td>
                    <td width="5%" align="center"><?=$row['ticket_no']?></td>
                    <td width="5%" align="center"></td>
                    <td width="5%" align="left">
                    <?=$row['first_name']?> <?=$row['last_name']?><br/>
                    </td>
                    <td>
                        <?
                            $current_date=date('Y-mm-dd');
                            $date2=$row['date_joining'];
                            $date_result=dateDifference($current_date,$date2);
                            if($date_result['years']>=15)
                            {
                                echo "YES";
                            }
                            else
                            {
                                echo "NO";
                            }
                        ?>
                    </td>
                    <td> <?=$d?> </td>
                    <td>
                        <?=round($total_salary_earing,2)?></td>
                    <td>8.33</td>
                    <td><?=round($total_bonus,2)?></td>
                    <td><?=round($total_bonus,2)?></td>
                    <td><?=round($total_bonus,2)?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
              </tr>
               <?
                    $sno++;
                }	
                ?>														 
                                                            </table>                                                             </div>  
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