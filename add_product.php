<? include ("inc/adm0_header.php"); ?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				 checkString(form.elements["txt_prd"],"Enter Product",false)										
		   );
}
</script>


<script type="text/javascript" src="ajax/common_function.js"></script>
<script language="javascript1.2">
function delete_div(div_id)
{
	var id= div_id;
	
	document.getElementById(id).innerHTML='';
}
function edit_div(div_id, value)
{
	var id= div_id;
	
	document.getElementById(id).innerHTML=value;
}
</script>
<script>
function overlay(id) {
	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
function hide_stock(id1,id2)
{
	var Iscount = document.getElementById(id2).checked;
	if(Iscount == true)
	{
		document.getElementById(id1).style.display='none';
		document.getElementById(id2).value = '1';
	}
	else if(Iscount == false)
	{
		document.getElementById(id1).style.display='block';
		document.getElementById(id2).value = '0';
	}
}
</script>
<?
//////////////////////// ************************** INSERT / UPDATE PRODUCT ************************ /////////////////////////

$msg = '';
if(!session_is_registered("no_refresh"))
{
	$_SESSION['no_refresh'] = "";
}
if(isset($_POST['btn_submit_x']))
{
	if($_POST['no_refresh'] == $_SESSION['no_refresh'])
	{	
		//echo "WARNING: Do not try to refresh the page.";
	}
	else
	{
		$product = $_POST['txt_prd'];
		$stockinkg = $_POST['txt_stockkg'];
		$stockinbale = $_POST['txt_stockbale'];
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$sql_duply = "select * from ".$mysql_adm_table_prefix."product_master where ProductName = '$product'";
		$result_duply = mysql_query($sql_duply) or die("Error in : ".$sql_duply."<br>".mysql_errno()." : ".mysql_error());	
		$duply_row = mysql_num_rows($result_duply);
		if($duply_row >=1)
		{
			$msg = "Product Already Exist !!";
		}
		else
		{	
			if(isset($_POST["chk_iscount"]))
			{
			
				$sql_ins = "insert into ".$mysql_adm_table_prefix."product_master set
																					ProductName = '$product',
																					StockInKgs = '0',
																					StockInBale = '0',
																					IsCount = '".$_POST["chk_iscount"]."',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
				$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Product Successfully Inserted";
			}
			else
			{
				$sql_ins = "insert into ".$mysql_adm_table_prefix."product_master set
																					ProductName = '$product',
																					StockInKgs = '$stockinkg',
																					StockInBale = '$stockinbale',
																					IsCount = '0',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
				$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Product Successfully Inserted";
			}
				
		}
	
	 }
}
?>
<?
//////******************** Edit Product **************///////
if(isset($_POST['product_id']))
{
	$prd_id = $_POST["product_id"];
	$prd_name = $_POST["txt_prdname"];
	$chk_iscount_edit = (isset($_POST["chk_iscount_edit_".$prd_id])) ? $_POST["chk_iscount_edit_".$prd_id] : 0;
	$txt_stockkg = (isset($_POST["chk_iscount_edit_".$prd_id])) ? "" : $_POST["txt_stockkg"];
	$txt_stockbale = (isset($_POST["chk_iscount_edit_".$prd_id])) ? "" : $_POST["txt_stockbale"];
	
	$sql_up = "update ".$mysql_adm_table_prefix."product_master set 
																	ProductName = '$prd_name',
																	StockInKgs = '$txt_stockkg' ,
																	StockInBale = '$txt_stockbale' ,
																	IsCount = '$chk_iscount_edit' 
																	where rec_id= '$prd_id'";
	
	//echo $sql_up;
	$result_up = mysql_query($sql_up) or die ("Query Failed ".mysql_error());
	if($result_up)
	{
		$msg="Product Name Updated!!";
	}
	else
	{
		$msg="Error In Updating Product!!";
	}
}
?>
<?
//////////// *************** Delete Product ************** ///////////////
if(isset($_POST['prdid']))
{
	$sql_del = "delete from ".$mysql_adm_table_prefix."product_master where rec_id='".$_POST["prdid"]."'";
	$result_del = mysql_query($sql_del) or die ("Query Failed ".mysql_error());
	if($result_del)
	{
		$msg="Product Name Deleted!!";
	}
	else
	{
		$msg="Error In  Deleteting Product!!";
	}
}
?>
<?
//////////////****************** Select For Product Listing *****************//////////

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
?>
<?
	$sql_prj = "select * from ".$mysql_adm_table_prefix."product_master order by ProductName";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."product_master ";
	$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	$query_count = $query_count;
	$result = mysql_query($query_count);
	$row_count = mysql_fetch_array($result);
	$numrows = $row_count['count'];
	$count = ceil($numrows/$row_limit);
?>
<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Product</td>
                </tr>
                <tr>
               	  <td valign="top">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                              <td style="padding-top:5px;" valign="top">
                                    <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                        <tr>
                                        	<td class="red"><?=$msg?></td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top">
                                                <table align="center" width="40%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                    <tr>
                                                        <td valign="middle" style="padding-top:10px;">
                                                            <form name="frm_addproduct" id="frm_addproduct" action="" method="post" onsubmit="return validate_form(this);">
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                                                                <tr>
                                                                    <td width="29%" align="left" class="text_1" style="padding-left:15px;"><b>Product&nbsp;Name</b></td>
                                                                    <td width="48%" align="left"><input type="text" name="txt_prd" id="txt_prd" value="" style="width:200px;"/></td>
                                                                </tr>
                                                                <tr>
                                                                	<td align="left" class="text_1" style="padding-left:15px;"><b>Is&nbsp;Count</b></td>
                                                                    <td align="left"><input type="checkbox" name="chk_iscount" id="chk_iscount" value="" onClick="hide_stock('div_stock','chk_iscount');" /></td>
                                                                <tr>
                                                                    <td colspan="2">
                                                                    	<div id="div_stock" style="display:block;">
                                                                        	<table width="100%">
                                                                        		<tr>
                                                                                    <td width="38%" align="left" class="text_1" style="padding-left:15px;"><b>Stock</b></td>
                                                                                  <td width="62%" align="left"><input type="text" name="txt_stockkg" id="txt_stockkg" value="" /><span class="text_1"> &nbsp;<b>kg</b></span></td>
                                                                   			  </tr>
                                                                              <tr>
                                                                                    <td width="38%" align="left" class="text_1" style="padding-left:15px;"><b>Stock</b></td>
                                                                                  <td width="62%" align="left"><input type="text" name="txt_stockbale" id="txt_stockbale" value="" /><span class="text_1"> &nbsp;<b>bale</b></span></td>
                                                                   			  </tr>
                                                                        	</table>
                                                                        </div>
                                                                    </td>
                                                                </tr>        
                                                                <tr>    
                                                                    <td width="24%" colspan="2" align="center" style="padding-top:5px;">
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="Submit" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                  </td>
                                                                </tr> 
                                                            </table>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                       	  <td align="center" style="padding-top:5px;">
                                           	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
                                                    <tr>
                                                        <td align="left">
                                                        <?  
                                                        if(mysql_num_rows($result_prj)>0)
                                                        {
                                                            $sno = $start+1;
                                                        ?>
                                                          <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
                                                                <tr class="navigation_row">
                                                                    <td class="headingSmall">
                                                                        <div style="margin:1px;text-align:left;" >
                                                                        <?
                                                                        if(!$count==0)
                                                                        {
                                                                        ?>
                                                                            <?=$numrows?> results found, page <?=($start/$row_limit)+1?> of <?=$count?>
                                                                        <?
                                                                        }
                                                                        ?>
                                                                        </div>
                                                                    </td>
                                                                    <td align="right">
                                                                        <div style="margin:1px;">
                                                                        <?
                                                                        if(!$count==0)
                                                                        {
                                                                        ?>
                                                                            <a href="<?=$_SERVER['PHP_SELF']?>?start=0" style="font-size:10px"><strong>First</strong></a>|
                                                                        <?
                                                                        }
                                                                        ?>
                                                                        <?
                                                                        if($start > 0)
                                                                        {
                                                                        ?>
                                                                            <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start - $row_limit)?>" style="font-size:10px"><strong>Previous</strong></a>|
                                                                        <?
                                                                        }
                                                                        if($numrows > ($start + $row_limit)) 
                                                                        {
                                                                        ?>
                                                                            <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($start + $row_limit)?>" style="font-size:10px"><strong>Next</strong></a>|
                                                                        <?
                                                                        }
                                                                        ?>
                                                                        <?
                                                                        if(!$count==0)
                                                                        {
                                                                        ?>
                                                                            <a href="<?=$_SERVER['PHP_SELF']?>?start=<?=($count-1) * $row_limit?>" style="font-size:10px"><strong>Last</strong></a>
                                                                        <?
                                                                        }
                                                                        ?> 
                                                                        </div>
                                                                    </td>	 
                                                                </tr>
                                                          </table>
														   <?
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                      <td align="center">
															<?  
                                                            if(mysql_num_rows($result_prj)>0)
                                                            {
                                                                $sno = $start+1;
                                                            ?>
                                                        <table align="center" width="100%" border="1" class="table1" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td width="8%" class="gredBg">S. No.</td>
                                                                    <td width="60%" class="gredBg">Product</td>
                                                                    <td width="17%" class="gredBg">Edit</td>
                                                                    <td width="20%" class="gredBg">Delete</td>
                                                          		</tr>
																<?
                                                                    while($row=mysql_fetch_array($result_prj))
                                                                    {	
                                                                ?>
                                                                <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                    <td align="center"><?=$sno?></td>
                                                                    <td align="center">
                                                                    	<div id="dive<?=$row["rec_id"]?>"><?=$row['ProductName']?></div><div id="divd<?=$row["rec_id"]?>"></div>
                                                                    </td>
                                                                    <td align="center">
                                                                        <a href="javascript:;" onClick="get_frm('edit_product.php','<?=$row["rec_id"]?>','dive<?=$row["rec_id"]?>','')">
                                                                        <img src="images/Modify.png" alt="Edit" title="Edit" border="0">
                                                                        </a>
                                                                    </td>
                                                                    <td align="center">
                                                                      <?  if(checkCountAvailable($row['rec_id'])==1){?> <span class="red">Count Exists!!</span><? } else { ?>
                                                                      <a href="javascript:;" onClick="get_frm('delete_product.php','<?=$row["rec_id"]?>','divd<?=$row["rec_id"]?>','')">
                                                                      <img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a><? } ?>
                                                                    </td>
                                                                </tr>
                                                    <?
                                                         $sno++;
                                                        }	
                                                    ?>         
                                                        </table>
                                                        <?
                                                        }
                                                        ?>        
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
        </td>
    </tr>
</table>
<div id="overlay">
     <div class="form_msg">
          <p>Are you sure to delete this Product</p>
		  <form name="frm_del" action="<?=$_SERVER['PHP_SELF']?>" method="post">
		  <input type="hidden" name="hidden_overlay" id="hidden_overlay" value="" />
		  <input type="submit" name="btn_del" value="Yes" />
		  <input type="button" onClick="overlay();" name="btn_close" value="No" />
		  </form>
     </div>
</div>
<DIV id=modal style="DISPLAY: none;">
  <div style="padding: 0px; background-color: rgb(37, 100, 192); visibility: visible; position: relative; width: 222px; height: 202px; z-index: 10002; opacity: 1;">
    <div onClick="Popup.hide('modal')" style="padding: 0px; background: transparent url(./images/close.gif) no-repeat scroll 0%; visibility: visible; position: absolute; left: 201px; top: 1px; width: 20px; height: 20px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: pointer; z-index: 10004;" id="adpModal_close"></div>
    <div style="padding: 0px; background: transparent url(resize.gif) no-repeat scroll 0%; visibility: visible; position: absolute; width: 9px; height: 9px; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial; cursor: nw-resize; z-index: 10003;" id="adpModal_rsize"></div>
    <div style="padding: 0px; overflow: hidden; background-color: rgb(140, 183, 231); visibility: visible; position: absolute; left: 1px; top: 1px; width: 220px; height: 20px; font-family: arial; font-style: normal; font-variant: normal; font-weight: bold; font-size: 9pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(15, 15, 15); cursor: move;" id="adpModal_adpT"></div>
    <div style="border-style: inset; border-width: 0px; padding: 8px; overflow: hidden; background-color: rgb(118, 201, 238); visibility: visible; position: absolute; left: 1px; top: 21px; width: 204px; height: 164px; font-family: MS Sans Serif; font-style: normal; font-variant: normal; font-weight: bold; font-size: 11pt; line-height: normal; font-size-adjust: none; font-stretch: normal; color: rgb(28, 94, 162);" id="adpModal_adpC">
      <center>
        <p>
        <div id="div_message"></div>
        </p>
        <p style="font-size: 10px; color: rgb(253, 80, 0);">To gain access to the page behind the popup must be closed</p>
      </center>
    </div>
  </div>
</DIV>
<? include ("inc/footer.php"); ?>