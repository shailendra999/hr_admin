<?
include("inc/maint_header.php");
?> 

<?

$Page = "maint_view_indent.php";
$PageTitle = "View Indent";$PageFor = "Indent";$PageKey = "indent_id";
$Message = '';$mode = '';
$indent_date = '';$indent_id = '';
$department_id = '';$approved_by = '';$indent_transaction_id = '';$item_id = ''
;$required_quantity = '';$due_date = '';$remark = '';$purpose  = '';
$PageKeyValue = "";

if(isset($_GET[$PageKey]))
{
	$sql = "select * from ms_indent_master where $PageKey = '".$_GET[$PageKey]."'";
	$result = mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row = mysql_fetch_array($result);
		$PageKeyValue = $row[$PageKey];$indent_id = $row[$PageKey];
		$indent_date = getDateFormate($row["indent_date"]);
		$department_id = $row["department_id"];
		$approved_by = $row["approved_by"];
	}
}

?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    <td align="left" valign="top" width="230px" style="padding-top:5px;">
    <? include ("inc/maint_snb.php"); ?>
    </td>
    <td style="padding-left:5px; padding-top:5px;" valign="top">
      <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
      	<tr>
         	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; View Purchase Indent</td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:10px;">
            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
              <tr>
                <td class="red"><?=$Message?></td>
              </tr>
              <tr>
                <td class="AddMore">
                   <a target="_blank" href="maint_print_indent.php?indent_id=<?= $PageKeyValue?>" title="Print">Print&nbsp;&nbsp;&nbsp;</a>
                </td>
              </tr>
              <tr>
                <td valign="top" style="padding-bottom:5px;">
                    <table width="100%" cellpadding="1" cellspacing="1" align="center" border="0" class="border">
                      <tr>
                        <td align="center" valign="top" class="border" width="100%" bgcolor="#EAE3E1">
                          <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border text_1">
                            <tr style="line-height:22px;background:#EAE3E1;">
                            	<td align="left"><b>Indent No.</b></td>
                            	<td align="left"><?=$indent_id?></td>
                              <td align="left"><b>Indent Date</b></td>
                              <td align="left"><?=$indent_date?></td>
                            </tr>
                            <tr style="line-height:22px;background:#FFFFFF;">
                              <td align="left"><b>Indent Department</b></td>
                              <td align="left">
                              <?
                              	$sql_dept="select * from ms_department where department_id='".$department_id."'";
																$res_dept = mysql_query ($sql_dept) or die (mysql_error());
																if(mysql_num_rows($res_dept)>0)
																{
																	$row_dept = mysql_fetch_array($res_dept);
																	echo $row_dept['name'];
																}
																?>
                              </td>
                              <td align="left"><b>Approved By</b></td>
                              <td align="left"><?=$approved_by?></td>
                            </tr>          
                            </table>
                        	</td>
                      	</tr>
                        <tr>
                          <td>
                            <div id="myDataBaseDiv">
                            <table align="center" width="100%" cellpadding="1" cellspacing="1" class="border" border="0">
                            <?
                            $sql_order_trans="SELECT * FROM ms_indent_master mom, ms_indent_transaction mot WHERE mom.indent_id = mot.indent_id AND mom.indent_id ='".$PageKeyValue."'";
                            $res_order_trans=mysql_query($sql_order_trans);
                            $countTrans=1;
                            $rc_trans=mysql_num_rows($res_order_trans);
                            if($rc_trans>0)
                            {
                            while($row_o_t=mysql_fetch_array($res_order_trans))
                            {
                              if($countTrans%2==0)
                                $tableColor="#eedfdc";
                              else
                                $tableColor="#f8f1ef";
                              $item_desc_trans='';$uname='';$stock='';$item_name='';
                              $item_id = $row_o_t['item_id'];
                              $sql = "SELECT * FROM  ms_item_master where item_id = '$item_id'" ;
                              $result_item = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
                              if(mysql_num_rows($result_item)>0)
                              {
                                $row_item = mysql_fetch_array($result_item);
                                ////Description////
                                $item_desc_trans= "Drg No.: ".$row_item['drawing_number'].';Cat No. '.$row_item['catelog_number'];
                                //////UOM /////////
                                $sql_uom = "SELECT name as uname FROM  ms_uom where uom_id = '".$row_item['uom_id']."' order by name ";
                                $result_uom = mysql_query ($sql_uom) or die ("Error in : ".$sql_uom."<br>".mysql_errno()." : ".mysql_error());
                                if(mysql_num_rows($result_uom)>0)
                                {
                                  $row_uom = mysql_fetch_array($result_uom);
                                  $uname= $row_uom['uname'];
                                }
                                //////// Stock /////////
                                $stock= $row_item['opening_quantity'];
																//////// Item Name/////////
																$item_name=$row_item['name'];
                              }
                            ?>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>S. No. </b></td> 
                                  <td align="center"><b>Item No.</b></td>
                                  <td align="center"><b>Item Name</b></td>
                                  <td align="center"><b>UOM</b></td>
                                  <td align="center"><b>Description</b></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><?=$countTrans?></td>
                                  <td align="center"><?=$item_id?></td>
                                  <td align="left" style="padding-left:5px"><?=$item_name?></td>                                	
                                  <td align="center"><?=$uname?></td>
                                  <td align="center"><?=$item_desc_trans?></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><b>Stock</b></td>  
                                  <td align="center"><b>Required Qty</b></td>        
                                  <td align="center"><b>Due Date</b></td>
                                  <td align="center"><b>Remarks</b></td>
                                  <td align="center"><b>Purpose</b></td>
                                </tr>
                                <tr class="text_tr" bgcolor="<?=$tableColor?>">
                                  <td align="center"><?=$stock?></td>
                                  <td align="center"><?=$row_o_t['required_quantity']?></td>
                                  <td align="center"><?=getDateFormate($row_o_t['due_date'])?></td>
                                  <td align="center"><?=$row_o_t['remark']?></td>
                                  <td align="center"><?=$row_o_t['purpose']?></td>
                                </tr>
                              
                            <?			
                            $countTrans++; 													 
                            } // end of while
                            }// end if	
                            ?>
                            </table>
                            </div>
                          </td>
                        </tr>
                    	</table>                       
                </td>
              </tr>
            </table> 
          </td>
        </tr>
    	</table>
		</td>
	</tr>
</table>

<? 
include("inc/footer.php");
?>                           