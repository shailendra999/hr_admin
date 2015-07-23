<?
$year=$_GET['id'];
$current_year=date('Y');
if($year=$_GET['id']==$current_year)
{
   $last_month=date('n');
   $month=$last_month;
}
else
{
   $last_month=12;
   $month=01;
}
?>
<select id="month" name="month" style="width:150px; height:20px;">
		<?
         for($i=01;$i<=$last_month;$i++)
         {
           $j=sprintf("%02d",$i);
         ?>
          <option value="<?=$j?>"><?=date("F",mktime(0, 0, 0,$i, 1, 0))?></option>
          <?
          }
          ?>
 </select>
