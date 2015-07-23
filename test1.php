<?
/*$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
echo $tomorrow;
echo date("l",$tomorrow); 
$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"));
echo date("l",$tomorrow); 
?>
<?
$year1 = '2010';
$month1 = '04';
$day1 = '01';

$day1 = $day1 + 1;

$year2 = '2010';
$month2 = '04';
$day2 = '01';

$start_date = "$year1-$month1-$day1";
$end_date = "$year2-$month2-$day2";

$date = mktime(0,0,0,$month1,$day1,$year1); //Gets Unix timestamp START DATE
$date1 = mktime(0,0,0,$month2,$day2,$year2); //Gets Unix timestamp END DATE
$difference = $date1-$date; //Calcuates Difference
$daysago = floor($difference /60/60/24); //Calculates Days Old

$i = 0;
while ($i <= $daysago +1) {
if ($i != 0) { $date = $date + 86400; }
else { $date = $date - 86400; }
$today = date('Y-m-d',$date);
//echo "$today ";

$yy = date('Y',$date);
$mm = date('m',$date);
$dd = date('d',$date);

echo "$yy-$mm-$dd ";

$i++;
}*/
?>
<!--<head>
    <style>
        .forPrint {
            visibility: visible;
            color: red;
        }

        .forScreen {
            visibility: hidden;
        }
    </style>
    <script>
        window.onbeforeprint = BeforePrint;
        window.onafterprint = AfterPrint;
        
        function BeforePrint () {
            var div = document.getElementById ("myDiv");
            div.className = "forPrint";
        }

        function AfterPrint () {
            var div = document.getElementById ("myDiv");
            div.className = "forScreen";
        }

        function Print () {
            window.print ();
        }
    </script>
</head>
<body>
    <div id="myDiv" class="forScreen">This text is only visible for printing.</div>
        <script>
		function abc{
		 var div = document.getElementById ("myDiv");
		 if(div.className=='forScreen')
			{
			alert("0");
			}
			}
		</script>
    <button onClick="Print();">Print this page.</button>
</body>-->
<?
	echo date("Y-m-d");
?>