<?
include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
include("inc/check_session.php");
if(isset($_REQUEST['value']))
{
	$val=$_REQUEST['value'];
}
else
	$val='';
if(($_REQUEST['byControl'])=='IndentNo')
{
	$sql="select * from ms_indent_master mim,ms_indent_transaction mit where mim.indent_id=mit.indent_id and mim.indent_id=$val order by mim.indent_date asc";
}
else if(($_REQUEST['byControl'])=='Department')
{
	$sql="select * from ms_indent_master mim,ms_indent_transaction mit where mim.indent_id=mit.indent_id and mim.department_id=$val order by mim.indent_date asc";
}
else if(($_REQUEST['byControl'])=='Item')
{
	$sql="select * from ms_indent_master mim,ms_indent_transaction mit where mim.indent_id=mit.indent_id and mit.item_id=$val order by mim.indent_date asc";
}
else if(($_REQUEST['byControl'])=='IndentDate')
{
	$val=getDateFormate($val);
	$sql="select * from ms_indent_master mim,ms_indent_transaction mit where mim.indent_id=mit.indent_id and mim.indent_date='".$val."' order by mim.indent_date asc";
}
//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?> 
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg" width="5%">S.No.</td>
		<td class="gredBg" width="5%">Ind.No.</td>
    <td class="gredBg" width="8%">Ind.Date</td>
    <td class="gredBg" width="15%">Department</td>
    <td class="gredBg" width="35%">Item Name</td>
    <td class="gredBg" width="8%">UOM</td>
    <td class="gredBg" width="6%">Req.Qty</td>
    <td class="gredBg" width="6%">Pend.Qty</td>
    <td width="4%" class="gredBg">View</td>
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
  </tr>
  <?  
    if(mysql_num_rows($result)>0)
    {
      $sno =1;$oldid = "";$count =1;$flag=0;
      while($row=mysql_fetch_array($result))
      {
        $sql_idate="select * from ms_indent_master where insert_date='".date('Y-m-d')."' and indent_id='".$row['indent_id']."'";
        $res_idate=mysql_query($sql_idate);	
        $row_idate=mysql_fetch_array($res_idate);
        $insert_date=$row_idate['insert_date'];
        ?>
        <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
         <td align="center"><?=$sno?></td>
         <td align="center"><?=$row["indent_id"]?></td>
         <td align="center"><?=getDateFormate($row["indent_date"])?></td>
         <td align="center">
         	 <?
						$sql_dept="select * from ms_department where department_id='".$row['department_id']."'";
						$res_dept = mysql_query ($sql_dept) or die (mysql_error());
						if(mysql_num_rows($res_dept)>0)
						{
							$row_dept = mysql_fetch_array($res_dept);
							echo $row_dept['name'];
						}
						?>
         </td>
         <?
          $sql_item = "select * from ms_item_master where item_id='".$row['item_id']."' ";
          $res_item = mysql_query($sql_item) or die (mysql_error());;
          $row_item = mysql_fetch_array($res_item);
         ?>
         <td align="left" style="padding-left:5px"><?=$row_item['name']?></td>
         <td align="center">
         <?
         $sql_uom = "select * from ms_uom where uom_id = '".$row_item['uom_id']."' ";
         $result_uom =mysql_query($sql_uom) or die (mysql_error());;
         $row_uom = mysql_fetch_array($result_uom);
         echo $row_uom['name'];
         ?>
         </td>
         <td align="center"><?=$row['required_quantity']?></td>
         <td align="center"><?=$row['pend_qty']?></td>
          <?
					if(($_REQUEST['byControl'])!='Item')
					{
						$flag=1;
						if($row['indent_id']!=$oldid)
						{
							$oldid = $row['indent_id'];
							$count=1;
						}
						$sql_tr="select * from ms_indent_transaction where indent_id='".$oldid."'";
						$res_tr=mysql_query($sql_tr);
						$row_count=mysql_num_rows($res_tr);
					}
					else
						$flag=0;
					if($flag==1)
					{
						if($count==1)
						{
							?>
							<td align="center" rowspan="<?=$row_count?>">
								<a href="maint_view_indent.php?indent_id=<?=$row["indent_id"]?>">
									<img src="images/search-icon.gif" alt="View" title="View" border="0" />
								</a>       
							</td>
							<?
							if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
							{
							?>
							<td align="center" rowspan="<?=$row_count?>">
								<a href="maint_add_indent.php?indent_id=<?=$row["indent_id"]?>&mode=edit">
									<img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
								</a>
							</td>
							<td align="center" rowspan="<?=$row_count?>">
								<a href="javascript:;" onClick="overlay(<?=$row["indent_id"]?>);">
									<img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
								</a>
							</td>
								<?
							}
							else
							{
							?>
							 <td rowspan="<?=$row_count?>"></td>
							 <td rowspan="<?=$row_count?>"></td>   
							<?
							}
						}
					}
					else
					{
						?>
             <td></td>
             <td></td>   
            <?
					}
					$count++;
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
        <td colspan="11" align="center" style="font-weight:bold">No Records Found</td>
      </tr>
    <?    
     }
  ?>
</table>

	      
			