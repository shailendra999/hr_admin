<? include ("inc/dbconnection.php");?>

<?
$id="";
$start=0;
$id = $_GET["id"];
$check = $_GET["str"];
if($check=="name")
	{
$sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  ".$mysql_table_prefix."employee_master ,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and first_name like '$id%' order by first_name";
$sql = $sql ." LIMIT " . $start . ", $row_limit";
$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	}
	else
	{
	$sql = "SELECT mpc_employee_master.*,mpc_account_detail.emp_id,mpc_account_detail.date_releaving FROM  ".$mysql_table_prefix."employee_master,mpc_account_detail where mpc_employee_master.rec_id=mpc_account_detail.emp_id and mpc_account_detail.date_releaving ='0000-00-00' and  ticket_no like '$id' order by first_name ";
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
           				  <a href="javascript:;" onclick="get_frm('leave_yearly_detail.php','<?=$row['emp_id']?>','div_detail',document.getElementById('year').value)">Yearly Detail</a></div>
             </div>
        <?
		}     
}
?>