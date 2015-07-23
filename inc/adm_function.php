<?php
function redirect($page_name)
{
	echo "<script language='javascript'>";
	echo "document.location='".$page_name."';";
    echo "</script>";
}
?>
<?
function dateDiff($dformat, $endDate, $beginDate)
{
$date_parts1=explode($dformat, $beginDate);
$date_parts2=explode($dformat, $endDate);
$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
return $end_date - $start_date;
}
?>
<?
function dateDiffDB($dformat, $endDate, $beginDate)
{
$date_parts1=explode($dformat,$beginDate);
$date_parts2=explode($dformat,$endDate);
$start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
$end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
return $end_date - $start_date;
}
?>
<?php
///////////Get Date Format///////////
function getDateFormate($date,$format)
{
	$getDateFormate="";
	if($date!="")
	{
		switch($format)
		{
			case 1: 
				$date = explode("-", $date);
				$getDateFormate = $date[2]."-".$date[1]."-".$date[0];
			break;
		}
	}
	return $getDateFormate;
}
?>
<?
function getCategory($FieldName, $WhereFieldName, $WhereValue)
{
	$getCategory="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_category_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getCategory = $row[$FieldName];
	}
	return $getCategory;
}
?>
<?
function getProduct($FieldName, $WhereFieldName, $WhereValue)
{
	$getProduct="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_product_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getProduct = $row[$FieldName];
	}
	return $getProduct;
}
?>
<?
function getCount($FieldName, $WhereFieldName, $WhereValue)
{
	$getCount="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_count_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getCount = $row[$FieldName];
	}
	return $getCount;
}
?>
<?
function checkCountAvailable($id)
{
	$checkCountAvailable = "";
	$sql = "select * from mo_adm_count_master where ProductId = '$id'";
	$result = mysql_query($sql) or die("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$checkCountAvailable = 1;
	}
	else
	{
		$checkCountAvailable = 0;
	}
	return $checkCountAvailable;
}
?>
<?
function getState($id)
{
	$getState="";
	$sql = "SELECT * from mpc_state_master where rec_id = '$id'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getState = $row['state_name'];
	}
	return $getState;
}
?>
<?
function getCity($id)
{
	$getCity="";
	$sql = "SELECT * from mpc_city_master where rec_id = '$id'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getCity = $row['city_name'];
	}
	return $getCity;
}
?>
<?
function getCountry($id)
{
	$getCountry="";
	$sql = "SELECT * from mpc_countries where countries_id = '$id'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getCountry = $row['countries_name'];
	}
	return $getCountry;
}
?>
<?
function getBuyer($FieldName, $WhereFieldName, $WhereValue)
{
	$getBuyer="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_buyer_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getBuyer = $row[$FieldName];
	}
	return $getBuyer;
}
?>
<?
function getDispatchDetail($FieldName, $WhereFieldName, $WhereValue)
{
	$getDispatchDetail="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_dispatch_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getDispatchDetail = $row[$FieldName];
	}
	return $getDispatchDetail;
}
?>
<?
function getDispatchNumber($FieldName, $WhereFieldName, $WhereValue)
{
	$getDispatchNumber="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_dispatch_number where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getDispatchNumber = $row[$FieldName];
	}
	return $getDispatchNumber;
}
?>
<?
function getPINumber($FieldName, $WhereFieldName, $WhereValue)
{
	$getPINumber="";
	$sql = "SELECT ".$FieldName." FROM mo_adm_pi_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getPINumber = $row[$FieldName];
	}
	return $getPINumber;
}
?>
<?
function getPiDetail($FieldName, $WhereFieldName, $WhereValue)
{
	$getPiDetail = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_pi_detail where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getPiDetail = $row[$FieldName];
	}
	return $getPiDetail;
}	
?>
<?
function getDocumentDetail($FieldName, $WhereFieldName, $WhereValue)
{
	$getDocumentDetail = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_document_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getDocumentDetail = $row[$FieldName];
	}
	return $getDocumentDetail;
}	
?>
<?
function getStockDetail($FieldName, $WhereFieldName, $WhereValue)
{
	$getStockDetail = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_stock_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getStockDetail = $row[$FieldName];
	}
	return $getStockDetail;
}
function getStockDetailByDate($FieldName, $WhereFieldName, $WhereValue, $Date)
{
	$getStockDetail = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_stock_master where ".$WhereFieldName." = '".$WhereValue."' and Date = '$Date'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getStockDetail = $row[$FieldName];
	}
	return $getStockDetail;
}

