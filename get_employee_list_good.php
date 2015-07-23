<? include ("inc/dbconnection.php");?>
<? include ("inc/function.php");?>
<?
$id="";
$add_div = "";
$hidden_value = "";
$ticket_id = $_GET["id"];
$id=getemployeeDetailByTicket('rec_id',$ticket_id);
$type = $_GET["type"];
$date = getdbDate($_GET["str"]);
$shift=$_GET["shift"];
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
$sql = "Select * from mpc_employee_master where emp_id = '$id' and empType = '$type'";
 $result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

		$row = mysql_fetch_array($result_doc);
	
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];

if(mysql_num_rows($result_doc)>0)
{

$sql = "select * from mpc_good_work_master where emp_id = '$id' and date = '$date'";
		 $result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result_doc)>0)
	{
		

	$sno = 1;
	?>
     <table align="center" width="100%" border="0" class="border">
        <tr class="blackHead">
           <td width="6%" align="center">S.No.</td>
           <td width="7%" align="center">Emp no.</td>
           <td width="21%" align="center">Employee Name</td>
           <td width="21%" align="center">Shift</td>
           <td width="19%" align="center">Good Work</td>
           <td width="11%" align="center">Update</td>
      </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$ticket_id?></td>
            <td align="center"><?=$first_name?>&nbsp;<?=$last_name?></td>
            <td align="center"><?=$row_doc['shift']?></td>
             <td align="center"><?=$row_doc['good_work']?></td> 
             <td>
            	<a href="javascript:;" onclick="get_frm_focus_goodwork('get_good_work_list_udate.php','<?=$id?>&type=<?=$type?>&shift=<?=$row_doc['shift']?>','div_employee_list','<?=$date?>');" id="update_emp">update</a>
            </td>
        </tr>
<?
	 $name=$row_doc['first_name']." ".$row_doc['last_name'];
	 $sno++;
	}
?>       
<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$ticket_id?></td>
            <td align="center"><?=$name?></td>
            <td align="center"><?=$shift?></td>
            <td align="center"><select name="good_work" id="good_work" onkeydown="if (event.keyCode == 13) get_frm_attendence('get_employee_good_work_list.php','<?=$date?>','div_employee_last','<?=$id ?>',this.value,'<?=$type?>','<?=$shift?>')">
              <?		if($shift=='G')
			  				{
								$hour=18;
							}
			  				else
							{
								$hour=8;
							}
						$j=30;
						for($i=0;$i<$hour;)
						{
							if($j==60)
							{
								$i++;
								$j=0;
							}
							
					?>
              <option value="<?=$i.':'.$j?>">
                <?=$i.':'.$j?>
              </option>
              <?
						$j=$j+30;
						}
					?>
            </select></td>
       </tr>    	    
</table>
    <?

		
	}
	else 
	{
		
		$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";
		
		//$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
		$query_count = $query_count;
		$result_q= mysql_query($query_count);
		$row_count = mysql_fetch_array($result_q);
		$numrows = $row_count['count'];
		$count = ceil($numrows/$row_limit);
		
			$sno = 1;
		?>
		<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr class="navigation_row">
				<td class="headingSmall">
					<div style="margin:1px;text-align:left;" >
						<?
						if(!$count==0)
						{
						?>
							<?=$numrows?> results found
						<?
						}
						?>
					</div>
				</td>   
			</tr>
		</table> 
		<div> 
			<table align="center" width="100%" border="0" class="border">
				<tr class="blackHead">
					<td width="6%" align="center">S.No.</td>
					<td width="7%" align="center">Emp no.</td>
					<td width="21%" align="center">Employee Name</td>
					<td width="19%" align="center">Good Work</td>
			  </tr>
		
				<tr <? if ($sno%2==1) { ?> bgcolor="#F8F8F8" <? } ?> class="tableTxt">
					<td align="center"><?=$sno?></td>
					<td align="center"><?=$ticket_id?></td>
					<td align="center"><?=$first_name?>&nbsp;<?=$last_name?></td>
					<td align="center"><select name="good_work" id="good_work" onkeydown="if (event.keyCode == 13) get_frm_attendence('get_employee_good_work_list.php','<?=$date?>','div_employee_last','<?=$id ?>',this.value,'<?=$type?>','<?=$shift?>')">
					  <?
								if($shift=='G')
									{
										$hour=18;
									}
									else
									{
										$hour=8;
									}
								$j=30;
								for($i=0;$i<$hour;)
								{
									if($j==60)
									{
										$i++;
										$j=0;
									}
									
							?>
					  <option value="<?=$i.':'.$j?>">
						<?=$i.':'.$j?>
					  </option>
					  <?
								$j=$j+30;
								}
							?>
					</select></td>
			  </tr>
		     
		 <input type="hidden" id="count_row" name="count_row" value="<?=mysql_num_rows($result_doc)?>"/> 
		 <tr bgcolor="#F8F8F8">
			<td colspan="8" align="center">
				<input type="button" src="images/btn_submit.png" name="btn_attend" id="btn_attend" value="Submit" onclick=" get_frm_attendence('get_employee_good_work_list.php','<?=$date?>','div_employee_last','<?=$id?>',document.getElementById('good_work').value,'<?=$type?>','<?=$shift?>')"/>    </td>
		</tr>    	    
		</table>
		</div>
		<?    	
		
		
	}

}
else
{ 
?>
			<div align="center">No Record Found</div>	
		<?
}