<? include ("inc/hr_header.php"); ?>
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script> -->
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>
<?
if(isset($_POST["txt_date"]))
	{
		$date=$_POST["txt_date"];
	}
	else
	{
		$date="";
	}
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Daily Deployment Report</td>
                </tr>
                <tr>
                	<td class="heading" valign="top" style="padding-top:5px;">
                     <table align="center" width="25%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                         <tr>
                            <td style="padding-top:10px;" align="center">
                                <form name="frm_month" id="frm_month" action="" method="post">
                                    <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                        <tr>
                                              <td align="center" class="text_1">Month</td>
                                            <td>
                                                <input type="text" name="txt_date" id="txt_date" value="<?=$date?>" style="width:80px; height:20px;" data-beatpicker="true"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center" style="padding-top:5px;">
                                                 <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                 <input type="submit" name="btn_submit" id="btn_submit" value="View"/>
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
                        <table align="center" width="100%" cellpadding="1" cellspacing="1" border="0" style="border:1px solid #CCCCCC;">
                               <?  
                            if(isset($_POST["btn_submit"]) or isset($_GET['month']))
                                {
								  $txt_date=getdbDateSepretoe($_POST["txt_date"]);								 
                                ?>
                           <tr>
                                <td style="padding-top:10px" align="center">
                                    <table align="center" width="100%" cellpadding="0" cellspacing="0" class="table1" border="1">
                                          <tr>
                                            <td width="20%">DEPARTMENT</td>
                                            <td width="15%">Sanction</td>
                                            <td width="13%">On Roll</td>
                                            <td width="11%">PRESENT</td>
                                            <td width="10%">Absent</td>
                                            <td width="18%">Leave</td>
                                            <td width="13%">Week Off</td>
                                      </tr>
                                          <?
			$sql_prj = "select * from ".$mysql_table_prefix."department_master where reference_id='0'";
			
			$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
			if(mysql_num_rows($result_prj)>0)
					{
					 $total_persent=0;
					 $total_absent=0;
					 $total_leave=0;
					 $total_on_roll=0;
					 while($row_dept=mysql_fetch_array($result_prj))
                          {	
				?>
                     <tr>
                        <td colspan="7"><b>
                          <?=$row_dept['department_name']?>
                        </b></td>
                     </tr>	
				<?
                $sql_sub = "select * from ".$mysql_table_prefix."department_master where reference_id='".$row_dept['rec_id']."'";

                $result_sub = mysql_query($sql_sub) or die("Error in Query :".$sql_sub."<br>".mysql_error().":".mysql_errno());
                if(mysql_num_rows($result_sub)>0)
                        {
                         while($row_sub=mysql_fetch_array($result_sub))
                                {
								$present=0;
								$absent=0;
								$l=0;
								$on_roll=0;
								$present_per=0;
								$absent_per=0;
								$l_per=0;
								 
								 $sql = "SELECT * FROM mpc_department_employee where to_date='0000-00-00' and dept_id='".$row_sub['rec_id']."'";
								 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
								 
								 if(mysql_num_rows($result)>0)	
								{
										while($row_dept=mysql_fetch_array($result))
										{
											$today_date = date('Y-m-d');
											$leave_status = getLeavestatusBydate($row_dept['emp_id'],$txt_date);
											if($leave_status=="P")
												{
												   $present++;
												}
											else if($leave_status=="A")
												{
												   $absent++;
												}	
											else if($leave_status=="Pl")
												{
												   $l++;
												}
											else if($leave_status=="Cl")
												{
												   $l++;
												}
											else if($leave_status=="" and $today_date>=$txt_date)
												{
												   $leave_status='A';
												   $absent++;
												}
												$on_roll++;
											}
											$present_per=($present/$on_roll)*100;
											$absent_per=($absent/$on_roll)*100;
											$l_per=($l/$on_roll)*100;
											$total_persent=$total_persent+$present;
											$total_absent=$total_absent+$absent;
											$total_leave=$total_leave+$l;
											$total_on_roll=$total_on_roll+$on_roll;
                     			       }	
                                ?>
                                     <tr>
                                        <td><span style="text-align:left;"><?=$row_sub['department_name']?></span><span>
                                        </span></td>
                                      
                                          <td><input type="text" name="sanction[]" id="sanction[]" value=""/> </td>  
                                          <td><?=$on_roll?></td>  
                                          <td><?=$present?>     <?=round($present_per,2)?>%</td>  
                                          <td><?=$absent?>    <?=round($absent_per,2)?>%</td>
                                          <td><?=$l?>       <?=round($l_per,2)?>%</td>
                                          <td><?=$present?></td>  
                                      </tr>	
								<?
									}
                        } 
						}
						}
                        ?>		 
                        			<tr>
                                    	<td>
                                          Gand Total
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        	<?=$total_on_roll?>
                                        </td>
                                        <td>
                                        	<?=$total_persent?>
                                        </td>
                                        <td>
                                        	<?=$total_absent?>
                                        </td>
                                        <td>
                                        	<?=$total_leave?>
                                        </td>
                                        <td>
                                        	<?=$total_persent?>
                                        </td>
                                    </tr>
                                    <tr>
                                    <td>
                                          Percentage
                                        </td>
                                        <td>
                                        	
                                        </td>
                                        <td>
                                        	
                                        </td>
                                        <td>
                                        	<? $total_per_persent =($total_persent/$total_on_roll)*100; echo round($total_per_persent,2);
											?>%
                                        </td>
                                        <td>
                                        	<? $total_per_absent =($total_absent/$total_on_roll)*100; echo round($total_per_absent,2);
											?>%
                                        </td>
                                        <td>
                                        	<? $total_per_leave =($total_leave/$total_on_roll)*100; echo round($total_per_leave,2);
											?>%
                                        </td>
                                        <td>
                                        	
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    </table>                                                                      
                                 </td>
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
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:5000; position:absolute; left:-500px; top:0px;">
</iframe> 
<? include ("inc/hr_footer.php"); ?>	