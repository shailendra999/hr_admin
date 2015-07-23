<?
include("inc/dbconnection.php");include("inc/store_function.php");include("inc/check_session.php");
?>
<?
$id=$_REQUEST['id'];
$sql="select * from ms_supplier where supplier_id='".$id."'";
$result=mysql_query($sql);
?>
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="5%">S.No.</td>
    <td class="gredBg" width="25%">Supplier Name</td>
    <td class="gredBg" width="15%">Phone No.</td>
    <td class="gredBg" width="25%">Address</td>
    <td class="gredBg" width="15%">TIN</td>
    <td class="gredBg" width="5%">View</td>
    <td class="gredBg" width="5%">Edit</td>
    <td class="gredBg" width="5%">Delete</td>
  </tr>
  <?  
  if(mysql_num_rows($result)>0)
  {
  $sno = 1;
    while($row=mysql_fetch_array($result))
    {	
      $sql_idate="select * from ms_supplier where insert_date='".date('Y-m-d')."' and supplier_id='".$row['supplier_id']."'";
			$res_idate=mysql_query($sql_idate);	
			$row_idate=mysql_fetch_array($res_idate);
			$insert_date=$row_idate['insert_date'];
			?>
			<tr <? if ($sno%2==1) { ?> bgcolor="#F2F2F2" <? } ?>>
				<td align="center"><?=$sno?></td>
				<td align="left" style="padding-left:5px;"><?=$row['name']?></td>
				<td align="center"><?=$row['phone_number']?></td>
				<td align="left" style="padding-left:5px;"><?=stripslashes($row['address'])?></td>
				<td align="center"><?=$row['tin']?></td>
				<td align="center">
					<a href="store_view_supplier.php?supplier_id=<?=$row["supplier_id"]?>">
					<img src="images/search-icon.gif" alt="View" title="View" border="0"></a>
				</td> 
				<?
				if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
				{
				?>
					<td align="center">
						<a href="store_add_supplier.php?supplier_id=<?=$row["supplier_id"]?>&mode=edit">
						<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0"></a>
					</td>
					<td align="center">
						<a href="javascript:;" onClick="overlay(<?=$row["supplier_id"]?>);">
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
?> 
<?
} // End Of If
?>
</table>       
