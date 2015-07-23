<? include("inc/maint_header.php");?>
<style type="text/css" media="print">
#btn_print, form, .tnb_print, img, .top_tnb, .header_bg, .welcome_txt, .gray_bg, iframe, #overlay
{
	display:none;
}
#getItemsInDiv
{
	display:block;
	height:auto;
}
</style>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
	<tr>
		<td align="left" valign="top" width="230px" style="padding-top:5px;" class="tnb_print">
			<? include ("inc/maint_snb.php"); ?>
		</td>
		<td style="padding-left:5px; padding-top:5px;" valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
        <tr>
          <td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Pending Maintenance Report</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td valign="top" style="padding-bottom:5px;" width="100%" bgcolor="#EAE3E1">
                  
				  <form id="frm_search" name="frm_search" method="post" action="">
                    <table id="" align="center" width="100%" border="1" class="table1 text_1">
                    <tr>
                      <td align="center" colspan="7"><b>Search Items</b></td>
                    </tr>
                    <tr>
                      <td align="left"><b>Department</b></td>
                      <td align="left">
                      	<select id="department_code" name="department_code" style="width:150px">
                        	<option value="">-Select-</option>
                        <?
												$sql_d="select * from maint_department order by name";
                        $res_d=mysql_query($sql_d);
												while($row_d=mysql_fetch_array($res_d))
												{
												?>
                        	<option value="<?= $row_d['department_code']?>"><?= $row_d['name']?></option>
												<?	
                        }
												?>
                        </select>
                      </td>
                      <td align="left"><b>Service</b></td>
                      <td align="left">
                      	<select id="service_id" name="service_id" style="width:150px">
                        <option value="">-Select-</option>
													<?
                          $sql_S="select * from maint_services order by name";
                          $res_S=mysql_query($sql_S);
                          while($row_S=mysql_fetch_array($res_S))
                          {
                          ?>
                            <option value="<?= $row_S['s_code']?>"><?= $row_S['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                        
                       </td>
                       <td align="left"><b>Machine</b></td>
                      <td align="left">
                      	<select id="machine_id" name="machine_id" style="width:150px">
                        <option value="">-Select-</option>
													<?
                          $sql_S="select * from maint_machine_master order by name";
                          $res_S=mysql_query($sql_S);
                          while($row_S=mysql_fetch_array($res_S))
                          {
                          ?>
                            <option value="<?= $row_S['machine_id']?>"><?= $row_S['name']?></option>
                          <?	
                          }
                          ?>
                        </select>
                       </td>
                       <td>
                       	<input type="submit" id="btn_submit" name="btn_submit" value="Filter" />
                       </td>
                    </tr>
                  </table>
                  </form>
				  <?
				  $search = "";
					if(isset($_POST["btn_submit"]))
					{
						$department_code = $_POST["department_code"];
						
						$search .= ($department_code!="") ? " and mmm.department_code = '$department_code'" : "";
						
						$service_id = $_POST["service_id"];
						
						$search .= ($service_id!="") ? " and mj.service_id = '$service_id'" : "";
						
						
						$machine_id = $_POST["machine_id"];
						
						$search .= ($machine_id!="") ? " and mj.machine_id = '$machine_id'" : "";
						
						
					}
				  $sql="select 
				  			*,
							DATEDIFF('".date('Y-m-d')."', mj.schedule_date) as DaysExceeded
						from 
							maint_job mj,
							maint_machine_master mmm 
						where 
							mmm.machine_code=mj.machine_id
							and mj.schedule_date <= '".date('Y-m-d')."'
							and mj.status='P'
							
							$search
						order by 
							mmm.department_code,
							mj.schedule_date asc";
						//echo $sql;
						$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
				  ?>
                  
					<table id="tableItems" align="center" width="100%" border="1" class="table1 text_1">
	<tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">Job Code</td>
    <td class="gredBg">Department</td>
    <td class="gredBg">Machine</td>
    <td class="gredBg">Service</td>
    <td class="gredBg">Sch.Date</td>
    <td class="gredBg">Pending Days</td>
    <td class="gredBg">Finish</td>
  </tr>
	 <?  
		if(mysql_num_rows($result)>0)
		{
			$sno = 1;
			while($row=mysql_fetch_array($result))
			{	
			
			?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center" valign="top"><?=$sno?></td>
        <td align="center" valign="top"><?=$row['job_code']?></td>
        <td align="left" style="padding-left:3px" valign="top">
        <?
				//if($val[0]!='0')
          $sql_dep = "select name from maint_department where department_code ='".$row['department_code']."'";
				//else
					//echo $sql_dep = "select md.name from maint_department md,maint_machine_master mmm,maint_job mj where mmm.department_code =md.department_code and mmm.machine_code= '".$row['machine_id']."' and mj.job_code='".$row['job_code']."' and md.deparment_code=$val[0]";
          $res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
          $row_dep = mysql_fetch_array($res_dep);
          echo $row_dep['name'];
        ?>	
        </td>
        <td align="left" style="padding-left:3px" valign="top">
				<?
         	$sql_M = "select mmm.machine_code,mmm.name from maint_machine_master mmm,maint_job mj where mj.job_code='".$row['job_code']."' and mmm.machine_code=mj.machine_id";
          $res_M = mysql_query($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno().":".mysql_error());
          $row_M = mysql_fetch_array($res_M);
          echo $row_M['machine_code'].' : '.$row_M['name'];
        ?>
        </td>
        <td align="left" style="padding-left:3px" valign="top">
        <?
        	$i=1;
					/*$sql_S = "SELECT ms.name, ms.s_code,ms.duration,ms.duration_type FROM maint_services ms,maint_machine_transaction mmt, maint_job mj 
					WHERE ms.s_code = mmt.service_id AND mmt.machine_id='".$row['machine_id']."' AND mj.job_code = '".$row['job_code']."'";*/
         $sql_S = "select ms.s_code,ms.name,ms.duration,ms.duration_type,ms.work_to_do from maint_services ms,maint_job mj where ms.s_code =mj.service_id and mj.job_code='".$row['job_code']."'";
          $res_S = mysql_query($sql_S) or die ("Invalid query : ".$sql_S."<br>".mysql_errno().":".mysql_error());
          while($row_S = mysql_fetch_array($res_S))
					{
						$dt='';
						if($row_S['duration_type']=="M")
							$dt='Months';
						else
							$dt='Days';
          	echo $row_S['s_code']." : ".$row_S['name'].'  <b>'.$row_S['duration'].' '.$dt."</b><br />";
						$work_to_do= $row_S['work_to_do'];
						$wtd=explode("\n",$work_to_do);
						foreach($wtd as $str)
						{
							if(trim($str)!='')	
							{	
								echo $str;
								if(count($wtd)>1)
									echo '<br />';
							}
						}
					}
						
        ?>
        </td>
        <td align="center" valign="top"><b><?=getDateFormate($row['schedule_date'])?></b></td>
        <td align="center" valign="top"><?=$row['DaysExceeded']?></td>
        <td class="links tnb_print">
        	<a href="maint_add_job.php?job_code=<?=$row['job_code']?>">Finish</a>
        </td>
			</tr>
			<?
			$sno++;
			}	
		}
		else
		{
		?>
		<tr>
			<td colspan="6" align="center" style="font-weight:bold">No Records Found</td>
		</tr>
		<?
		}
		?>        
</table>
<input type="button" id="btn_print" name="btn_print" value="Print" onClick="window.print();" />
                            
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
  	</td>
  </tr>
</table>
<iframe width=168 height=190 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="calendar/ipopeng.htm" scrolling="no" frameborder="0" style="border:2px ridge; visibility:visible; z-index:999; position:absolute; left:-500px; top:0px;">
</iframe>                                        
<? include("inc/hr_footer.php");?>