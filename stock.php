<!DOCTYPE html>
<html>

<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
</style>
</head>

<body>

    <div class="body-content" style="text-align: center; padding: 15em;">
        <div style="margin-bottom: 3em;">

			<h1><i>Stock Search</i></h1>

			<form method="POST" action="">
				<label for="input">Company Name or Symbol: </label>
				<input type="text" id="input" name="input" placeholder="Enter company name e.g. Apple"
				required pattern="^[a-zA-Z0-9][a-zA-Z0-9 ]*$" 
				value="<?php if (isset($_POST["input"])) echo htmlspecialchars($_POST['input']); ?>" > </input>
				<br />
				<input type="submit" value="Search" autofocus></input>
				<input type="reset" value="Clear"></input>
				<br />	
			</form>
			<a href="http://www.markit.com/product/markit-on-demand">Powered by Markit on Demand</a>
		</div>
	</div>

	<?php
		if(isset($_POST["input"])){
			print_r($_POST);			
		} else {
			echo "ccc";
		}
		

		/* Output debugging data */
		// $xml = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=APPL");
		// echo "<br />";
		// print_r($xml);

		/* XML */
		$xmlElement = simplexml_load_file('http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=' . $_POST["input"]);	 
		echo "<br /><br />";
	    
	    if ($xmlElement->count() == 0) {
		    //it's empty
		    echo "No Record has been found";
		    echo "<br />";
		    // print_r($xmlElement);
		}
		else {
		    //XML object has children
		    echo "no empty";

		    echo "<br />";

		    echo '<table style="width:100%">';
		    echo '<tr><th>Name</th><th>Symbol</th><th>Exchange</th><th>Details</th></tr>';

		    foreach ($xmlElement->LookupResult as $result) {
		    	echo '<tr>';
			   // print_r($result);
		    	echo '<th>' . $result->Name . '</th>';
		    	echo '<th>' . $result->Symbol . '</th>';
		    	echo '<th>' . $result->Exchange . '</th>';
		    	echo '<th>' . '<a href="http://www.nba.com\">More Info</a>' . '</th>';

			   echo "<br />";
			   echo '</tr>';
			}
			echo "</table>";


		    // print_r($xmlElement);
		}

	 //    echo "<br /><br />";
	 //    print_r($xmlElement->Status);

		// /* JSON */
		// $json = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=AAPL");
		// echo "<br /><br />";
		// print_r($json);		
	?>	

</body>
</html>