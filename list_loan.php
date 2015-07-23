<? include ("inc/hr_header.php"); ?>
<?
$msg ='';
$plant="";
$dep="";
$dept_id="";
?>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
//////////// *************** Delete Loan ************** ///////////////

if(isset($_POST["btn_del"]))
{
	$rec_id  = $_POST["hidden_overlay"];
	$sql = "delete from mpc_loan_employee where rec_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$sql = "delete from mpc_loan_installments where loan_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$msg = "Loan Sucessfully Deleted";
}	
?>
<?
//////******************** Edit Loan **************///////
if(isset($_POST['loan_id']))
{
	$loan_id = $_POST["loan_id"];
	$txt_loan = $_POST["txt_loan"];
	$installments_decided = $_POST["installments_decided"];
	$txt_date = getdbDateSepretoe($_POST["txt_date"]);
	
	$sql_up = "update mpc_loan_employee set 
											loan_amount = '$txt_loan',
											installments_decided = '$installments_decided',
											loan_date = '$txt_date' 
											where rec_id= '$loan_id'";
	
	//echo $sql_up;
	$result_up = mysql_query($sql_up) or die ("Query Failed ".mysql_error());
	if($result_up)
	{
		$msg="Loan Updated!!";
	}
	else
	{
		$msg="Error In Updating Loan!!";
	}
}
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
	 $sql_prj = "select DAY(mpc_official_detail.date_joining) as 'Day',MONTH(mpc_official_detail.date_joining) as 'Month' ,YEAR(mpc_official_detail.date_joining) as 'Year',mpc_official_detail.date_joining,mpc_employee_master.rec_id as id,mpc_employee_master.ticket_no,mpc_employee_master.first_name,mpc_employee_master.last_name,mpc_official_detail.emp_id ,mpc_account_detail.emp_id,mpc_account_detail.date_releaving,mpc_loan_employee.loan_amount,mpc_loan_employee.installments_decided,mpc_loan_employee.loan_date,mpc_loan_employee.rec_id as loan_id $select_string from ".$mysql_table_prefix."employee_master,mpc_official_detail,mpc_account_detail,mpc_loan_employee $table_list where mpc_employee_master.rec_id!='' and mpc_employee_master.rec_id=mpc_official_detail.emp_id and EXTRACT(YEAR_MONTH FROM mpc_official_detail.date_joining)<='$year$month' and mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and mpc_loan_employee.emp_id =  mpc_employee_master.rec_id $where_string and  MONTH(mpc_loan_employee.loan_date)='".$month."' and YEAR(mpc_loan_employee.loan_date) ='".$year."' order by mpc_employee_master.ticket_no ASC";
	 
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
<style>
select,input[type="text"]{height:36px !important; width:185px !important;margin:5px 0;}
input[type='text']{
	border-radius:5px;
	width:235px !important;
	height:35px !important;
	padding-left:2px !important;
	color:#6d6d6d !important;
} 
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>       
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg">&nbsp; <a href="#" style="text-decoration:none;color:gray;">Advance/Loan-> </a>loan report</td>
                </tr>
                <tr>
                	<td height="500px" valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                            <td class="red"><?=$msg?></td>
                                         </tr>
                                        <tr>
                                            <td align="left" valign="top">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;" bgcolor="#f3fbd2">
                                                     <tr>
                                                        <td style="padding-top:10px;" align="left">
                                                         <form name="frm_month" id="frm_month" action="" method="post">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                	<td colspan="8">
                                                                    <table align="left">
                                                                    	<tr>                                                                  
                                                                    <td align="left" class="text_1"><b>Year</b></td>
                                                                    <td align="left">
                                                                   <?    
                                                                        $sql_prd = "select max(date)as MAXDATE,min(date)as MINDATE from ".$mysql_table_prefix."attendence_master ";
                                                                        $result_prd = mysql_query ($sql_prd) or die ("Error in : ".$sql_prd."<br>".mysql_errno()." : ".mysql_error());												
																		$row_prd = mysql_fetch_array($result_prd);	
																		 $min_year=2014;
																		 $max_year=2015;
                                                                        ?>    
                                                                            <select name="year" id="year" style="width:150px; height:25px;" onchange="get_frm('get_month.php',this.value,'div_month','');">
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
                                                                    <tr>
                                                                                                                                        <td align="left" class="text_1"><b>Month</b></td>
                                                                    <td align="left">
                                                                    <div id="div_month">
                                                                    <select id="month" name="month" style="width:150px; height:25px;">
                                                                        <?
																		 for($i=01;$i<=12;$i++)
																		 {
																		   $j=sprintf("%02d",$i);
																		 ?>
                                                                          <option value="<?=$j?>" <? if($j==$month)  { echo 'selected="selected"';}?>><?=date("F",mktime(0, 0, 0,$i, 1, 0))?></option>
                                                                          <?
                                                                          }
																		  ?>
                                                                         
                                                                    </select>
                                                                    </div>        						
                                                                    </td>
                                                                    </tr>
                                                                    </table>
                                                                    </td>
                                                                </tr>
                                                                 <tr> 
                                                                 	<td class="text_1" colspan="2">
                                                                    	<b>Filter By:</b>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                	<td class="text_1" align="left">
                                                                    	 <b>Emp Type</b></td>
                                                                         <td align="left">
                                                                    <select name="employee_type" id="employee_type">
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
                                                                    <td class="text_1" align="left">
                                                                    	<b>Emp ID</b></td>
                                                                        <td> <input type="text" name="ticket_id" id="ticket_id" value="<?=$ticket_id?>" size="4"/>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1" align="left">
                                                                    	<b>Department</b></td>
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
                                                                    <td class="text_1" align="left">
                                                                    	<b>Sub Department</b></td>
                                                                        <td align="left">
                                                                         <div id="div_sub_dept">
																			
                                                                        <select name="sub_department" id="sub_department" style="width:150px; height:25px;" onchange="">
                                                                            <option value="">Select</option>
                                                                            
                                                                        </select>
                                                                        </div>
                                                                    </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td class="text_1" align="left">
                                                                    	<b>Plant</b>
																		</td>
																		<td align="left">
																		<?
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
                                                                        	
                                                   <a href="javascript:;" onclick="document.location='list_loan.php';">
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
                                        	<td>
                                            	<div id="div_edit"></div>
                                            </td>                                        
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" style="padding-top:5px;">
                                                <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #CCCCCC;">
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
                                                                        <form action="print_loan_list.php" method="post" name="frm_print" id="frm_print" target="_blank">
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
                                                                        <form action="print_loan_list_excel.php" method="post" name="frm_print_xls" id="frm_print_xls" target="_blank" style="display:inline;">
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
                                                        <td style="padding-top:10px" align="center">
                                                      <div id="div_attandance_list" style="overflow:scroll;height:500px;width:1000px">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                                              <tr class="gredBg">
                                                                <td width="5%" align="center"><b>Sno.</b></td>
                                                                <td width="5%" align="center"><b>Emp Id</b></td>
                                                                <td width="15%" align="center"><b>Name</b></td>
                                                                <td width="15%" align="center"><b>Loan</b></td>
                                                                <td width="15%" align="center"><b>Loan Installments</b></td>
                                                                <td width="15%" align="center"><b>Advance Date</b></td>
                                                                <td width="15%" align="center"><b>Edit</b></td>
                                                                <td width="15%" align="center"><b>Delete</b></td>
                                                              </tr>
																<?
																$sno=1;
                                                                while($row=mysql_fetch_array($result_prj))
                                                                {
																$present=0;
																$absent=0;
																$Pl=0;
																$Cl=0;
                                                                ?>	
                                                              <tr>
                                                                <td align="center"><?=$sno?></td>
                                                                <td align="center"><?=$row['ticket_no']?></td>
                                                                <td align="left"><?=$row['first_name']?> <?=$row['last_name']?></td>
                                                                <td align="center"><?=$row['loan_amount']?></td>
                                                                <td align="center"><?=$row['installments_decided']?></td>
                                                                <td align="center"><?=getDatetime($row["loan_date"]);?></td>
                                                                <td align="center"><a href="javascript:;" onClick="get_frm('edit_loan.php','<?=$row["loan_id"]?>','div_edit','')">
                                                                    	<img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
                                                                <td align="center"><a href="javascript:;" onClick="overlay(<?=$row["loan_id"]?>);">
                                                                      	<img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
                                                                </td>  
                                                             </tr>
                                                                <?
																	$sno++;
																}	
																?>													 
                                                          </table>
                                                          </div>   
                                                        </form>                                                                   
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
<div id="overlay">
     <div class="form_msg">
          <p>Are you sure to delete this Loan</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>   
<? include ("inc/hr_footer.php"); ?>	