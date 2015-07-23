<? session_start();?>
<? $pgName = "BuyersList"; ?>

<? include ("inc/header.php"); ?>
<table width="1000" cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
        <td width="1000" bgcolor="#FFFFFF">
        	<table width="1000" cellpadding="0" cellspacing="0" border="0" align="center">
            	<tr>
                	<td align="center"><img src="images/HeadBuyerList.jpg" width="960" height="130"/></td>
                </tr>
                <tr>
                	<td style="padding-top:10px;" align="center" colspan="6"><img src="images/pageBgBottom.jpg" width="1000" height="10"/></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td style="padding-top:5px;">
        	<table width="1000" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF">
            	<tr>
                	<td align="left" valign="top"><img src="images/gredBgLeft.jpg" width="10" height="50"/></td>
                    <td align="center" class="gredBg">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="loginPadding">
                        	<tr>
                            	<td align="center" valign="top">
                                	<table align="center" width="100%" cellpadding="2" cellspacing="2" border="0">
                                        <tr>
                                            <td class="blueHead">Leave Application Management</td>
                                        </tr>
                                        <tr>
                                        	<td class="auctionList1">
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
                                            
                                                 $sql_prj = "select * from ".$mysql_table_prefix."leave_application";
                                                $query_count = "select count(*) as count from ".$mysql_table_prefix."buyer_list ";
                                                $sql_prj = $sql_prj ." LIMIT " . $start . ", $row_limit";
                                                
                                                $result_prj = mysql_query($sql_prj) or die("Error in Query :".$sql_prj."<br>".mysql_error().":".mysql_errno());
                                                
                                                $query_count = $query_count;
                                                $result = mysql_query($query_count);
                                                $row_count = mysql_fetch_array($result_prj);
                                                $numrows = $row_count['count'];
                                                $count = ceil($numrows/$row_limit);
                                            ?>
                                            <table width="100%" cellpadding="0" cellspacing="0" align="center" border="0">
                                                <tr>
                                                    <td>
                                                    <?  
                                                    if(mysql_num_rows($result_prj)>0)
                                                    {
                                                    $sno = $start+1;
                                                    ?>
                                                        <table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            <tr class="navigation_row">
                                                                <td align="left">
                                                                    <div style="margin:2px;" class="button">
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
                                                                    <div style="margin:2px;" class="button">
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
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table align="center" width="90%" style="border:#999999 solid 1px;" cellpadding="1" cellspacing="1">
                                                            <tr>
                                                                <td width="5%" class="h_text" bgcolor="#E2EBF0"><b>S.No</b></td>
                                                                <td class="h_text" bgcolor="#E2EBF0"><b>Company Name</b></td>
                                                                <td class="h_text" bgcolor="#E2EBF0"><b>Address</b></td>
                                                                <td class="h_text" bgcolor="#E2EBF0"><b>Contact Detail</b></td>
                                                                <td class="h_text" bgcolor="#E2EBF0"><b>State</b></td>
                                                                <td class="h_text" bgcolor="#E2EBF0"><b>City</b></td>
                                                          </tr>
                                                            <?
                                                            while($row=mysql_fetch_array($result_prj))
                                                            {	
                                                            ?>
                                                            <tr class="table_rows">
                                                                <td class="Text01"><?=$sno?></td>
                                                                <td class="Text01"><?=$row['company_name']?></td>
                                                                <td class="Text01"><?=$row['address']?></td>
                                                                <td class="Text01"><?=$row['contact_no']?></td>
                                                                <td class="Text01"><?=$row['state']?></td>
                                                                <td class="Text01"><?=$row['city']?></td>
                                                               
                                                            </tr>
                                                            <?
                                                             $sno++;
                                                            }	
                                                            ?>		       
                                                       </table>
                                                    </td>
                                                </tr>
                                                <?
                                                 }	 
                                                 else
                                                 {
                                                 ?>
                                                 <tr class="table_rows">
                                                    <td align="center" colspan="8">No records found</td>
                                                  </tr>
                                                 <?
                                                  }
                                                  ?> 
                                            </table>
                                            </td>
                                        </tr>
                                    </table>
                                 </td>
                             </tr>
                         </table>
                     </td>
                     <td align="right" valign="top"><img src="images/gredBgRight.jpg" width="10" height="50"/></td>
                </tr>
                <tr>
                	<td align="center" colspan="3"><img src="images/pageBgBottom.jpg" width="1000" height="10"/></td>
                </tr>
              </table>
          </td>
      </tr>
</table>
 <? include ("inc/footer.php"); ?>                    
                                         