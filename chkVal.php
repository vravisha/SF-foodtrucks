<?php
$selected=$_POST['select1'];
if($selected == "Select a Location")
	$selected = "";
header ("Location: index.php?select1=$selected");
?>
