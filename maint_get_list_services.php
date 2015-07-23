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
	$sql="select * from maint_services where department_code ='".$id."' order by name asc";
}
else if(($_REQUEST['byControl'])=='Services')
{
	$sql="select * from maint_services where service_id ='".$id."' order by name asc";
}
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
          <td class="gredBg">Duration</td>
          <td width="4%" class="gredBg">View</td>
          <td width="4%" class="gredBg">Edit</td>
          <td width="4%" class="gredBg">Delete</td>
        </tr>	
        <?  
        if(mysql_num_rows($result)>0)
        {
          $sno =1;
          while($row=mysql_fetch_array($result))
          {	
            $sql_idate="select * from maint_services where insert_date='".date('Y-m-d')."' and service_id='".$row['service_id']."'";
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
            <td align="center">
              <? 
                $duration=$row['duration'];
                $duration_type=$row['duration_type'];
                $d_f='';
                if($duration_type=="M")
                  $d_t="Month(s)";
                else if($duration_type=="D")
                  $d_t="Day(s)";
                echo $duration.' '.$d_t;
              ?>
            </td>
            <td align="center">
              <a href="maint_view_services.php?service_id=<?=$row["service_id"]?>">
              <img src="images/search-icon.gif" alt="View" title="View" border="0" /></a>
            </td>
           <?
           if($SessionUserType=='Administrator' || (date('Y-m-d')==$insert_date))
           {
             $colspan=6;
            ?>
            <td align="center">
              <a href="maint_add_services.php?service_id=<?=$row["service_id"]?>&mode=edit">
                <img src="images/icon_edit.gif" alt="Edit" title="Edit" border="0" />
              </a>
            </td>
            <td align="center">
              <a href="javascript:;" onClick="overlay(<?=$row["service_id"]?>);">
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
                <td colspan="7" align="center"><b>No Records Found</b></td>
              </tr> 
              <?
          }
        ?>        
      </table>
    </td>
  </tr>
</table>