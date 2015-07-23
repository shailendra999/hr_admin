<?
include("inc/dbconnection.php");
include("inc/store_function.php");
include("inc/check_session.php");

if(date('m') > 03){	$gFinYear = date('Y').'-'.(date('Y')+1);	}else{	$gFinYear = (date('Y')-1).'-'.date('Y');	}
$WhereCondition = "";

$WhereCondition .= ($_POST["RGP_id"] != "") ? " and mrgm.RGP_GRN_id = '".$_POST["RGP_id"]."'" : "";

$WhereCondition .= ($_POST["supplier_id"] != "") ? " and mrgm.supplier_id = '".$_POST["supplier_id"]."'" : "";

$WhereCondition .= ($_POST["item_id"] != "") ? " and mrt.item_name like '%".$_POST["item_id"]."%'" : "";

$WhereCondition .= ($_POST["RGPGRNDate"] != "") ? " and mrgm.RGP_GRN_date BETWEEN '".getDateFormate($_POST["RGPGRNDate"])."'" : "";

$WhereCondition .= ($_POST["RGPGRN_end_Date"] != "") ? " and '".getDateFormate($_POST["RGPGRN_end_Date"])."'" : "";


$sql="select 
			mrgm.RGP_GRN_id,
			mrgm.RGP_GRN_date,
			mrgm.supplier_id,
			mrt.item_name,
			mrt.RGP_transaction_id,
			mrgm.RGP_id 
		from 
			ms_RGP_GRN_master mrgm,
			ms_RGP_GRN_transaction mrgt,
			ms_RGP_transaction mrt 
		where 
			mrgm.RGP_GRN_id=mrgt.RGP_GRN_id 
			and mrt.RGP_transaction_id=mrgt.RGP_transaction_id 
			and mrgm.finYear = '".$gFinYear."'
			".$WhereCondition." 
		order by 
			mrgm.RGP_GRN_id 
			asc";

//echo $sql;
//$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result=mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());

?> 
<div class="AddMore" style="padding-top:10px">
  	<form action="store_print_list_RGP_GRN.php" name="test" id="test" method="post" target="_blank"> 
    	<input type="hidden" name="RGP_id" id="RGP_id" value="<?=$_POST["RGP_id"]?>" />
        <input type="hidden" name="supplier_id" id="supplier_id" value="<?=$_POST["supplier_id"]?>" />
        <input type="hidden" name="RGPGRNDate" id="RGPGRNDate" value="<?=$_POST["RGPGRNDate"]?>" />
        <input type="hidden" name="RGPGRN_end_Date" id="RGPGRN_end_Date" value="<?=$_POST["RGPGRN_end_Date"]?>" />
        <input type="hidden" name="item_id" id="item_id" value="<?=$_POST["item_id"]?>" />
      	<a href="#" onclick="test.submit();">Print&nbsp;&nbsp;&nbsp;</a>
  	</form>
</div> 
<table align="center" width="100%" border="1" class="table1 text_1">
  <tr>
    <td class="gredBg">S.No.</td>
    <td class="gredBg">RGP GRN No.</td>
    <td class="gredBg">RGP GRN Date</td>
    <td class="gredBg">RGP No.</td>
    <td class="gredBg">Supplier</td>
    <td class="gredBg">Item Name</td>
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
    $sql_idate="select * from ms_RGP_GRN_master where insert_date='".date('Y-m-d')."' and RGP_GRN_id='".$row['RGP_GRN_id']."'";
    $res_idate=mysql_query($sql_idate);	
    $row_idate=mysql_fetch_array($res_idate);
    $insert_date=$row_idate['insert_date'];
    ?>
    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
      <td align="center"><?=$sno?></td>
      <td align="center"><?= $row['RGP_GRN_id']?></td>
      <td align="center"><?= getDateFormate($row['RGP_GRN_date'])?></td>
      <td align="center"><?= $row['RGP_id']?></td>
      <td align="left" style="padding-left:5px">
      <?
        $sql_S= "select * from ms_supplier where supplier_id='".$row['supplier_id']."'";
        $res_S = mysql_query ($sql_S) or die (mysql_error());
        $row_S = mysql_fetch_array($res_S);
        echo $row_S['name'];
      ?>
      </td>
      <td align="left" style="padding-left:5px">
      <?
      $sql_IN= "select mrt.item_name from ms_RGP_transaction mrt,ms_RGP_GRN_transaction mrgt where mrt.RGP_transaction_id='".$row['RGP_transaction_id']."' and mrt.RGP_transaction_id=mrgt.RGP_transaction_id";
      $res_IN = mysql_query ($sql_IN) or die (mysql_error());
      $row_IN = mysql_fetch_array($res_IN);
      echo $row_IN['item_name'];
      ?>
      </td>
      <td align="center">
        <a href="store_view_RGP_GRN.php?RGP_GRN_id=<?=$row["RGP_GRN_id"]?>">
        <img src="images/search-icon.gif" alt="View" title="View" border="0" />
        </a>
      </td>
			<?
      if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
      {
      ?>
      <td align="center">
        <a href="store_add_RGP_GRN.php?RGP_GRN_id=<?=$row["RGP_GRN_id"]?>&mode=edit">
        <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
        </a>
      </td>
      <td align="center">
        <a href="javascript:;" onClick="overlay(<?=$row["RGP_GRN_id"]?>,<?=$row["RGP_GRN_transaction_id"]?>);">
          <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
        </a>
      </td>
        <?
      }
      else
      {
      ?>
       <td></td>
       <td></td>   
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
      <tr><td align="center" colspan="9"><b>No Record Found.</b></td></tr>
    <?
  }	
 ?>         
</table>