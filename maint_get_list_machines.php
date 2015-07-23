<?

include("inc/check_session.php");

include("inc/dbconnection.php");
include("inc/common_function_mt_elect.php");
?>

<?
$id='';
if(isset($_REQUEST["value"]))
	$id = $_REQUEST["value"];
else
	$id = '';
	$sql='';
if(($_REQUEST['byControl'])=='Department')
{
	$sql="select * from maint_machine_master where department_code ='".$id."' order by name asc";
}
else if(($_REQUEST['byControl'])=='Machines')
{
	$sql="select * from maint_machine_master where machine_id ='".$id."' order by name asc";
}
//echo $sql;
$result=mysql_query($sql);

?>
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" class="tableborder">
  <tr>
    <td valign="top">
      <table align="center" id="tableEntry" width="100%" border="1" class="table1 text_1">
        <tr>
          <td class="gredBg">S.No.</td>
          <td class="gredBg">Department</td>
          <td class="gredBg">Name</td>
          <td class="gredBg">Make</td>
          <td class="gredBg">Serial No.</td>
          <td width="4%" class="gredBg">View</td>
          <td width="4%" class="gredBg">New</td>
          <td width="4%" class="gredBg">Edit</td>
          <td width="4%" class="gredBg">Delete</td>
        </tr>	
				<?  
        if(mysql_num_rows($result)>0)
        {
					$sno =1;
					while($row=mysql_fetch_array($result))
					{	
						$sql_idate="select * from maint_machine_master where insert_date='".date('Y-m-d')."' and machine_id='".$row['machine_id']."'";
						$res_idate=mysql_query($sql_idate);
						$row_idate=mysql_fetch_array($res_idate);
						$insert_date=$row_idate['insert_date'];
						?>
						<tr <? if ($sno%2==1) { ?> bgcolor="#F5F2F1" <? } ?>>
              <td align="center"><?=$sno?></td>
              <td align="left" style="padding-left:5px">
              <?
								$sql_dep = "select * from maint_department where department_code = '".$row['department_code']."' ";
								$res_dep = mysql_query($sql_dep) or die ("Invalid query : ".$sql_dep."<br>".mysql_errno().":".mysql_error());
								$row_dep = mysql_fetch_array($res_dep);
								echo $row_dep['name'];
              ?>	
              </td>
              <td align="left" style="padding-left:5px"><?= $row['name']?></td>
              <td align="center"><?= $row['make_machine']?></td>
              <td align="center"><?= $row['machine_serial_no']?></td>
              <td align="center">
                <a href="maint_view_machines.php?machine_code=<?=$row["machine_code"]?>">
                <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
              </td>
              <td align="center">
                <a href="maint_add_machines.php?machine_code=<?=$row["machine_code"]?>&mode=new">
                  <img src="images/flag_new.gif" alt="New" title="New" border="0" />
                </a>
              </td>
              
							<?
              if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
              {
              $colspan=6;
              ?>
                <td align="center">
                  <a href="maint_add_machines.php?machine_code=<?=$row["machine_code"]?>&mode=edit">
                  <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
                </a>
                </td>
                <td align="center">
                  <a href="javascript:;" onClick="overlay(<?=$row["machine_id"]?>);">
                  <img src="images/delete_icon.gif" alt="Delete" title="Delete" border="0">
                </a>
                </td>
							<?
              }
              else
              {
              ?>
                <td align="center"></td>
                <td align="center"></td>
							<?
              }
              ?>
					</tr>
						<?
						$sno++;
						}	
        	}
					else
					{
					?>
            <tr>
            	<td colspan="8" align="center"><b>No Records Found</b></td>
            </tr> 
					<?
					}
        ?>        
      </table>
    </td>
  </tr>
</table>