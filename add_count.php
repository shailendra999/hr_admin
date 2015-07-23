<?
include("inc/adm0_header.php");
?>
<script type="text/javascript" src="javascript/form.js"></script>
<script type="text/javascript" src="javascript/popup.js"></script>
<script language="JavaScript1.2">
function validate_form(form)
{
	return(
				 checkString(form.elements["sel_prd"],"Select Product",false) &&
				 checkString(form.elements["txt_count"],"Enter Count",false)
		   );
}
</script>
<script type="text/javascript" src="ajax/common_function.js"></script>
<script>
function overlay(id) {

	el = document.getElementById("overlay");
	document.getElementById("hidden_overlay").value=id;
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
	
}
</script>
<?
//////////////////////// ************************** INSERT / UPDATE COUNT ************************ /////////////////////////

$msg = '';
$ProductId = "";
$editid = '';
$product_id = '';
$countnameid = '';
$stockinkg = '';
$stockinbale = '';
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
		$product = $_POST['sel_prd'];
		$countname = $_POST['txt_count'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$edit_id = $_POST['edit_id'];
		
		if($edit_id == '')
		{
			$sql_duply = "select * from ".$mysql_adm_table_prefix."count_master where ProductId = '$product' and Count = '$countname'";
			$result_duply = mysql_query($sql_duply) or die("Error in : ".$sql_duply."<br>".mysql_errno()." : ".mysql_error());	
			$duply_row = mysql_num_rows($result_duply);
			if($duply_row >=1)
			{
				$msg = "Count Already Exist In This Category And Product!!";
			}
			else
			{	
			
				$sql_ins = "insert into ".$mysql_adm_table_prefix."count_master set
																					ProductId = '$product',
																					Count = '$countname',
																					InsertBy = '$SessionUserType',
																					InsertDate = now(),
																					IpAddress = '$ip'";
				$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Count Successfully Inserted";
			}
			
		}
		else
		{
			$sql_up = "update ".$mysql_adm_table_prefix."count_master set
																			ProductId = '$product',
																			Count = '$countname'
																			where rec_id = '$edit_id'";
		   	$result_up = mysql_query($sql_up) or die("Error in : ".$sql_up."<br>".mysql_errno()." : ".mysql_error());
		   	$_SESSION['no_refresh'] = $_POST['no_refresh'];
		   	$msg = "Count Successfully Updated";		
		}	
	
	}
}
?>
<?
//////////// *************** Delete Product ************** ///////////////

