<? include ("inc/dbconnection.php");?>

<?
$id="";
$start=0;
$id = $_GET["id"];
$check = $_GET["str"];
if($check=="name")
	{
$sql = "SELECT * FROM  ".$mysql_table_prefix."employee_master where first_name like '$id%' order by first_name";
$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	$sql = "SELECT * FROM  ".$mysql_table_prefix."employee_master where ticket_no like '$id' order by first_name ";
	$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
if(mysql_num_rows($result)>0)
{
	while($row = mysql_fetch_array($result))
	{
		?>
		<div class="emp_snb expandable"><?=$row['first_name']?></div>
             <div class="categoryitems subLinks" style="height:auto;">
                         <div class="snb_sublink"><img src="images/red_bullet.png"/>
           				  <a href="javascript:;" onclick="get_frm('register_leave.php','<?=$row['rec_id']?>','div_detail',document.getElementById('year').value)">Leave Wages</a></div> 
             </div>
        <?
		}     
}
?>