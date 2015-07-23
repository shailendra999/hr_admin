<? include ("inc/hr_header.php"); ?>
<!--<link rel="stylesheet" href="css/BeatPicker.min.css"/>
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/BeatPicker.min.js"></script>
<script>-->
<script>
  $(function() {
    //$( "#dob" ).datepicker();
	$('.footer').hide();
  });
</script>
<?
	$txt_date="";
	
	 if(isset($_POST["btn_submit"]))
	 {
		$txt_date=$_POST["txt_date"];
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Daily Working Report</td>
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
                                                <input type="text" name="txt_date" id="txt_date" value="<?=$txt_date?>" style="width:80px; height:20px;" data-beatpicker="true"/>
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
                                            <td>&nbsp;</td>
                                            <td colspan="6">SHIFT-A</td>
                                            <td colspan="6">SHIFT-B</td>
                                            <td colspan="6">SHIFT-C</td>
                                            <td colspan="6">TOTAL</td>
                                            <td colspan="4">&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td>DEPARTMENT</td>
                                            <td colspan="3">PRESENT</td>
                                            <td colspan="3">Good Work</td>
                                            <td colspan="3">PRESENT</td>
                                            <td colspan="3">Good Work</td>
                                            <td colspan="3">PRESENT</td>
                                            <td colspan="3">Good Work</td>
                                            <td colspan="3">PRESENT</td>
                                            <td colspan="3">Good Work</td>
                                            <td>Con</td>
                                            <td colspan="3">GRAND</td>
                                          </tr>
                                          <tr>
                                            <td>Hands</td>
                                            <?
                                            $sql = "SELECT rec_id,designation_name FROM mpc_designation_master where emp_category ='Worker'";
                                            $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                                            
                                            if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											 if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);

										 if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
											if(mysql_num_rows($result)>0)
                                            {     
                                                while($row = mysql_fetch_array($result))
                                           		{
													?><td><?=$row['designation_name']?></td>
												<?
                                                }
											}
											mysql_data_seek($result,0);
                                            ?>
                                            <td>Present</td>
                                            <td>Absent</td>
                                            <td>Leave</td>
                                            <td>Total</td>
                                          </tr>		
                                          <?
										  		$sql_prj = "select * from ".$mysql_table_prefix."department_master where reference_id='0'";
												
												$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
												if(mysql_num_rows($result_prj)>0)
                                                        {
														 $total_dep=0;
														 $total_present_skill_a=0;
														 while($row_dept=mysql_fetch_array($result_prj))
                                                                {
																	
																?>
                                                                 <tr>
                                                                    <td colspan="30"><b>
                                                                      <?=$row_dept['department_name']?>
                                                                    </b></td>
                                      </tr>	
                                                                  	<?
                                                                    $sql_sub = "select * from ".$mysql_table_prefix."department_master where reference_id='".$row_dept['rec_id']."'";
												
                                                                    $result_sub = mysql_query($sql_sub) or die("Error in Query :".$sql_sub."<br>".mysql_error().":".mysql_errno());
                                                                    if(mysql_num_rows($result_sub)>0)
                                                                            {
																			$dept_sub_total=0;
																			$dept_sub_total_sum=0;

																			$shift_a_present_skill=0;
																			$shift_a_present_SrTr=0;
																			$shift_a_present_Tr=0;
																			$total_present=0;
																			$total_good_work=0;
																			$present_dept_sum=0;
																			$good_dept_sum=0;
                                                                             while($row_sub=mysql_fetch_array($result_sub))
                                                                                    {
                                                                                    ?>
                                                                                     <tr>
                                                                                        <td><span style="text-align:left;"><?=$row_sub['department_name']?></span><span>
                                                                                          <? 
																							echo $dept_sub_total=getDepartment($row_sub['rec_id'],$txt_date,'%%','%%','%%');
																							$dept_sub_total_sum=$dept_sub_total_sum+$dept_sub_total;
																						?>
                                                                                        </span></td>
                                                                                        <?
                                                                                        if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getGoodWorkDept($row_sub['rec_id'],$txt_date,$row['rec_id'],'First');
																										echo $shift_a_skill;
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
                                                                                        mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getDepartment($row_sub['rec_id'],$txt_date,'P',$row['rec_id'],'First');
																										echo $shift_a_skill;
																										$shift_a_present_skill=$shift_a_skill+$shift_a_present_skill;
																										?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
                                                                                        mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getDepartment($row_sub['rec_id'],$txt_date,'P',$row['rec_id'],'Second');
																										echo $shift_a_skill;
																										$shift_a_present_skill=$shift_a_skill+$shift_a_present_skill;
																										?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
                                                                                        mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getDepartment($row_sub['rec_id'],$txt_date,'P',$row['rec_id'],'Second');
																										echo $shift_a_skill;
																										$shift_a_present_skill=$shift_a_skill+$shift_a_present_skill;
																										?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
                                                                                        mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getDepartment($row_sub['rec_id'],$txt_date,'P',$row['rec_id'],'Third');
																										echo $shift_a_skill;
																										$shift_a_present_skill=$shift_a_skill+$shift_a_present_skill;
																										?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
                                                                                        mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? $shift_a_skill=getDepartment($row_sub['rec_id'],$txt_date,'%P%',$row['rec_id'],'Third');
																										echo $shift_a_skill;
																										$shift_a_present_skill=$shift_a_skill+$shift_a_present_skill;
																										?></td>
                                                                   <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						$present_dept_sum=0;
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? echo $present_dept=getDepartment($row_sub['rec_id'],$txt_date,'%P%',$row['rec_id'],'%%');																										$present_dept_sum=$present_dept_sum+$present_dept;
	
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						$good_dept_sum=0;
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><? echo $good_dept=getGoodWorkDept($row_sub['rec_id'],$txt_date,$row['rec_id'],'%%');
																										$good_dept_sum=$good_dept_sum+$good_dept;
																									 ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						?>
                                                                                        <td><?=$sum_sub_con=$present_dept_sum+$good_dept_sum?></td>
                                                                                        <td><?=$sub_absent=getDeptAttendancestatus($row_sub['rec_id'],"A",$txt_date)?></td>
                                                                                        <td><?=$sum_leave=getDeptAttendancestatus($row_sub['rec_id'],"CL",$txt_date)+getDeptAttendancestatus($row_sub['rec_id'],"PL",$txt_date)?></td>
                                                                                        <td><?=$total=$sum_sub_con+$sum_leave+$sub_absent;?></td>
                                                                                      </tr>	
                                                                                    <?
																					}
																					?>
                                                                                    <tr>
                                                                                        <td><span style="text-align:left;">SUB TOTAL</span><span><? 
																							echo $dept_sub_total_sum;
																							$total_dep=$total_dep+$dept_sub_total_sum;
																							?></span>                                                                                        </td>
                                                                                        <? 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getDepartmentByMainDeptId($row_dept['rec_id'],$txt_date,'P',$row['rec_id'],'First');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getGoodWorkByMainDeptId($row_dept['rec_id'],$txt_date,$row['rec_id'],'First');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																							if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getDepartmentByMainDeptId($row_dept['rec_id'],$txt_date,'P',$row['rec_id'],'Second');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getGoodWorkByMainDeptId($row_dept['rec_id'],$txt_date,$row['rec_id'],'Second');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																					   if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getDepartmentByMainDeptId($row_dept['rec_id'],$txt_date,'P',$row['rec_id'],'Third');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo getGoodWorkByMainDeptId($row_dept['rec_id'],$txt_date,$row['rec_id'],'Third');
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 
																						if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																									 echo $total_present_des =getDepartmentByMainDeptId($row_dept['rec_id'],$txt_date,'P',$row['rec_id'],'%%');
																									  $total_present =$total_present+$total_present_des;
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0); 	
																						                                                                                      
                                                                                        if(mysql_num_rows($result)>0)
                                                                                        {     
                                                                                            while($row = mysql_fetch_array($result))
                                                                                            {
                                                                                                ?>
                                                                                                 <td><?
																								 	echo $total_good_work_des = getGoodWorkByMainDeptId($row_dept['rec_id'],$txt_date,$row['rec_id'],'%%');
																										$total_good_work=$total_good_work+$total_good_work_des;
																									  ?>                                                                                                </td>
                                                                                            <?
                                                                                            }
                                                                                        }
																						mysql_data_seek($result,0);
																						?> 
                                                                                        <td><?=$con=$total_present+$total_good_work?></td>
                                                                                        <td><?=getDeptAttendancestatus($row_sub['rec_id'],"A",$txt_date)?></td>
                                                                                        <td><?=$sum_leave=getDeptAttendancestatus($row_sub['rec_id'],"CL",$txt_date)+getDeptAttendancestatus($row_sub['rec_id'],"PL",$txt_date)?></td>
                                                                                        <td><?=$con?></td>
                                                                                      </tr>	
                                                                                    <?
																			}		
																					?>
                                                                  <?
																  }
																  ?>
                                                                <tr>
                                                                    <td><span style="text-align:left;">GRAND TOTAL</span><span><?=$total_dep?></span></td>
                                                                    <? 
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getDepartmentByMainDeptIdSum($txt_date,'P',$row['rec_id'],'%First%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getGoodWorkByMainDeptIdSum($txt_date,$row['rec_id'],'%First%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0);
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getDepartmentByMainDeptIdSum($txt_date,'P',$row['rec_id'],'%Second%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getGoodWorkByMainDeptIdSum($txt_date,$row['rec_id'],'%Second%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getDepartmentByMainDeptIdSum($txt_date,'P',$row['rec_id'],'%Third%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?
																					 echo getGoodWorkByMainDeptIdSum($txt_date,$row['rec_id'],'%Third%');
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0);
																		$total_sum_present=0;
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><?																				
																					 echo $total_sum=getDepartmentByMainDeptIdSum($txt_date,'P',$row['rec_id'],'%%');
																					 $total_sum_present=$total_sum_present+$total_sum;
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
																		$total_good_work_sum=0;
																		if(mysql_num_rows($result)>0)
																		{     
																			while($row = mysql_fetch_array($result))
																			{
																				?>
																				 <td><? 
																					 echo $total_good_work=getGoodWorkByMainDeptIdSum($txt_date,$row['rec_id'],'%%');
																					 $total_good_work_sum=$total_good_work_sum+$total_good_work;
																					  ?>                                                                                                </td>
																			<?
																			}
																		}
																		mysql_data_seek($result,0); 
						
																	?>
                                                                    <td><?=$total_good_work_sum+$total_sum_present?></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td><?=$total_good_work_sum+$total_sum_present?></td>
                                                                  </tr>	
                                                                <?
														}		  

										  ?>		 
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