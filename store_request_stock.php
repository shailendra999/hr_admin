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
		$request_no = addslashes($_POST['request_no']);
		$emp_id = addslashes($_POST['emp_id']);
		$department = $_POST['department'];
		$plant_name = $_POST['plant_name'];

		$ip = $_SERVER['REMOTE_ADDR'];
		$edit_id = $_POST['edit_id'];
		if($edit_id == '')
		{
				$sql_ins = "insert into ms_stock_request_master set
																	emp_id = '$emp_id',
																	department = '$department',
																	plant_id = '$plant_name',																	
																	insert_date = now()";
				$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
				
				$insert_id = mysql_insert_id();
				
				if(isset($_POST['stock_item'])){$count=count($_POST['stock_item']);}
				for($i=0; $i<$count; $i++)
				{
					$stock_item=$_POST['stock_item'][$i];
					$stock_qty=$_POST['stock_qty'][$i];	
					$unit=$_POST['unit'][$i];
					$description=$_POST['description'][$i];

				
					 $sql_2= "INSERT INTO ms_stock_request_item_master SET
					 													  request_id = '$insert_id', 
																		  item_name = '$stock_item',
																		  quantiy = '$stock_qty',
																		  quantity_unit = '$unit',
																		  descriptions = '$description',																		
																		  insert_date = now()";
					mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
				 }	
				
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Request Successfully Inserted";
		}
		else
		{
			$sql_up = "update ms_stock_request_master set
															emp_id = '$emp_id',
															department = '$department',
															plant_id = '$plant_name'	
															where rec_id = '$edit_id'";
		   $result_up = mysql_query($sql_up) or die("Error in : ".$sql_up."<br>".mysql_errno()." : ".mysql_error());
		   
		   $sql_del = "delete from ms_stock_request_item_master where request_id = '$edit_id' ";
		   $result_del = mysql_query($sql_del) or die("Error in Query: ".$sql_del."<br/>".mysql_error()."<br/>".mysql_errno());
		   
			
			if(isset($_POST['stock_item'])){$count=count($_POST['stock_item']);}
			for($k=0; $k<$count; $k++)
			{
					$stock_item=$_POST['stock_item'][$k];
					$stock_qty=$_POST['stock_qty'][$k];	
					$unit=$_POST['unit'][$k];
					$description=$_POST['description'][$k];
		   				if($stock_item!='' and $stock_qty!='' and $unit!='')
							{
								$sql_2= "INSERT INTO ms_stock_request_item_master SET
																					  request_id = '$edit_id', 
																					  item_name = '$stock_item',
																					  quantiy = '$stock_qty',
																					  quantity_unit = '$unit',
																					  descriptions = '$description',																		
																					  insert_date = now()";
								mysql_query($sql_2) or die("Error in query".mysql_errno().":".mysql_error());
							}
		   }
		   
		   $_SESSION['no_refresh'] = $_POST['no_refresh'];
		   $msg = "Request Successfully Updated";
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
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp;Request Stock</td>
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
                                            <td align="center" valign="top" class="border" width="40%">
                                            	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0" class="text_1">
                                                	<tr>
                                                    	<td align="left">Request No.</td>
                                                        <td align="left"><input type="text" name="request_no" id="request_no" value="<?=$request_no?>" /></td>
                                                    	<td align="left">Emp. Id.</td>
                                                        <td align="left"><input type="text" name="emp_id" id="emp_id" value="<?=$emp_id?>" />
                                                        </td>
                                                    	<td align="left">Department</td>
                                                        <td align="left">
                                                            <?
																 $sql = "SELECT * FROM mpc_department_master where reference_id='0' order by department_name";
																 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
																 ?>
															<select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
																<option value="">Select</option>
																 <?
															  while ($row=mysql_fetch_array($result))
																{	?>
																	   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$department){?> selected="selected" <? } ?>><?=$row["department_name"]?></option>
																<?  }	?>
															</select>
                                                        </td>
                                                    	<td align="left">Plant</td>
                                                        <td align="left">
                                                            <div id="div_city">
                                                    <?
                                                         $sql = "SELECT * FROM mpc_plant_master order by plant_name";
														 $result = mysql_query($sql) or die("Error in sql : ".$sql." : ".mysql_errno()." : ".mysql_error());
                                                     ?>
                                        		<select name="plant_name" id="plant_name" style="width:150px; height:20px;">
                                                	<option value="">Select</option>
                                                     <?
                                                  while ($row=mysql_fetch_array($result))
													{	?>
														   <option value="<?=$row['rec_id']?>" <? if($row['rec_id']==$plant_id
														){?> selected="selected" <? } ?>><?=$row["plant_name"]?></option>
													<?  }	?>
                                                </select>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                      </tr>
                                        <tr>
                                        	<td align="center" valign="top" colspan="3">
                                                <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td align="left" width="10px"><img src="images/tnb_left.jpg" width="10" height="35"/></td>
                                                        <td class="welcome_txt">
                                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td align="left" width="15%" class="orange_head">Requested Stock</td>
                                                                    <td align="center" width="5%"><img src="images/tnb_div_1.jpg" width="7" height="35"/></td>
                                                                    <td align="center" width="80%">&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td align="right" width="10px"><img src="images/tnb_right.jpg" width="10" height="35"/></td>
                                                    </tr>
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