function getOpeningStock($WhereFieldName, $WhereValue, $Date)
{
	$getOpeningStock = 0;
	$sql = "SELECT Sum(StockInKgs) as TotalKgs FROM mo_adm_stock_master where ".$WhereFieldName." = '".$WhereValue."' and Date < '$Date'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getOpeningStock = $row["TotalKgs"];
		
		if($getOpeningStock=="")
		{
			$getOpeningStock = 0;
		}
	}
	return $getOpeningStock;
}


function getStockDetailWithFlag($FieldName, $WhereFieldName, $WhereValue, $Flag)
{
	$getStockDetailWithFlag = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_stock_master where ".$WhereFieldName." = '".$WhereValue."' and Flag = '$Flag'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getStockDetailWithFlag = $row[$FieldName];
	}
	return $getStockDetailWithFlag;
}
function getStockDetailWithFlagAndDate($FieldName, $WhereFieldName, $WhereValue, $Flag, $Date)
{
	$getStockDetailWithFlag = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_stock_master where ".$WhereFieldName." = '".$WhereValue."' and Flag = '$Flag' and Date = '$Date'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getStockDetailWithFlag = $row[$FieldName];
	}
	return $getStockDetailWithFlag;
}	
?>
<?
function getLotDetail($FieldName, $WhereFieldName, $WhereValue)
{
	$getLotDetail = "";
	$sql = "SELECT ".$FieldName." FROM mo_adm_lot_master where ".$WhereFieldName." = '".$WhereValue."'";
	$result = mysql_query ($sql) or die ("Error in : ".$sql."<br>".mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($result)>0)
	{
		$row=mysql_fetch_array($result);
		$getLotDetail = $row[$FieldName];
	}
	return $getLotDetail;
}
?>
<?
 function get_num_name($num){
        switch($num){
        case 1:return 'one';
	    case 2:return 'two';
	    case 3:return 'three';
	    case 4:return 'four';
	    case 5:return 'five';
	    case 6:return 'six';
	    case 7:return 'seven';
	    case 8:return 'eight';
	    case 9:return 'nine';
        }
    }

    function num_to_wordsRS($number, $real_name, $decimal_digit, $decimal_name){
        $res = '';
        $real = 0;
        $decimal = 0;

        if($number == 0)
            return 'Zero'.(($real_name == '')?'':' '.$real_name);
        if($number >= 0){
            $real = floor($number);
            $decimal = round($number - $real, $decimal_digit);
        }else{
            $real = ceil($number) * (-1);
            $number = abs($number);
            $decimal = $number - $real;
        }
        $decimal = (int)str_replace('.','',$decimal);
		$unit_name[0] = '';
        $unit_name[1] = 'thousand';
        $unit_name[2] = 'million';
        $unit_name[3] = 'billion';
        $unit_name[4] = 'trillion';

        $packet = array();	

        $number = strrev($real);
        $packet = str_split($number,3);

        for($i=0;$i<count($packet);$i++){
            $tmp = strrev($packet[$i]);
            $unit = $unit_name[$i];
            if((int)$tmp == 0)
                continue;
            $tmp_res = '';
            if(strlen($tmp) >= 2){
                $tmp_proc = substr($tmp,-2);
                switch($tmp_proc){
                    case '10':
                        $tmp_res = 'ten';
                        break;
                    case '11':
                        $tmp_res = 'eleven';
                        break;
                    case '12':
                        $tmp_res = 'twelve';
                        break;
                    case '13':
                        $tmp_res = 'thirteen';
                        break;
                    case '15':
                        $tmp_res = 'fifteen';
                        break;
                    case '20':
                        $tmp_res = 'twenty';
                        break;
                    case '30':
                        $tmp_res = 'thirty';
                        break;
                    case '40':
                        $tmp_res = 'forty';
                        break;
                    case '50':
                        $tmp_res = 'fifty';
                        break;
                    case '70':
                        $tmp_res = 'seventy';
                        break;
                    case '80':
                        $tmp_res = 'eighty';
                        break;
                    default:
                        $tmp_begin = substr($tmp_proc,0,1);
                        $tmp_end = substr($tmp_proc,1,1);

                        if($tmp_begin == '1')
                            $tmp_res = get_num_name($tmp_end).'teen';
                        elseif($tmp_begin == '0')
                            $tmp_res = get_num_name($tmp_end);
                        elseif($tmp_end == '0')
                            $tmp_res = get_num_name($tmp_begin).'ty';
                        else{
                            if($tmp_begin == '2')
                                $tmp_res = 'twenty';
                            elseif($tmp_begin == '3')
                                $tmp_res = 'thirty';
                            elseif($tmp_begin == '4')
                                $tmp_res = 'forty';
                            elseif($tmp_begin == '5')
                                $tmp_res = 'fifty';
                            elseif($tmp_begin == '6')
                                $tmp_res = 'sixty';
                            elseif($tmp_begin == '7')
                                $tmp_res = 'seventy';
                            elseif($tmp_begin == '8')
                                $tmp_res = 'eighty';
                            elseif($tmp_begin == '9')
                                $tmp_res = 'ninety';

                            $tmp_res = $tmp_res.' '.get_num_name($tmp_end);
                        }
                        break;
                }

                if(strlen($tmp) == 3){
                    $tmp_begin = substr($tmp,0,1);

                    $space = '';
                    if(substr($tmp_res,0,1) != ' ' && $tmp_res != '')
                        $space = ' ';

                    if($tmp_begin != 0){
                        if($tmp_begin != '0'){
                            if($tmp_res != '')
                                $tmp_res = 'and'.$space.$tmp_res;
                        }
                        $tmp_res = get_num_name($tmp_begin).' hundred'.$space.$tmp_res;
                    }
                }
            }else
                $tmp_res = get_num_name($tmp);
            $space = '';
            if(substr($res,0,1) != ' ' && $res != '')
                $space = ' ';
            $res = $tmp_res.' '.$unit.$space.$res;
        }

        $space = '';
        if(substr($res,-1) != ' ' && $res != '')
            $space = ' ';

        $res .= $space.$real_name.(($real > 1 && $real_name != '')?'s':'');

        if($decimal > 0)
            $res .= ' '.num_to_wordsRS($decimal, '', 0, '').' '.$decimal_name.(($decimal > 1 && $decimal_name != '')?'s':'');
        return ucfirst($res);
    }
