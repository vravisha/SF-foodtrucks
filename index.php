<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>SF: Food Trucks</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<link rel="stylesheet" type="text/css" href="css/site.css"/>
<script src="js/jquery.min.js"></script>
<script src="js/mapScript.js"></script>
<script src="js/getLoc.js"></script>
<script> getLocation(); </script>
<?php	

	$selected = "";
	$values = [];		
	$query = "SELECT distinct(locationDescription), Applicant, Latitude, Longitude from food_trucks";
	$cols = ['Applicant','Latitude','Longitude','locationDescription'];
	$loc = true;
	$list = getData($query, $values, $cols, $loc);
	$values = $list;
	
	/*function to get data from database 
	/*input:  query, array to store result, array of columns, boolean loc - true if it contains location info
	/*output: array of values ro be used by javascript
	*/
	function getData($query, $values, $cols, $loc){

		// Create connection
		$con=mysqli_connect("sql303.byethost13.com","b13_15178092","testUber","b13_15178092_uber");
		
		// Check connection
		if (mysqli_connect_errno()) {
		  Print "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$status = mysqli_query($con, $query);	
		$i=0;		
		
		//Loop through the data	
		while($row = mysqli_fetch_array($status)) {
			$point = "";
			
			//check if latitude column is passed in query and if rows have latitude information, some did not have
			if(($loc && ($row['Latitude'] != "")) || (!$loc))
			{			  
			  	for($j=0;$j<sizeof($cols)-1;$j++)
			  		$point = $point . $row[$cols[$j]] . ";";
				
			  	$point = $point . $row[$cols[$j]];			  	
			  	$values[$i] = $point;
			  	$i++;
		  	}
		}
		
		return $values;
		mysqli_close($con);	
	}				
?>
</head>

<body>
<div id="header">
	<div id="masthead">
		<a href="index.php"><img src="images/logo.jpg" alt="logo" /></a>
		<h1>SF Food Trucks</h1>					
	</div>
</div>

<div id="main" align="center">
	<div id="content" align="center"><br/>	
	<form id="myform" method="POST" action="chkVal.php">	
		<p id="demo" style="display:block"></p>
		<?php	
			//get selected value
			if(isset($_GET['select1']))
				$selected = $_GET['select1'];		
			
			//build the dropdown list
			echo "<select name=select1>";
			$val = "";			
			echo "<option>Select a Location</option>";
			foreach($list as $dt) {				
				$arr = explode(";", $dt);
				echo "<option". (($selected === $arr[3]) ? ' selected="selected"' : $val) . ">" . $arr[3] . "</option>";			
			}
			echo "</select>";
		?>
		&nbsp;<input type="submit" value="Find food"/><br/>
	</form>
	
	<!--get data for selected location information -->
	<?php 
		if (isset($_GET['select1']) && ($_GET['select1'] != "")) {
			
			//To make a compromise between number of locations and those which are near to each other, 
			//I selected block information to select food trucks which are present in the same block as the location selected
			//I played with different column information and found that block gave the best info
			
	        $query = "SELECT block from food_trucks WHERE LocationDescription = '".$_GET['select1']."'";
	        $cols = ['block'];
	        $loc = false;
	        $arr = [];
	        $res = getData($query,$arr,$cols, $loc);	
	        
	        //From block get location and info from food trucks in that block
	        if (sizeof($res)> 0) {
		        
		        //get location data of all food trucks with the same block as the one selected
		        $query = "SELECT Applicant, Latitude, Longitude, Address, FoodItems from food_trucks WHERE block='".$res[0]."'";
				$cols = ['Applicant','Latitude','Longitude','Address','FoodItems'];
				$loc = true;
				$arr = [];
				$values = getData($query, $arr, $cols, $loc);
				
				//Check for null values			
				if (sizeof($values) == 0) 
					echo "<h2>No food trucks found :( <br/> Select another location</h2>";
			}
			//Check for null values			
			else
				echo "<h2>No food trucks found :( <br/> Select another location</h2>";
		}		
    ?>    
	<script> 
		//pass data captured from db to javascript to render the map with locations
		var data = <?php echo json_encode($values);?>;		
		var x = document.getElementById("demo");
		var loc = x.innerHTML;
		
		if(data.length > 0)
			markers = data;		
		
	</script><br/>
	
		<!-- render map -->
		<div id="map_wrapper">
			<div id="map_canvas" class="mapping"></div>
		</div><br/>
	</div>
</div>
<!-- Footer -->	
	<div id="footer"><p>2014 &copy; VIJAY </p> </div>
	
</body>
</html>


