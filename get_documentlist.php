<? include ("inc/dbconnection.php");?>
<?
$id="";
$add_div = "";
$hidden_value = "";
$id = $_GET["id"];
$add_div = $_GET["str"];
$hidden_value = $_GET["str4"];
?>
<?
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

$sql = "SELECT * FROM  ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id' order by DocumentName";
$query_count = "select count(*) as count from ".$mysql_adm_table_prefix."document_master where DocumentFor = '$id'";

$result_doc = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
$query_count = $query_count;
$result_q= mysql_query($query_count);
$row_count = mysql_fetch_array($result_q);
$numrows = $row_count['count'];
$count = ceil($numrows/$row_limit);
if(mysql_num_rows($result_doc)>0)
{
	$sno = 1;
?>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr class="navigation_row">
        <td class="headingSmall">
            <div style="margin:1px;text-align:left;" >
                <?
                if(!$count==0)
                {
                ?>
                    <?=$numrows?> results found
                <?
                }
                ?>
            </div>
        </td>
        <td>
        	<div class="AddMore" align="right">
				<a href="javascript:;" onClick="show_div('<?=$add_div?>','<?=$id?>','<?=$hidden_value?>')"><img src="images/add_icon.jpg" border="0" alt="Add Documents" title="Add Documents" /></a>
			</div>
        </td>    
    </tr>
</table> 
<div> 
    <table align="center" width="100%" border="1" class="table1 text_1">
        <tr>
            <td width="7%" class="gredBg"><span><b>S.No</b></span></td>
            <td width="21%" class="gredBg"><span><b>Document For</b></span></td>
            <td width="46%" class="gredBg"><span><b>Document Name</b></span></td>
            <td width="14%" class="gredBg"><span><b>Edit</b></span></td>
            <td width="12%" class="gredBg"><span><b>Delete</b></span></td>
        </tr>
<?
	while($row_doc = mysql_fetch_array($result_doc))
	{
?>
		<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
            <td align="center"><?=$sno?></td>
            <td align="center"><?=$row_doc['DocumentFor']?></td>
            <td align="center"><div id="dive<?=$row_doc["rec_id"]?>"><?=$row_doc['DocumentName']?></div><div id="divd<?=$row_doc["rec_id"]?>"></div></td>
            <td align="center">
            <a href="javascript:;" onClick="get_frm('edit_document.php','<?=$row_doc["rec_id"]?>','dive<?=$row_doc["rec_id"]?>','')"><img src="images/Modify.png" alt="Edit" title="Edit" border="0"></a></td>
            <td align="center">
              <a href="javascript:;" onClick="get_frm('delete_doc.php','<?=$row_doc["rec_id"]?>','divd<?=$row_doc["rec_id"]?>','')"><img src="images/Delete.png" alt="Delete" title="Delete" border="0"></a>
            </td>
        </tr>
<?
	 $sno++;
	}
?>            	    
</table>
</div>
<?    	
}
else
{
?>
	<div class="AddMore" align="right">
	<a href="javascript:;" onClick="show_div('<?=$add_div?>','<?=$id?>','<?=$hidden_value?>')"><img src="images/add_icon.jpg" border="0" alt="Add Documents" title="Add Documents" /></a>
	</div>
	<div align="center" class="red">no record found</div>
	
<?
}
	
?>	
          			