if(isset($_POST["btn_del"]))
{
	$rec_id  = $_POST["hidden_overlay"];
	$sql = "delete from ".$mysql_adm_table_prefix."count_master where rec_id = '".$rec_id."'";
	mysql_query ($sql) or die ("Invalid query : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	$msg = "Count Sucessfully Deleted";
}	
?>
<?
//////////////****************** Select For Count Listing *****************//////////

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
/////////////////// ********************* Select For Count Edit *************** ///////////////

if(isset($_GET['editid']))
{
	$editid = $_GET['editid'];
	$sql_esel = "select * from ".$mysql_adm_table_prefix."count_master where rec_id = '$editid'";
	$result_esel = mysql_query($sql_esel) or die("Error in query:".$sql_esel."<br>".mysql_error().":".mysql_errno());
	$row_esel = mysql_fetch_array($result_esel);
	$product_id = $row_esel['ProductId'];
	$countnameid = $row_esel['Count'];
	$ProductId = $row_esel['ProductId'];
	
}
?>
<?
	
	if(isset($_POST['btn_submit_x']))
	{
		
		$ProductId = $_POST['sel_prd'];
		
	}
	if($ProductId !="")
	{
		$sql_prj = "select * from ".$mysql_adm_table_prefix."count_master where ProductId = '$ProductId' order by Count";
	}
	else
	{
		$sql_prj = "select * from ".$mysql_adm_table_prefix."count_master order by Count";
	}
	//$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."count_master where ProductId = '$ProductId' order by Count";
	//$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	//$query_count = $query_count;
	//$result = mysql_query($query_count);
	//$row_count = mysql_fetch_array($result);
	//$numrows = $row_count['count'];
	//$count = ceil($numrows/$row_limit);
?>

<table width="98%" cellpadding="0" cellspacing="0" align="center" border="0">
  <tr>
    	<td align="left" valign="top" width="230px" style="padding-top:5px;">
			<? include ("inc/adm0_snb.php"); ?>
        </td>
        
        <td style="padding-left:5px; padding-top:5px;" valign="top">
        	<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td align="center" class="gray_bg"><img src="images/bullet.gif" width="15" height="22"/> &nbsp; Add Count</td>
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
                                            <td align="center" valign="top" style="border:1px solid #C6B4AE;" bgcolor="#EAE3E1">
                                                <table align="center" width="60%" cellpadding="0" cellspacing="0" border="0">
                                                    <tr>
                                                        <td valign="middle" style="padding-top:10px;">
                                                            <form name="frm_addcount" id="frm_addcount" action="add_count.php" method="post" onsubmit="return validate_form(this);">
                                                            <table align="center" width="100%" cellpadding="2" cellspacing="2" border="0">
                                                                <tr>
                                                                    <td align="left" class="text_1"><b>Product Name</b></td>
                                                                    <td align="left">
                                                                      <select name="sel_prd" id="sel_prd" style="width:180px; height:20px;">
                                                                        <option value="">--Select--</option>
                                                                        <?
                                                                        $sqlprd = "select * from ".$mysql_adm_table_prefix."product_master where IsCount = '1' order by ProductName";
                                                                        $result_prd = mysql_query($sqlprd) or die("Error in Query : ".$sqlprd."<br/>".mysql_error()."<br/>".mysql_errno());
                                                                        if(mysql_num_rows($result_prd)>0)
                                                                        {
                                                                        while($row_prd = mysql_fetch_array($result_prd))
                                                                        {
                                                                        ?>       
                                                                        <option value="<?=$row_prd['rec_id']?>" <? if($row_prd['rec_id']==$product_id){?> selected="selected"<? } ?>><?=$row_prd['ProductName']?></option>
                                                                        <?
                                                                        }
                                                                        }
                                                                        ?>
                                                                        </select>
                                                                    </td>
                                                                    <td align="left" class="text_1" style="padding-left:15px;"><b>Count</b></td>
                                                                    <td align="left"><input type="text" name="txt_count" id="txt_count"  value="<?=$countnameid?>" style="width:150px; height:20px;"/></td>
                                                                </tr>
                                                                   
                                                                <tr>
                                                                    <td colspan="4" align="center" style="padding-top:5px;">
                                                                        <input type="image" src="images/btn_submit.png" name="btn_submit" id="btn_submit" value="submit" />
                                                                        <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                                                        <input type="hidden" name="edit_id" id="edit_id" value="<?=$editid?>" />
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
															<!--<?  
                                                            if(mysql_num_rows($result_prj)>0)
                                                            {
                                                                $sno = $start+1;
                                                            ?>
                                                            <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F5F2F1">
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
                                                            ?>-->
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
                                                                        <td width="6%" class="gredBg">S. No.</td>
                                                                   	  <td width="16%" class="gredBg">Product</td>
                                                                   	  <td width="20%" class="gredBg">Count</td>
                                                                      
                                                                   	  <td width="11%" class="gredBg">Edit</td>
                                                                   	  <td width="12%" class="gredBg">Delete</td>
                                                                  </tr>
																	<?
                                                                        while($row=mysql_fetch_array($result_prj))
                                                                        {	
                                                                    ?>
                                                                    <tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?> class="text_1">
                                                                        <td align="center"><?=$sno?></td>
                                                                        <td align="center"><?=getProduct('ProductName','rec_id',$row['ProductId'])?></td>
                                                                        <td align="center"><?=$row['Count']?></td>
                                                                        
                                                                       
                                                                        <td align="center"><a href="add_count.php?editid=<?=$row["rec_id"]?>">
                                                                        	<img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a>
                                                                        </td>
                                                                        <td align="center">
                                                                            <a href="javascript:;" onClick="overlay(<?=$row["rec_id"]?>);"><img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
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
          <p>Are you sure to delete this Count</p>
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
<? 
include("inc/footer.php");
?>