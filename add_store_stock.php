<?
include("inc/store_header.php");
?>
<script type="text/javascript" src="ajax/common_function.js"></script>
<?
$msg = '';
$edit_id = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		//$special = array("\"","'");

		$ip = $_SERVER['REMOTE_ADDR'];
		$edit_id = $_POST['edit_id'];
		if($edit_id == '')
		{
				
				if(isset($_POST['stock_item'])){$count=count($_POST['stock_item']);}
				for($i=0; $i<$count; $i++)
				{
					$stock_item=$_POST['stock_item'][$i];
					$stock_qty=$_POST['stock_qty'][$i];	
					$unit=$_POST['unit'][$i];
					$description=$_POST['description'][$i];

				
					 $sql_2= "INSERT INTO ms_stock_master SET
															  item_name = '$stock_item',
															  quantiy = '$stock_qty',
															  quantity_unit = '$unit',
															  descriptions = '$description',																		
															  insert_date = now()";
					mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
				 }	
				
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Stock Successfully Inserted";
		}
		else
		{

					$stock_item=$_POST['stock_item'];
					$stock_qty=$_POST['stock_qty'];	
					$unit=$_POST['unit'];
					$description=$_POST['description'];
								
								$sql_2= "INSERT INTO ms_stock_request_item_master SET
																					  request_id = '$edit_id', 
																					  item_name = '$stock_item',
																					  quantiy = '$stock_qty',
																					  quantity_unit = '$unit',
																					  descriptions = '$description',																		
																					  insert_date = now()";
								mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());

		   $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   $msg = "Stock Successfully Updated";
		}   		
		
	}
}	
?>
<?
$request_no="";
$emp_id="";
$unit_id="";
$department ="";
$plant_id ="";
$editid="";
/////////////////// ********************* Select For Buyer Edit *************** ///////////////

if(isset($_GET['editid']))
{
	$editid = $_GET['editid'];
	$sql_esel = "select * from ms_stock_request_master where rec_id = '$editid'";
	$result_esel = mysql_query($sql_esel) or die("Error in query:".$sql_esel."<br>".mysql_error().":".mysql_errno());
	$row_esel = mysql_fetch_array($result_esel);
	$emp_id = $row_esel['emp_id'];
	$department = $row_esel['department'];
	$plant_id = $row_esel['plant_id'];
}
?>
<script>
function addElement() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var s_no=num+1;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
  newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td width='30%'><input name='stock_item[]' type='text' value='' style='width:180px;height:20px;' /></td><td width='30%' align = 'left'><input name='stock_qty[]' type='text' value='' style='width:150px;height:20px;' /><? $sql = "select * from ms_unit_master order by unit_name"; $result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());?><select name='unit[]' id='unit[]'>'<? while ($row=mysql_fetch_array($result)){?><option value='<?=$row['rec_id']?>'><?=$row["unit_name"]?></option><? }?></select></td><td width='30%' align='left'>	<textarea id='description[]' name='description[]' rows='3' cols='20'></textarea></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
  ni.appendChild(newdiv);

}
function removeElement(divNum,myDiv) 
{
	var d = document.getElementById(myDiv);
	var olddiv = document.getElementById(divNum);
    var num = (document.getElementById('h_hidden').value -1);
	d.removeChild(olddiv);
}
</script>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
    <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/store_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;">
        	<table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Add Stock</td>
                </tr>
                <tr>
                	<td valign="top" style="padding-top:10px;">
                    	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="red"><?=$msg?></td>
                             </tr>
                            <tr>
                                <td valign="top" style="padding-bottom:5px;">
                                    <form name="frm_request" id="frm_request" action="" method="post">
                                    <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                                        <tr>
                                        	<td align="center" valign="top" colspan="3">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                    	<td align="left" colspan="3" style="padding-top:3px;">
                                                            <table align="left" width="100%" cellpadding="1" cellspacing="0" class="border" border="0">
                                                                <tr class="text_2">
                                                                  	<td width="30%">Stock Item</td>
                                                                  	<td width="30%">Quantity</td>
                                                                  	<td width="30%">Description</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left">
                                                                    <input name="stock_item[]" id="stock_item[]" type="text" value="" style="width:180px; height:20px;"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    <input name="stock_qty[]" id="stock_qty[]" type="text" value="" style="width:150px; height:20px;"/>
                                                                     <?
																	 $sql = "SELECT * FROM ms_unit_master order by unit_name";
																	 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																 ?>
                                                                    <select name="unit[]" id="unit[]">
                                                                    	   <?
																			  while ($row=mysql_fetch_array($result))
																				{	?>
																					   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$unit_id){?> selected="selected" <? } ?>><?=$row["unit_name"]?></option>
																				<?  }	?>
                                                                     </select>
                                                                    </td>
                                                                    <td align="left">
                                                                  		<textarea id="description[]" name="description[]" rows="3" cols="20"></textarea>
                                                                    </td>  
                                                                    <td class="AddMore" style="padding-right:10px;">
                                                                     <input type="hidden" name="h_hidden" id="h_hidden"/> 
                                                                    <a href="javascript:;"  onclick="addElement();"><img src="images/add_icon.jpg" border="0"/></a>
                                                                    </td>
                                                                </tr>
                                                                <?                   
                                                                    if(isset($_GET['editid']))
                                                                    {
                                                                    $sql_1 = "select * from  ms_stock_request_item_master where request_id = '".$_GET["editid"]."' ";
                                                                    $result_1 = mysql_query($sql_1) or die("Error in sql : ".$sql_1." : ".mysql_errno()." : ".mysql_error());
                                                                    if(mysql_num_rows($result_1)>0)
                                                                    {
                                                                    while($row_1 = mysql_fetch_array($result_1))
                                                                    {
                                                                    
																	
																	$item_name = $row_1['item_name'];
                                                                    $quantiy = $row_1['quantiy'];
                                                                    $unit_id = $row_1['quantity_unit'];
                                                                    $descriptions = $row_1['descriptions'];
                                                                  
                                                                 ?>	
																<tr>
                                                                    <td align="left">
                                                                    <input name="stock_item[]" id="stock_item[]" type="text" style="width:180px; height:20px;" value="<?=$item_name?>"/>
                                                                    </td>
                                                                    <td align="left">
                                                                    <input name="stock_qty[]" id="stock_qty[]" type="text" style="width:150px; height:20px;" value="<?=$quantiy?>"/>
                                                                     <?
																	 $sql = "SELECT * FROM ms_unit_master order by unit_name";
																	 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																 ?>
                                                                    <select name="unit[]" id="unit[]">
                                                                    	   <?
																			  while ($row=mysql_fetch_array($result))
																				{	?>
																					   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$unit_id){?> selected="selected" <? } ?>><?=$row["unit_name"]?></option>
																				<?  }	?>
                                                                     </select>
                                                                    </td>
                                                                    <td align="left">
                                                                  		<textarea id="description[]" name="description[]" rows="3" cols="20"><?=$descriptions?></textarea>
                                                                    </td>  
                                                                </tr>
                                                                 <?
																			}
																		}
																	}		
																 
																 ?> 
                                                                <tr>
                                                                    <td colspan="7">
                                                                        <div id="myDiv1"></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                <td colspan="7" align="center" style="padding-top:5px;">
                                                                    <input type="submit" name="btn_submit" id="btn_submit" value="submit" />
                                                                    <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                    <input type="hidden" name="edit_id" id="edit_id" value="<?=$editid?>" />
                                                                </td>
                                                            </tr>
                                                             </table>       
                                                             </div>       
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    </form>
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