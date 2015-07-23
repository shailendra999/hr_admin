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
$shift_detail="";
if(isset($_POST["employee_type"]) and isset($_POST["ticket_id"]) and isset($_POST["department"]) and isset($_POST["sub_department"])
and isset($_POST["plant_name"]) and isset($_POST["shift_detail"]))
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
	if($_POST["shift_detail"]!="")
	{
		$select_string= ",mpc_shift_detail.shift";
		$shift_detail=$_POST["shift_detail"];
		$table_list.= ",mpc_shift_detail";
		$where_string.=" and mpc_shift_detail.emp_id =mpc_employee_master.rec_id and mpc_shift_detail.shift ='$shift_detail' and mpc_shift_detail.to_date='0000-00-00'";
	}
}
if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
{			
	 $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_official_detail.employee_typ,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id,mpc_account_detail.emp_id,mpc_account_detail.date_releaving $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' $where_string  order by ticket_no ASC";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
}
$date_month=$year."-".$month."-01";
?>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script LANGUAGE="JavaScript">
function marcarTodos(){
if(document.frm_chech_emp.master.checked==true)
{
  for (i=0; i<document.frm_chech_emp.elements.length;i++)
   {
	if(document.frm_chech_emp.elements[i].type=='checkbox')
	{
	  document.frm_chech_emp.elements[i].checked=true;
	}
   }
}
else{
 	for (i=0; i<document.frm_chech_emp.elements.length;i++)
  		 {
			if(document.frm_chech_emp.elements[i].type=='checkbox')
				{
				 document.frm_chech_emp.elements[i].checked=false
				}
    	 }
	}
}
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Attendence Card</td>
                </tr>
                <tr>
                	<td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red" style="padding:3px;"><?=$msg?></td>
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
                                                                    <td align="left" class="text_1"><b>Month</b></td>
                                                                    <td align="center">
                                                                    <select id="month" name="month" style="width:150px; height:25px;">
                                                                        <option value="01" <? if("01"==$month)  { echo 'selected="selected"';}?>>January</option>
                                                                        <option value="02" <? if("02"==$month)  { echo 'selected="selected"';}?>>February</option>
                                                                        <option value="03" <? if("03"==$month)  { echo 'selected="selected"';}?>>March</option>
                                                                        <option value="04" <? if("04"==$month)  { echo 'selected="selected"';}?>>April</option>
                                                                        <option value="05" <? if("05"==$month)  { echo 'selected="selected"';}?>>May </option>
                                                                        <option value="06" <? if("06"==$month)  { echo 'selected="selected"';}?>>June</option>
                                                                        <option value="07" <? if("07"==$month)  { echo 'selected="selected"';}?>>July</option>
                                                                        <option value="08" <? if("08"==$month)  { echo 'selected="selected"';}?>>August</option>
                                                                        <option value="09" <? if("09"==$month)  { echo 'selected="selected"';}?>>September</option>
                                                                        <option value="10" <? if("10"==$month)  { echo 'selected="selected"';}?>>October </option>
                                                                        <option value="11"<? if("11"==$month)  { echo 'selected="selected"';}?>>November</option>
                                                                        <option value="12" <? if("12"==$month)  { echo 'selected="selected"';}?>>December</option>
                                                                    </select>        						
                                                                    </td>
                                                                    <td align="center" class="text_1"><b>Year</b></td>
                                                                    <td align="center">
                                                                   		<?    
                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from ".$mysql_table_prefix."attendence_master ";
                                                                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
																		$row_prd = mysql_fetch_array($result_prd);	
																		 $min_year=substr($row_prd["MINDATE"],0,4);
																		 $max_year=substr($row_prd["MAXDATE"],0,4)+1;
                                                                        ?>    
                                                                            <select name="year" id="year" style="width:150px; height:25px;">
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
                                                                            </select>         						
                                                                   		 </td>
                                                                   		</tr>
                                                                      </table>
                                                                     </td>
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
                                                                    	Emp ID <input type="text" name="ticket_id" id="ticket_id" value="<?=$ticket_id?>" size="4"/>                                            </td>
                                                                    <td class="text_1">
                                                                    	Shift
                                                                    <select name="shift_detail" id="shift_detail">
                                                                        <option value="">---Select---</option>
                                                                        <option value="A" <? if($shift_detail=='A'){ echo 'selected="selected"';} ?>>A</option>
                                                                        <option value="B" <? if($shift_detail=='B'){ echo 'selected="selected"';} ?>>B</option>
                                                                        <option value="C" <? if($shift_detail=='C'){ echo 'selected="selected"';} ?>>C</option>
                                                                        <option value="G" <? if($shift_detail=='G'){ echo 'selected="selected"';} ?>>G</option>
                                                                    </select>                                            						</td>
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
                                                                        <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                          <option value="">Select</option> 
                                                                        </select>
                                                                        </div>                                                                    </td>
                                                                    <td class="text_1">
                                                                    	Plant<?
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
																		</select>                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        <a href="javascript:;" onclick="document.location='attendance_card.php';"><img src="images/submit_button_Mahima.jpg" name="over" border="0"></a></td>
                                                                </tr>     
                                                            </table>
                                                          </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                         <?  
									if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
										{
										?>
                                        <tr>
                                        	<td align="center">
                                            	<a href="javascript:;" onClick="return hs.htmlExpand(this)" class="links">View Sample</a>
                                            	<div class="highslide-maincontent">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                                                    <tr>
                                                    	<td>
                                                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            	<tr>
                                                                	<td align="center" class="blackHead"  style="text-align:center;">
                                                        				Attendence Card
                                                        			</td>
                                                                </tr>
                                                          </table>        
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                       		 <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            	<tr>
                                                                   <td class="text_1" width="15%">Month</td>
                                                                   <td class="text_1" style="border-bottom:1px solid #333333; width:125px;">&nbsp;</td>
                                                                   <td class="text_1" width="15%">Shift</td>
                                                                   <td class="text_1" style="border-bottom:1px solid #333333; width:125px;">&nbsp;</td>
                                                                </tr>
                                                         	 </table>
                                                         </td>
                                                    </tr>
                                                		
                                                    <tr>	
                                                    	<td>
                                                        	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            	<tr>
                                                                	  <td class="text_1" width="15%">Name</td>
                                                       				 <td colspan="3" style="border-bottom:1px solid #333333; width:300px;">&nbsp;</td>     
                                                                </tr>
                                                          </table>   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                            <td>
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr>
                                                                       <td class="text_1" width="20%">Father's Name</td>
                                                                     <td  style="border-bottom:1px solid #333333; width:300px;">&nbsp;</td>
                                                                    </tr>
                                                              </table>   
                                                          </td>
                                                    </tr>
                                                    <tr>
                                                    	 <td>
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td class="text_1" width="15%">Card No.</td>
                                                                    <td style="border-bottom:1px solid #333333;">&nbsp;</td>
                                                                    <td class="text_1" width="20%">Department</td>
                                                                    <td style="border-bottom:1px solid #333333;">&nbsp;</td>
                                                                </tr>
                                                          </table>   
                                                          </td>                                                               
                                                    </tr>
                                                    <tr>
                                                  		  <td>
                                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                    <tr>
                                                                        <td class="text_1" width="15%">Designation</td>
                                                                        <td style="border-bottom:1px solid #333333;">&nbsp;</td>
                                                                        <td class="text_1" width="20%">Date Of Joining</td>
                                                                        <td style="border-bottom:1px solid #333333;">&nbsp;</td> 
                                                                    </tr>
                                                              </table>   
                                                          </td>   
                                                    </tr>
                                                    <tr>
                                                    	<td style="padding-top:10px;" valign="top">
                                                        	<table align="center" border="1" width="600" cellpadding="0" cellspacing="0" class="text_1" style="padding-left:0px;">
                                                            <tr>
                                                            <?

																$start_date="01";
																
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
                                                                $daysago = $day2; //Calculates Days Old
                                                                
                                                                $i = 1;
                                                                while ($i <=31) {
                                                                if ($i != 1) { $date = $date + 86400; }
                                                                else { $date = $date - 86400; }
                                                                $today = date('Y-m-d',$date);
                                                                //echo "$today ";
                                                                
                                                                $yy = date('Y',$date);
                                                                $mm = date('m',$date);
                                                                $dd = date('d',$date);
                                                                
																
	                                                            echo "<td width=\"10%\">";
																if($i<=$daysago)
																{
																	echo $dd;
																}
																else
																{
																	echo "&nbsp;";
																}
																echo "</td>";
																	if(($i%7)==0)
																	{
																		echo "</tr>";
																	
																		echo "<tr>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																		</tr>";
																		echo "<tr>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																			<td>&nbsp;</td>
																		</tr>";
																	}
																	if($i==31)
																	{
																		
																		echo "<td colspan=\"3\">Total Days Worked</td>
																				<td>&nbsp;</td>
																			  </tr>
																			  <tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td colspan=\"4\" rowspan=\"2\">
																					<table width=\"100%\">
																						<tr>
																							<td>&nbsp;</td>
																							<td>&nbsp;</td>
																							<td>&nbsp;</td>
																						</tr>
																						<tr>
																							<td align=\"center\" class=\"text_1\">T.K.</td>
																							<td align=\"center\" class=\"text_1\">CTK</td>
																							<td align=\"center\" class=\"text_1\">L.O.</td>
																						</tr>
																					</table>
																				</td>
																			  </tr>
																			  <tr>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																				<td>&nbsp;</td>
																			  </tr>";
																	}
																	$i++;
                                                                }
                                                                ?>
                                                               
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td align="center">
                                                        	<input type="image" src="images/btn_print.jpg" name="" id=""  value="Print"/>
                                                        </td>
                                                    </tr>
                                                 </table>
                                             </div>  
                                            </td>
                                        </tr>
                                        <?
										}
										?>
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
                                                        <td style="padding-top:10px" align="center">
                                                        <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                        <form action="print_card.php" method="post" name="frm_chech_emp" id="frm_chech_emp" target="_blank">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                              <tr class="gredBg">
                                                                <td width="5%" align="center"><b>S. No.</b></td>
                                                                <td width="15%" align="left" style="padding-left:20px;">
                                                                <input type="checkbox" name="master" onClick="marcarTodos()"><b>Name/Father Name</b></td>
                                                              </tr>
																<?
                                                                while($row=mysql_fetch_array($result_prj))
                                                                {
																$present=0;
																$absent=0;
																$Pl=0;
																$Cl=0;
                                                                ?>	
                                                              <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                <td width="5%" align="center"><?=$sno?></td>
                                                                <td width="15%" align="left" style="padding-left:20px;">
                                                                <input type="checkbox" name="emp_check[]" id="emp_check[]" value="<?=$row['emp_id']?>"><?=$row['ticket_no']?>/<?=$row['first_name']?> / <?=getfamilyDetail('father_name',$row['emp_id'])?>
                                                                </td>
                                                              </tr>
                                                                <?
																	$sno++;
																}	
																?>	
                                                                <tr>
                                                                    <td align="center" colspan="2" style="padding:5px;">
                                                                    	<input type="hidden" name="card_month" id="card_month" value="<?=$month?>"/>
                                                                        <input type="hidden" name="card_year" id="card_year" value="<?=$year?>"/>
                                                                        <input type="image" src="images/btn_print.jpg" name="print_card" id="print_card"  value="Print"/>
                                                                    </td>
                                                                </tr> 													 
                                                            </table>   
                                                        </form>
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