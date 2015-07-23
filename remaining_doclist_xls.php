<?
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=domestic_dispatch_excel.xls");
?>
<?
include("inc/check_session.php");
include('inc/dbconnection.php');
include('inc/adm_function.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table align="center" width="100%" border="1" cellpadding="1" cellspacing="1">
    <tr>
        <td align="center" class="gredBg"><b>PI Number</b></td>
        <td align="center" class="gredBg"><b>Invoice Number</b></td>
        <td align="center" class="gredBg"><b>Buyer</b></td>

    </tr>
    <?
    $sql_dn = "select * from mo_adm_dispatch_number";
    $result_dn = mysql_query($sql_dn)or die("Error in Query: ".$sql_dn."<br/>".mysql_error()."<br/>".mysql_errno());
    if(mysql_num_rows($result_dn)>0)
    {
        $sno = 1;
        while($row_dn = mysql_fetch_array($result_dn))
        {
            $sql_1 = "select dm.rec_id , dm.PiId , dm.DispatchNumberId from mo_adm_dispatch_master as dm where dm.DispatchNumberId = '".$row_dn["rec_id"]."'";
            $result_1 = mysql_query($sql_1)or die("Error in Query: ".$sql_1."<br/>".mysql_error()."<br/>".mysql_errno());
            if(mysql_num_rows($result_1)>0)
            {
                $row_1 = mysql_fetch_array($result_1);
                
    ?>
    <tr>
        <td align="center"><?=getPINumber('PiNumber','rec_id',$row_1['PiId'])?></td>
        <td align="center"><?=$row_dn['DispatchNumber']?></td>
        <td align="center" class="text_1"><?=getBuyer('BuyerName','rec_id',getDispatchNumber('BuyerId','rec_id',$row_1['DispatchNumberId']))?></td>
    </tr>
    <?
            }
    ?>
    <tr>
        <td align="center" colspan="4">
            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                <?
                $sql = "select ddl.rec_id , ddl.DispatchMasterId , ddl.DocId , ddl.DocStatus , ddl.DocDate , dm.rec_id , dm.PiId , dm.DispatchNumberId from mo_adm_despatch_doclist as ddl , mo_adm_dispatch_master as dm where ddl.DocStatus = '0' and ddl.DispatchMasterId = dm.rec_id and dm.DispatchNumberId = '".$row_dn["rec_id"]."'";
                $result = mysql_query($sql)or die("Error in Query: ".$sql."<br/>".mysql_error()."<br/>".mysql_errno());
                if(mysql_num_rows($result)>0)
                {
                    while($row = mysql_fetch_array($result))
                    //$row = mysql_fetch_array($result);
                    {
                ?>
                    <td class="tableText"><?=getDocumentDetail('DocumentName','rec_id',$row['DocId'])?></td>
                <?                                            		
                    }	
                }
                ?>
                </tr>
            </table>
            
        </td>
    </tr>            
    <tr>
        <td align="center" colspan="4">
            <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                <?
                $sql_1 = "select bm.rec_id , bm.BuyerName , docm.rec_id , docm.DocumentName , docm.DocumentFor , dn.rec_id , dn.DispatchNumber from mo_adm_buyer_master as bm , mo_adm_dispatch_number as dn , mo_adm_document_master as docm where bm.BuyerType = docm.DocumentFor and dn.BuyerId = bm.rec_id and dn.rec_id = '".$row_dn["rec_id"]."' order by dn.rec_id ";
                $result_1 = mysql_query($sql_1)or die("Error in Query: ".$sql_1."<br/>".mysql_error()."<br/>".mysql_errno());
                if(mysql_num_rows($result_1)>0)
                {
                    while($row_1 = mysql_fetch_array($result_1))
                    //$row_1 = mysql_fetch_array($result_1);
                    {
                        $DocStatus = 0;
                        $DispatchMasterId = getDispatchDetail('rec_id','DispatchNumberId',$row_1["rec_id"]);
                        
                        $sql_2 = "select * from mo_adm_despatch_doclist  where DispatchMasterId = '$DispatchMasterId'";
                        
                        $result_2 = mysql_query($sql_2)or die("Error in Query: ".$sql_2."<br/>".mysql_error()."<br/>".mysql_errno());
                        
                        if(mysql_num_rows($result_2) == 0)
                        {
                        ?>
                    <td class="tableText"><?=$row_1['DocumentName']?></td>
                        <?
                        }
                    }
                }
                ?>
                </tr>
            </table>
        </td>
    </tr>     
    <?
        }
    }
    ?>             
</table>
</div>
</td>
</tr>               
</table>
</body>
</html>