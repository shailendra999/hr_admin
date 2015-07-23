<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}

$WhereCondition = "";

$WhereCondition .= ($_POST["RGP_id"] != "") ? " and mm.RGP_id = '".$_POST["RGP_id"]."'" : "";

$WhereCondition .= ($_POST["supplier_id"] != "") ? " and mm.supplier_id = '".$_POST["supplier_id"]."'" : "";

$WhereCondition .= ($_POST["RGPDate"] != "") ? " and mm.RGP_date = '".getDateFormate($_POST["RGPDate"])."'" : "";

$WhereCondition .= ($_POST["item_id"] != "") ? " and mt.item_name like '%".$_POST["item_id"]."%'" : "";

$WhereCondition .= ($_POST["department_id"] != "") ? " and mt.department_id = '".$_POST["department_id"]."'" : "";


$sql="select 
			mm.RGP_id,
			mm.RGP_date,
			mm.supplier_id,
			mt.item_name,
			mt.quantity,
			mt.pend_qty 
		from 
			ms_RGP_master mm,
			ms_RGP_transaction mt 
		where 
			mm.RGP_id=mt.RGP_id 
			and mm.finYear = '".$gFinYear."'
			".$WhereCondition."
		order by 
			mm.RGP_id 
			asc";


//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?> 
<div class="AddMore" style="padding-top:10px">
	<form action="store_print_RGP_list.php" name="test" id="test" method="post" target="_blank"> 
    	<input type="hidden" name="RGP_id" id="RGP_id" value="<?=$_POST["RGP_id"]?>" />
        <input type="hidden" name="supplier_id" id="supplier_id" value="<?=$_POST["supplier_id"]?>" />
        <input type="hidden" name="RGPDate" id="RGPDate" value="<?=$_POST["RGPDate"]?>" />
        <input type="hidden" name="item_id" id="item_id" value="<?=$_POST["item_id"]?>" />
        <input type="hidden" name="department_id" id="department_id" value="<?=$_POST["department_id"]?>" />
    	<a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
 	</form>
</div>
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">RGP No.</td>
    <td class="gredBg">RGP Date</td>
    <td class="gredBg">Supplier</td>
    <td class="gredBg">Item Name</td>
    <td class="gredBg">RGP Qty.</td>
    <td class="gredBg">Pend Qty.</td>
    <td width="4%" class="gredBg">View</td>  
    <td width="4%" class="gredBg">Edit</td>
    <td width="4%" class="gredBg">Delete</td>
 </tr>	
  <?  
  if(mysql_num_rows($result)>0)
  {
    $sno = 1;$oldid = "";$count =1;$flag=0;
    while($row=mysql_fetch_array($result))
    {	
     $sql_idate="select * from ms_RGP_master where insert_date='".date('Y-m-d')."' and RGP_id='".$row['RGP_id']."'";
      $res_idate=mysql_query($sql_idate);	
      $row_idate=mysql_fetch_array($res_idate);
      $insert_date=$row_idate['insert_date'];
      ?>
      <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
        <td align="center"><?=$sno?></td>
        <td align="center"><?= $row['RGP_id']?></td>
        <td align="center"><?=getDateFormate($row['RGP_date']);?></td>
        <td align="left" style="padding-left:5px">
        <?
          $sql_sup= "select * from ms_supplier where supplier_id='".$row['supplier_id']."' ";
          $res_sup = mysql_query ($sql_sup) or die ("Invalid query : ".$sql_sup."<br>".mysql_errno()." : ".mysql_error());
          $row_sup = mysql_fetch_array($res_sup);
          echo $row_sup['name'];
         ?>
        </td>
        <td align="left" style="padding-left:5px"><?= $row['item_name']?></td>
        <td align="center"><?= $row['quantity']?></td>
        <td align="center"><?= $row['pend_qty']?></td>
        <?
																			if($row['RGP_id']!=$oldid)
																			{
																				$oldid = $row['RGP_id'];
																				$count=1;
																			}
																			$sql_tr="select * from ms_RGP_transaction where RGP_id='".$oldid."'";
																			$res_tr=mysql_query($sql_tr);
																			$row_count=mysql_num_rows($res_tr);
																			if($count==1)
																			{
																				?>
                                         <td align="center" rowspan="<?=$row_count?>">
                                           <a href="store_view_RGP.php?RGP_id=<?=$row["RGP_id"]?>">
                                            <img src="images/search-icon.gif" alt="View" title="View" border="0" />
                                           </a>
                                          </td> 
                                        <?
																				if(1)
																				{
																				//$SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date)
																				?>
                                        <td align="center" rowspan="<?=$row_count?>">
                                          <a href="store_add_RGP.php?RGP_id=<?=$row["RGP_id"]?>&mode=edit">
                                            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                                          </a>
                                        </td>
                                        <td align="center" rowspan="<?=$row_count?>">
                                          <a href="javascript:;" onClick="overlay(<?=$row["RGP_id"]?>);">
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
																			$count++;
                                    ?>
        <?
        if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
        {
        ?>
        <td align="center">
          <a href="store_add_RGP.php?RGP_id=<?=$row["RGP_id"]?>&mode=edit">
            <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
          </a>
        </td>
        <td align="center">
          <a href="javascript:;" onClick="overlay(<?=$row["RGP_id"]?>);">
          <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
          </a>
        </td>
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
      <tr><td align="center" colspan="10"><b>No Record Found.</b></td></tr>
    <?
  }
  ?>
</table>      
    