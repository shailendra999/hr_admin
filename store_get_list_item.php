<?
include("inc/dbconnection.php");
include("inc/check_session.php");
$WhereCondition="";
if(($_REQUEST['item_name'])!="")
{
	$WhereCondition .="and item_id='".$_REQUEST['item_name']."'";
}
if(($_REQUEST['drawingNo'])!="")
{
	$WhereCondition .="and drawing_number like '".$_REQUEST['drawingNo']."' ";
}
if(($_REQUEST['catelogNo'])!="")
{
	$WhereCondition .="and catelog_number like '".$_REQUEST['catelogNo']."' ";
}
if(($_REQUEST['department_id'])!="")
{
	 $WhereCondition .="and id.department_id='".$_REQUEST['department_id']."' ";
}
if(($_REQUEST['machinary_id'])!="")
{
	 $WhereCondition .="and mac.machinary_id='".$_REQUEST['machinary_id']."' ";
}

 $sql="select im.* from ms_item_master im,ms_machinary mac,ms_department id where im.department_id=id.department_id and im.machinary_id=mac.machinary_id $WhereCondition order by im.name asc";
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?>
  <div class="AddMore" style="padding-top:10px">
  <form action="store_print_item.php" name="test" id="test" method="post" target="_blank"> 
    <input type="hidden" name="item_name" id="item_name" value="<?=$_REQUEST['item_name'] ?>" />
    <input type="hidden" name="drawingNo" id="drawingNo" value="<?=$_REQUEST['drawingNo'] ?>"/>
    <input type="hidden" name="catelogNo" id="catelogNo" value="<?=$_REQUEST['catelogNo'] ?>" />
    <input type="hidden" name="department_id" id="department_id" value="<?=$_REQUEST['department_id'] ?>"/>
    <input type="hidden" name="machinary_id" id="machinary_id" value="<?=$_REQUEST['machinary_id'] ?>" />
      <a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
   </form>
  </div> 
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
					<a href="store_view_item.php?item_id=<?=$row["item_id"]?>">
					<img src="images/search-icon.gif" alt="View" title="View" border="0"></a>
				</td>
				<?
				if(1)//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
				{
				?>
					<td align="center">
						<a href="store_add_item.php?item_id=<?=$row["item_id"]?>&mode=edit">
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