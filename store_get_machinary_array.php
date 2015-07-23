<?
include_once("inc/dbconnection.php");
?>
<select name="machinary_id[]" id="machinary_id[]" style="width:100%">
   <?
	
	$machinary_id = '';
	$select_machinary= "select * from ms_machinary where department_id=$_REQUEST[id]";
	$result_machinary = mysql_query ($select_machinary) or die ("Invalid query : ".$select_machinary."<br>".mysql_errno()." : ".mysql_error());
        if(mysql_num_rows($result_machinary)>0)
        {
            while($row_machinary = mysql_fetch_array($result_machinary))
            {
    ?>
    <option value="<?php echo $row_machinary['machinary_code']; ?>" <? if($row_machinary['machinary_code']=$machinary_id){ ?> selected="selected"<? }?> ><?php echo $row_machinary['name']; ?></option>
    <?php
            }
        }	
    ?>		
</select>