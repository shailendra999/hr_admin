<?php
$transport = array('1', '2', '3', '6','7','8');
$first = $transport[0];
//$last = end($transport);

echo $first;
for($i = 0; $i<= count($transport); $i++)
{
	$next = next($transport);
	
	if($first+1 == $next)
	{
		$last = $next;
	}
	else
	{
		echo $first = $next;
	}
	
}

?> 