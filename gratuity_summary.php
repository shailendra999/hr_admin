<? include ("inc/hr_header.php"); ?>
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>-->
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>
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
$date_upto="";	
if(isset($_POST['txt_date']))
{	
	 $date_upto =$_POST['txt_date'];
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
		if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
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
}
if(isset($_POST["btn_submit_x"]) or isset($_GET['month']))
{			
	 
	 
	// $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and MONTH(mpc_official_detail.date_joining)<= '$month' and YEAR(mpc_official_detail.date_joining)<='$year' $where_string";
	
	$sql_prj = "select * $select_string from mpc_department_master $table_list where mpc_department_master.rec_id!='' and reference_id!='0' $where_string";
	 
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
                	<td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Report-> </a>gratuity summary</td>
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
                                                                	<td class="text_1" style="text-align:center;">
                                                                   Dated: </td>
                                                                   <td>
                                                                   <input type="text" name="txt_date" id="txt_date" style="width:100px; height:20px;"  value="<?=$date_upto?>" data-beatpicker="true"/>
                                                                    </td>
                                                                </tr>
                                                                 <tr> 
                                                                 	<td class="text_1" colspan="2">
                                                                    	Filter By:
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
                                                                    <td class="text_1">
                                                                    	OT</td>
                                                                        <td>
                                                                        <input type="checkbox" name="over_time" id="over_time"/>
                                                                    </td>
                                                                </tr> 
                                                                <tr>
                                                                    <td colspan="6" align="center" style="padding-top:5px;">
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="image" src="images/btn_view.jpg" name="btn_submit" id="btn_submit" value="View"/>
                                                                        	
                                                   <a href="javascript:;" onclick="document.location='gratuity_summary.php';">
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
                                                         	<form action="#" method="post" name="frm_print" id="frm_print" target="_blank">
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
                                                                <td width="5%" align="center"><b>Department Name.</b></td>
                                                                <td align="center"><b>Gratuity Amount</b></td>
                                                               
                                                              </tr>
																<?
                                                                while($row=mysql_fetch_array($result_prj))
                                                                {		
																	
																$total_emp_gratuity=0;
																$dept_net=0;
																
																 $sql = "SELECT * FROM mpc_department_employee,mpc_official_detail where to_date='0000-00-00' and dept_id='".$row['rec_id']."' and mpc_department_employee.emp_id=mpc_official_detail.emp_id";
																 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());

																if(mysql_num_rows($result)>0)	
                													{
																			while($row_dept=mysql_fetch_array($result))
																			{																										
																				$total_salary_basic=0;
																				
																				$emp_id=$row_dept['emp_id'];
																											 
																				$total_salary_basic=getSalaryDetail("basic",$emp_id,getdbDate($date_upto));															
																				$date2=$row_dept['date_joining'];
																				
																				$date_result=dateDifference($date_upto,$date2);
																		        $date_result['years'];
																				$emp_gratuity=round(($total_salary_basic/26)*15*$date_result['years'],2);
																			    $total_emp_gratuity=$total_emp_gratuity+$emp_gratuity;
																						
																			}	
																																			
																		}
																		 
																		      	
																?>
                                                               <tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
                                                                <td width="5%" align="center"><?=$sno?></td>
                                                                <td width="5%" align="center">
																<?=$row['department_name']?><br/>
                                                                </td>
                                                                <td align="center"><?=round($total_emp_gratuity,2)?></td>
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