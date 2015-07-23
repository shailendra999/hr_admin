<?
include("inc/adm0_header.php");
?>
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
<?
//////////////////////// ************************** INSERT CATEGORY ************************ /////////////////////////

$msg = '';
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
		$category_name = $_POST['txt_cat'];
		$ip = $_SERVER['REMOTE_ADDR'];
		
			$sql_duply = "select * from ".$mysql_adm_table_prefix."category_master where CategoryName = '$category_name'";
			$result_duply = mysql_query($sql_duply) or die("Error in : ".$sql_duply."<br>".mysql_errno()." : ".mysql_error());	
			$duply_row = mysql_num_rows($result_duply);
			if($duply_row >=1)
			{
				$msg = "Category Name Already Exist!!";
			}
			else
			{	
			
				$sql_ins = "insert into ".$mysql_adm_table_prefix."category_master set
																						CategoryName = '$category_name',
																						InsertBy = '$SessionUserType',
																						InsertDate = now(),
																						IpAddress = '$ip'";
				$result_ins = mysql_query($sql_ins) or die("Error in query:".$sql_ins."<br>".mysql_error().":".mysql_errno());
				$_SESSION['no_refresh'] = $_POST['no_refresh'];
				$msg = "Category Successfully Inserted";
			}	
	}
}
?>
<?
//////******************** Edit Category **************///////
if(isset($_POST['category_id']))
{
	$cat_id = $_POST["category_id"];
	$cat_name = $_POST["txt_catname"];
	
$sql_up = "update ".$mysql_adm_table_prefix."category_master set CategoryName='$cat_name' where rec_id= '$cat_id'";
$result_up = mysql_query($sql_up) or die ("Query Failed ".mysql_error());
	if($result_up)
	{
		$msg="Category Name Updated!!";
	}
	else
	{
		$msg="Error In Updating Category!!";
	}
}
?>
<?
////////**************** Delete category ********************* /////////
if(isset($_POST['catid']))
{
		$sql_del = "delete from ".$mysql_adm_table_prefix."category_master where rec_id='".$_POST["catid"]."'";
		$result_del = mysql_query($sql_del) or die ("Query Failed ".mysql_error());
		if($result_del)
		{
			$msg="Category Name Deleted!!";
		}
		else
		{
			$msg="Error In  Deleteting Category!!";
		}
}
?>
<?
//////////////****************** Select For Category Listing *****************//////////

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
	$sql_prj = "select * from ".$mysql_adm_table_prefix."category_master  order by CategoryName";
	$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."category_master ";
	$sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
	
	$result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
	
	$query_count = $query_count;
	$result = mysql_query($query_count);
	$row_count = mysql_fetch_array($result);
	$numrows = $row_count['count'];
	$count = ceil($numrows/$row_limit);
?>
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td>
        	<table width="80%" cellpadding="0" cellspacing="0" align="center" border="0">
                <tr>
                    <td height="500px" align="center" valign="top" class="tableborder">
                        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
                        	<tr>
                            	<td class="heading">Add Category</td>
                            </tr>
                            <tr>
                            	<td class="red"><?=$msg?></td>
                            </tr>
                            <tr>
                            	<td style="padding-top:10px;">
                                	<form name="frm_addcat" id="frm_addcat" action="" method="post">
                                	<table align="center" width="40%" cellpadding="0" cellspacing="0" style="border:#DFEAF7 solid 1px;">
                                    	<tr>
                                        	<td align="left" style="padding-left:25px;">Category Name</td>
                                            <td><input type="text" name="txt_cat" id="txt_cat" value="" /></td>
                                        </tr>
                                        <tr>
                                        	<td colspan="2" align="center" style="padding-top:5px;">
                                            	<input type="submit" name="btn_submit" id="btn_submit" value="submit" />
                                                <input name="no_refresh" type="hidden" id="no_refresh" value="<?php echo uniqid(rand()); ?>" />
                                            </td>
                                        </tr> 
                                    </table>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:5px;" align="left">
                                <?  
                                if(mysql_num_rows($result_prj)>0)
                                {
                                    $sno = $start+1;
                                ?>
                                    <table width="80%" align="center" cellpadding="0" cellspacing="0" border="0">
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
                            	<td>
							<?  
                            if(mysql_num_rows($result_prj)>0)
                            {
                                $sno = $start+1;
                            ?>
                                	<table align="center" width="80%" border="1" class="table1">
                                        <tr>
                                            <td width="7%" align="center"><span><b>S.No</b></span></td>
                                            <td width="58%" align="center"><span><b>Category Name</b></span></td>
                                            <td width="13%" align="center"><span><b>Edit</b></span></td>
                                            <td width="22%" align="center"><span><b>Delete</b></span></td>
                                      	</tr>
							 <?
                                while($row=mysql_fetch_array($result_prj))
                                {	
                            ?>
                                        <tr <? if ($sno%2==1) { ?> bgcolor="#DFEAF7" <? } ?>>
                                            <td align="center"><?=$sno?></td>
                                            <td align="center"><div id="dive<?=$row["rec_id"]?>"><?=$row['CategoryName']?></div><div id="divd<?=$row["rec_id"]?>"></div></td>
                                            <td align="center"><a href="javascript:;" onClick="get_frm('edit_cat.php','<?=$row["rec_id"]?>','dive<?=$row["rec_id"]?>','')"><img src="images/Modify.png" alt="Edit Category" title="Edit Category" border="0"></a></td>
                                            <td align="center"><?  if(checkProductAvailable($row['rec_id'])==1){?> <span class="red">Product Exists!!</span><? } else { ?>
                                              <a href="javascript:;" onClick="get_frm('delete_cat.php','<?=$row["rec_id"]?>','divd<?=$row["rec_id"]?>','')"><img src="images/Delete.png" alt="Delete Category" title="Delete Category" border="0" width="15" height="15"></a><? } ?>
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
<? 
include("inc/footer.php");
?>