?>
<?
 function get_num_name1($num){
        switch($num){
        case 1:return 'one';
	    case 2:return 'two';
	    case 3:return 'three';
	    case 4:return 'four';
	    case 5:return 'five';
	    case 6:return 'six';
	    case 7:return 'seven';
	    case 8:return 'eight';
	    case 9:return 'nine';
        }
    }

    function num_to_wordsDoller($number, $real_name, $decimal_digit, $decimal_name){
        $res = '';
        $real = 0;
        $decimal = 0;

        if($number == 0)
            return 'Zero'.(($real_name == '')?'':' '.$real_name);
        if($number >= 0){
            $real = floor($number);
            $decimal = round($number - $real, $decimal_digit);
        }else{
            $real = ceil($number) * (-1);
            $number = abs($number);
            $decimal = $number - $real;
        }
        $decimal = (int)str_replace('.','',$decimal);
		$unit_name[0] = '';
        $unit_name[1] = 'thousand';
        $unit_name[2] = 'million';
        $unit_name[3] = 'billion';
        $unit_name[4] = 'trillion';

        $packet = array();	

        $number = strrev($real);
        $packet = str_split($number,3);

        for($i=0;$i<count($packet);$i++){
            $tmp = strrev($packet[$i]);
            $unit = $unit_name[$i];
            if((int)$tmp == 0)
                continue;
            $tmp_res = '';
            if(strlen($tmp) >= 2){
                $tmp_proc = substr($tmp,-2);
                switch($tmp_proc){
                    case '10':
                        $tmp_res = 'ten';
                        break;
                    case '11':
                        $tmp_res = 'eleven';
                        break;
                    case '12':
                        $tmp_res = 'twelve';
                        break;
                    case '13':
                        $tmp_res = 'thirteen';
                        break;
                    case '15':
                        $tmp_res = 'fifteen';
                        break;
                    case '20':
                        $tmp_res = 'twenty';
                        break;
                    case '30':
                        $tmp_res = 'thirty';
                        break;
                    case '40':
                        $tmp_res = 'forty';
                        break;
                    case '50':
                        $tmp_res = 'fifty';
                        break;
                    case '70':
                        $tmp_res = 'seventy';
                        break;
                    case '80':
                        $tmp_res = 'eighty';
                        break;
                    default:
                        $tmp_begin = substr($tmp_proc,0,1);
                        $tmp_end = substr($tmp_proc,1,1);

                        if($tmp_begin == '1')
                            $tmp_res = get_num_name1($tmp_end).'teen';
                        elseif($tmp_begin == '0')
                            $tmp_res = get_num_name1($tmp_end);
                        elseif($tmp_end == '0')
                            $tmp_res = get_num_name1($tmp_begin).'ty';
                        else{
                            if($tmp_begin == '2')
                                $tmp_res = 'twenty';
                            elseif($tmp_begin == '3')
                                $tmp_res = 'thirty';
                            elseif($tmp_begin == '4')
                                $tmp_res = 'forty';
                            elseif($tmp_begin == '5')
                                $tmp_res = 'fifty';
                            elseif($tmp_begin == '6')
                                $tmp_res = 'sixty';
                            elseif($tmp_begin == '7')
                                $tmp_res = 'seventy';
                            elseif($tmp_begin == '8')
                                $tmp_res = 'eighty';
                            elseif($tmp_begin == '9')
                                $tmp_res = 'ninety';

                            $tmp_res = $tmp_res.' '.get_num_name1($tmp_end);
                        }
                        break;
                }

                if(strlen($tmp) == 3){
                    $tmp_begin = substr($tmp,0,1);

                    $space = '';
                    if(substr($tmp_res,0,1) != ' ' && $tmp_res != '')
                        $space = ' ';

                    if($tmp_begin != 0){
                        if($tmp_begin != '0'){
                            if($tmp_res != '')
                                $tmp_res = 'and'.$space.$tmp_res;
                        }
                        $tmp_res = get_num_name1($tmp_begin).' hundred'.$space.$tmp_res;
                    }
                }
            }else
                $tmp_res = get_num_name1($tmp);
            $space = '';
            if(substr($res,0,1) != ' ' && $res != '')
                $space = ' ';
            $res = $tmp_res.' '.$unit.$space.$res;
        }

        $space = '';
        if(substr($res,-1) != ' ' && $res != '')
            $space = ' ';

        $res .= $space.$real_name.(($real > 1 && $real_name != '')?'s':'');

        if($decimal > 0)
            $res .= ' '.num_to_wordsDoller($decimal, '', 0, '').' '.$decimal_name.(($decimal > 1 && $decimal_name != '')?'s':'');
        return ucfirst($res);
    }
?>
<?php
 $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred &','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
function no_to_words($no)
{    global $words;
    if($no == 0)
        return ' ';
    else {           $novalue='';$highno=$no;$remainno=0;$value=100;$value1=1000;       
            while($no>=100)    {
                if(($value <= $no) &&($no  < $value1))    {
				
                if(isset($words["$value"]))
				{
					$novalue=$words["$value"];
                }
				$highno = (int)($no/$value);
                $remainno = $no % $value;
                break;
                }
                $value= $value1;
                $value1 = $value * 100;
            }       
          if(array_key_exists("$highno",$words))
              return $words["$highno"]." ".$novalue." ".no_to_words($remainno);
          else {
             $unit=$highno%10;
             $ten =(int)($highno/10)*10;            
             return $words["$ten"]." ".$words["$unit"]." ".$novalue." ".no_to_words($remainno);
           }
    }
}
//echo no_to_words(1999978987);
?>