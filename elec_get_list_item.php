<?
include("inc/dbconnection.php");include("inc/check_session.php");
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='ItemId')
{
	$sql="select * from ms_item_master where item_id=$val order by name asc";
}
else if(($_REQUEST['byControl'])=='DrawingNumber')
{
	$sql="select * from ms_item_master where drawing_number like '".$val."%' order by name asc";
}
else if(($_REQUEST['byControl'])=='CatelogNumber')
{
	$sql="select * from ms_item_master where catelog_number like '".$val."%' order by name asc";
}
else if(($_REQUEST['byControl'])=='Department')
{
	$sql="select im.* from ms_item_master im,ms_department id where im.department_id=id.department_id and id.department_id=$val order by im.name asc";
}
else if(($_REQUEST['byControl'])=='Machinary')
{
	$sql="select im.* from ms_item_master im,ms_machinary mac where im.machinary_id=mac.machinary_id and mac.machinary_id=$val order by im.name asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql);

?> 
<table id="tableItems" align="center" width="100%" border="1" class="table1 text_1">
	<tr>
    <td class="gredBg" width="5%">S.No.</td>
    <td class="gredBg" width="25%">Name</td>
    <td class="gredBg" width="15%">Department</td>
    <td class="gredBg" width="15%">Machinary</td>
    <td class="gredBg" width="10%">Dr. No.</td>
    <td class="gredBg" width="10%">Cat.No.</td>
    <td class="gredBg" width="8%">Location</td>
    <td width="4%" class="gredBg">View</td>
    <td width="4%" class="gredBg">Delete</td>
    <td width="4%" class="gredBg">Edit</td>
  </tr>
	 <?  
		if(mysql_num_rows($result)>0)
		{
			$sno=1;
			while($row=mysql_fetch_array($result))
			{	
			$sql_idate="select * from ms_item_master where insert_date='".date('Y-m-d')."' and item_id='".$row['item_id']."'";
			$res_idate=mysql_query($sql_idate);	
			$row_idate=mysql_fetch_array($res_idate);
			$insert_date=$row_idate['insert_date'];
			?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
				<td align="center"><?=$sno?></td>
				<td align="left" style="padding-left:5px"><?=$row['name']?></td>
				<td align="left" style="padding-left:5px">
					<?
					$sql_D= "select * from ms_department where department_id='".$row['department_id']."'";
					$res_D = mysql_query ($sql_D) or die ("Invalid query : ".$sql_D."<br>".mysql_errno()." : ".mysql_error());
					$row_D = mysql_fetch_array($res_D);
					echo $row_D['name'];
					?>
				</td>
				<td align="left" style="padding-left:5px">
					<?
					$sql_M= "select * from ms_machinary where machinary_id='".$row['machinary_id']."' ";
					$res_M = mysql_query ($sql_M) or die ("Invalid query : ".$sql_M."<br>".mysql_errno()." : ".mysql_error());
					$row_machinary = mysql_fetch_array($res_M);
					echo $row_machinary['name'];
					?>
			 </td>
			 <td align="left" style="padding-left:5px"><?=$row['drawing_number']?></td>
			 <td align="left" style="padding-left:5px"><?=$row['catelog_number']?></td>
			 <td align="left" style="padding-left:5px"><?=$row['location']?></td>
			 <td align="center">
					<a href="elec_view_item.php?item_id=<?=$row["item_id"]?>">
					<img src="images/search-icon.gif" alt="View" title="View" border="0"></a>
				</td>
				<?
				if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
				{
				?>
					<td align="center">
						<a href="elec_add_item.php?item_id=<?=$row["item_id"]?>&mode=edit">
						<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0"></a>
					</td>
					<td align="center">
						<a href="javascript:;" onClick="overlay(<?=$row["item_id"]?>);">
						<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0"></a>
					</td>
				<?
				}
				else
				{
				?>
					<td align="center"></td>
					<td align="center"></td>
				<?
				}
				?>
			</tr>
				<?
				$sno++;
			}	
		}
		else
		{
		?>
		<tr>
			<td colspan="10" align="center" style="font-weight:bold">No Records Found</td>
		</tr>
		<?
		}
		?>        
    
 
</table>