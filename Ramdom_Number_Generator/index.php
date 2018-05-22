<?php

function getmillisecond(){
	$milliseconds = round(microtime(true) * 1000);
	return $milliseconds + 10000;
}
/*
for ($i=1000; $i > 0; --$i) { 
	echo getmillisecond()+$i;
	echo "<br>";
}
*/
for ($i=750000; $i < 751000; $i++) { 
	echo $i;
	echo "<br>";
}
// echo "<br>";
// echo "<br>";

?>